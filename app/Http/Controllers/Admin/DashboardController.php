<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Location;
use App\Models\Rental;
use App\Models\TimeSlot;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $now = Carbon::now();

        // ─── OPERATIONAL STATS ────────────────────────────────────────
        $totalCars       = Car::count();
        $availableCars   = Car::where('status', 'available')->count();
        $rentedCars      = Car::where('status', 'rented')->count();
        $maintenanceCars = Car::where('status', 'maintenance')->count();
        $activeBookings  = Rental::whereIn('status', ['active', 'confirmed'])->count();

        // ─── ACTIVE BOOKINGS TABLE ────────────────────────────────────
        $activeRentals = Rental::with(['car'])
            ->whereIn('status', ['active', 'confirmed', 'pending'])
            ->orderByRaw("CASE WHEN status = 'active' THEN 1 WHEN status = 'confirmed' THEN 2 WHEN status = 'pending' THEN 3 ELSE 4 END")
            ->orderBy('start_date')
            ->get();

        // ─── UPCOMING SCHEDULE (next 7 days) ─────────────────────────
        $today   = $now->copy()->startOfDay();
        $in7Days = $now->copy()->addDays(7)->endOfDay();

        $upcomingSchedule = Rental::with(['car'])
            ->whereIn('status', ['confirmed', 'active', 'pending'])
            ->where(function ($q) use ($today, $in7Days) {
                $q->whereBetween('start_date', [$today, $in7Days])
                  ->orWhereBetween('end_date', [$today, $in7Days])
                  ->orWhere(function ($q2) use ($today, $in7Days) {
                      $q2->where('start_date', '<=', $today)
                         ->where('end_date', '>=', $in7Days);
                  });
            })
            ->orderBy('start_date')
            ->get();

        // Build 7-day strip
        $scheduleStrip = collect(range(0, 6))->map(function ($i) use ($today, $upcomingSchedule) {
            $day = $today->copy()->addDays($i);
            $bookingsForDay = $upcomingSchedule->filter(function ($rental) use ($day) {
                return $rental->start_date <= $day && $rental->end_date >= $day;
            });
            return [
                'date'     => $day,
                'bookings' => $bookingsForDay,
            ];
        });

        // ─── RECENT COMPLETED/CANCELLED (last 5) ─────────────────────
        $recentBookings = Rental::with(['car'])
            ->whereIn('status', ['completed', 'cancelled'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalCars',
            'availableCars',
            'rentedCars',
            'maintenanceCars',
            'activeBookings',
            'activeRentals',
            'scheduleStrip',
            'recentBookings',
        ));
    }

    /**
     * Quick-confirm a booking via POST.
     */
    public function confirmBooking(Rental $rental)
    {
        if ($rental->status === 'pending') {
            $rental->update([
                'status'       => 'confirmed',
                'confirmed_at' => now(),
            ]);
        }

        return back()->with('success', "Booking {$rental->booking_code} has been confirmed.");
    }

    /**
     * Quick-cancel a booking via POST.
     */
    public function cancelBooking(Rental $rental)
    {
        if (in_array($rental->status, ['pending', 'confirmed'])) {
            $rental->update([
                'status'       => 'cancelled',
                'cancelled_at' => now(),
            ]);
        }

        return back()->with('success', "Booking {$rental->booking_code} has been cancelled.");
    }
}
