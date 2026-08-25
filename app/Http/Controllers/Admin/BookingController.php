<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Location;
use App\Models\Rental;
use App\Models\Revenue;
use App\Models\TimeSlot;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class BookingController extends Controller
{
    /**
     * Display a listing of the bookings.
     */
    public function index(Request $request)
    {
        $query = Rental::with('car');

        // Tab filter
        $status = $request->query('status', 'semua');
        if ($status !== 'semua') {
            $query->where('status', $status);
        }

        // Search by name/code/phone
        if ($search = $request->query('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('booking_code', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_phone', 'like', "%{$search}%");
            });
        }

        // Car filter
        if ($carId = $request->query('car_id')) {
            $query->where('car_id', $carId);
        }

        // Date range picker filter
        if ($dateRange = $request->query('date_range')) {
            $dates = explode(' to ', $dateRange);
            if (count($dates) === 2) {
                $start = Carbon::parse($dates[0])->startOfDay();
                $end = Carbon::parse($dates[1])->endOfDay();

                $query->where(function ($q) use ($start, $end) {
                    $q->whereBetween('start_date', [$start, $end])
                      ->orWhereBetween('end_date', [$start, $end])
                      ->orWhere(function ($q2) use ($start, $end) {
                          $q2->where('start_date', '<=', $start)
                             ->where('end_date', '>=', $end);
                      });
                });
            }
        }

        // Sorting
        $sort = $request->query('sort', 'created_at');
        $direction = $request->query('direction', 'desc');

        $validSorts = [
            'booking_code' => 'booking_code',
            'customer' => 'customer_name',
            'mula' => 'start_date',
            'tamat' => 'end_date',
            'hari' => 'total_days',
            'jumlah' => 'total_amount',
            'status' => 'status',
            'created_at' => 'created_at'
        ];

        if (array_key_exists($sort, $validSorts)) {
            $query->orderBy($validSorts[$sort], $direction);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $bookings = $query->paginate(15)->withQueryString();
        $cars = Car::orderBy('name')->get();

        return view('admin.bookings.index', compact('bookings', 'cars', 'status', 'sort', 'direction'));
    }

    /**
     * Show the form to create an active booking from admin.
     */
    public function create()
    {
        $cars      = Car::whereNotIn('status', ['hidden', 'maintenance'])->orderBy('name')->get();
        $locations = Location::active()->orderBy('sort_order')->get();
        $timeSlots = TimeSlot::active()->orderBy('sort_order')->get();

        return view('admin.bookings.create', compact('cars', 'locations', 'timeSlots'));
    }

    /**
     * Store an admin-created active booking.
     */
    public function adminStore(Request $request)
    {
        $validated = $request->validate([
            'customer_name'   => 'required|string|max:255',
            'customer_phone'  => 'required|string|max:50',
            'car_id'          => 'required|exists:cars,id',
            'pickup_location' => 'required|string|max:255',
            'start_date'      => 'required|date|after_or_equal:today',
            'start_time'      => 'required|string',
            'end_date'        => 'required|date|after_or_equal:start_date',
            'end_time'        => 'required|string',
            'admin_notes'     => 'nullable|string|max:2000',
        ]);

        $car       = Car::findOrFail($validated['car_id']);
        $startDate = Carbon::parse($validated['start_date']);
        $endDate   = Carbon::parse($validated['end_date']);
        $totalDays = max(1, $startDate->diffInDays($endDate));

        // Conflict detection — check for overlapping active/confirmed bookings
        $conflict = Rental::where('car_id', $car->id)
            ->whereIn('status', ['confirmed', 'active'])
            ->where(function ($q) use ($startDate, $endDate) {
                $q->where('start_date', '<=', $endDate)
                  ->where('end_date', '>=', $startDate);
            })
            ->first();

        if ($conflict) {
            return back()
                ->withInput()
                ->withErrors([
                    'car_id' => "This vehicle already has an active booking ({$conflict->booking_code}) for the selected period.",
                ]);
        }

        $pricePerDay  = $car->price_per_day;
        $totalAmount  = $pricePerDay * $totalDays;
        $depositPaid  = $car->deposit_amount ?? 0;
        $balanceDue   = max(0, $totalAmount - $depositPaid);

        $rental = Rental::create([
            'car_id'           => $car->id,
            'customer_name'    => $validated['customer_name'],
            'customer_phone'   => $validated['customer_phone'],
            'start_date'       => $validated['start_date'],
            'end_date'         => $validated['end_date'],
            'total_days'       => $totalDays,
            'price_per_day'    => $pricePerDay,
            'total_amount'     => $totalAmount,
            'deposit_paid'     => $depositPaid,
            'balance_due'      => $balanceDue,
            'status'           => 'confirmed',
            'pickup_location'  => $validated['pickup_location'],
            'dropoff_location' => $validated['pickup_location'],
            'admin_notes'      => $validated['admin_notes'] ?? null,
            'confirmed_at'     => now(),
        ]);

        // Store the time information in admin_notes if needed
        $timeNote = "Pickup: {$validated['start_time']} | Return: {$validated['end_time']}";
        if ($rental->admin_notes) {
            $rental->admin_notes = $timeNote . "\n" . $rental->admin_notes;
        } else {
            $rental->admin_notes = $timeNote;
        }
        $rental->save();

        return redirect()
            ->route('admin.bookings.show', $rental->id)
            ->with('success', "Booking {$rental->booking_code} created successfully.");
    }

    /**
     * Helper to resolve rental model.

     */
    private function resolveRental($id): Rental
    {
        return ($id instanceof Rental) ? $id : Rental::findOrFail($id);
    }

    /**
     * Display the specified booking.
     */
    public function show($id)
    {
        $rental = $this->resolveRental($id);
        $rental->load('car');

        // Smart Conflict Detection: Check if car is already booked
        $conflict = Rental::where('car_id', $rental->car_id)
            ->where('id', '!=', $rental->id)
            ->whereIn('status', ['confirmed', 'active'])
            ->where(function ($q) use ($rental) {
                $q->where('start_date', '<=', $rental->end_date)
                  ->where('end_date', '>=', $rental->start_date);
            })
            ->first();

        return view('admin.bookings.show', compact('rental', 'conflict'));
    }

    /**
     * Confirm a booking.
     */
    public function confirm($id)
    {
        $rental = $this->resolveRental($id);

        $conflict = Rental::where('car_id', $rental->car_id)
            ->where('id', '!=', $rental->id)
            ->whereIn('status', ['confirmed', 'active'])
            ->where(function ($q) use ($rental) {
                $q->where('start_date', '<=', $rental->end_date)
                  ->where('end_date', '>=', $rental->start_date);
            })
            ->first();

        $rental->update([
            'status' => 'confirmed',
            'confirmed_at' => now(),
        ]);

        $message = "Tempahan {$rental->booking_code} telah disahkan.";
        if ($conflict) {
            return back()->with('success', $message)->with('error', "⚠️ Amaran: Kereta ini mempunyai tempahan bertindih dengan {$conflict->booking_code}!");
        }

        return back()->with('success', $message);
    }

    /**
     * Start the rental.
     */
    public function start($id)
    {
        $rental = $this->resolveRental($id);

        $rental->update([
            'status' => 'active',
            'started_at' => now(),
        ]);

        $rental->car->update(['status' => 'rented']);

        return back()->with('success', "Sewa untuk tempahan {$rental->booking_code} telah dimulakan.");
    }

    /**
     * Complete the rental.
     */
    public function complete($id)
    {
        $rental = $this->resolveRental($id);

        $rental->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);

        $rental->car->update(['status' => 'available']);

        // Auto-create revenue entry
        Revenue::create([
            'rental_id' => $rental->id,
            'car_id' => $rental->car_id,
            'type' => 'rental',
            'amount' => $rental->total_amount,
            'description' => "Bayaran sewa penuh kereta {$rental->car->name} ({$rental->booking_code})",
            'revenue_date' => now()->toDateString(),
        ]);

        return back()->with('success', "Tempahan {$rental->booking_code} telah diselesaikan dan rekod kewangan telah dijana.");
    }

    /**
     * Cancel a booking.
     */
    public function cancel(Request $request, $id)
    {
        $rental = $this->resolveRental($id);

        $request->validate([
            'reason' => 'required|string|max:1000',
        ]);

        $status = $request->has('mark_refund') ? 'refunded' : 'cancelled';
        $reason = $request->input('reason');

        $newNotes = "Sebab Batal: {$reason}";
        if ($rental->admin_notes) {
            $newNotes .= "\n---\n" . $rental->admin_notes;
        }

        $rental->update([
            'status' => $status,
            'cancelled_at' => now(),
            'admin_notes' => $newNotes,
        ]);

        // Release car back to available if it was active
        if ($rental->status === 'active') {
            $rental->car->update(['status' => 'available']);
        }

        // If marked refund, record negative revenue entry
        if ($status === 'refunded') {
            Revenue::create([
                'rental_id' => $rental->id,
                'car_id' => $rental->car_id,
                'type' => 'refund',
                'amount' => -$rental->deposit_paid,
                'description' => "Refund deposit sewaan ({$rental->booking_code}) - Sebab: {$reason}",
                'revenue_date' => now()->toDateString(),
            ]);
        }

        return back()->with('success', "Tempahan {$rental->booking_code} telah dibatalkan (" . ($status === 'refunded' ? 'Dipulangkan' : 'Tanpa Refund') . ").");
    }

    /**
     * Auto-save admin notes.
     */
    public function updateNotes(Request $request, $id)
    {
        $rental = $this->resolveRental($id);

        $rental->update([
            'admin_notes' => $request->input('admin_notes'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Nota admin berjaya disimpan secara automatik.'
        ]);
    }

    /**
     * Generate PDF Receipt.
     */
    public function receipt($id)
    {
        $rental = $this->resolveRental($id);
        $rental->load('car');

        $pdf = Pdf::loadView('admin.bookings.receipt', compact('rental'));

        return $pdf->download("Resit-{$rental->booking_code}.pdf");
    }

    /**
     * Update booking status directly.
     */
    public function updateStatus(Request $request, $id)
    {
        $rental = $this->resolveRental($id);
        $status = $request->input('status');

        switch ($status) {
            case 'confirmed':
                return $this->confirm($rental);
            case 'active':
                return $this->start($rental);
            case 'completed':
                return $this->complete($rental);
            case 'cancelled':
                return $this->cancel($request, $rental);
            default:
                $rental->update(['status' => $status]);
                return back()->with('success', "Status tempahan {$rental->booking_code} telah dikemaskini.");
        }
    }

    /**
     * Show calendar view page.
     */
    public function calendar()
    {
        return view('admin.bookings.calendar');
    }
}
