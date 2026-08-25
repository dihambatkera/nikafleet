<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\ContactMessage;
use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    /**
     * Store a new booking (guest booking)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'car_id'          => 'required|exists:cars,id',
            'customer_name'   => 'required|string|max:100',
            'customer_phone'  => 'required|string|max:20',
            'start_date'      => 'required|date|after_or_equal:today',
            'end_date'        => 'required|date|after:start_date',
            'customer_notes'  => 'nullable|string|max:500',
        ]);

        $car = Car::findOrFail($validated['car_id']);

        if ($car->status !== 'available') {
            return back()->withErrors(['car_id' => 'Kereta ini tidak tersedia sekarang.'])->withInput();
        }

        $startDate = \Carbon\Carbon::parse($validated['start_date']);
        $endDate   = \Carbon\Carbon::parse($validated['end_date']);
        $totalDays = $startDate->diffInDays($endDate);

        if ($totalDays < 1) {
            return back()->withErrors(['end_date' => 'Tarikh tamat mesti sekurang-kurangnya 1 hari selepas tarikh mula.'])->withInput();
        }

        $totalAmount = $totalDays * $car->price_per_day;
        $depositPaid = $car->deposit_amount ?? 0;
        $balanceDue  = $totalAmount - $depositPaid;

        // Generate unique booking code
        do {
            $code = 'NF-' . strtoupper(Str::random(8));
        } while (Rental::where('booking_code', $code)->exists());

        $rental = Rental::create([
            'user_id'         => null,
            'car_id'          => $car->id,
            'booking_code'    => $code,
            'customer_name'   => $validated['customer_name'],
            'customer_phone'  => $validated['customer_phone'],
            'start_date'      => $validated['start_date'],
            'end_date'        => $validated['end_date'],
            'total_days'      => $totalDays,
            'price_per_day'   => $car->price_per_day,
            'total_amount'    => $totalAmount,
            'deposit_paid'    => $depositPaid,
            'balance_due'     => $balanceDue,
            'status'          => 'pending',
            'pickup_location' => $car->location,
            'customer_notes'  => $validated['customer_notes'],
        ]);

        return redirect()->route('bookings.confirm', $rental->booking_code)->with('success', 'Tempahan anda telah berjaya dihantar! Sila klik butang di bawah untuk menghantar pengesahan WhatsApp.');
    }

    /**
     * Show booking confirmation page
     */
    public function confirm(string $code)
    {
        $rental = Rental::where('booking_code', $code)
            ->with('car.images')
            ->firstOrFail();

        return view('user.booking-confirm', compact('rental'));
    }

}
