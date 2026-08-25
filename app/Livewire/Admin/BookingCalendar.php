<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Rental;
use App\Models\Car;
use Carbon\Carbon;

class BookingCalendar extends Component
{
    public function render()
    {
        // Fetch all rentals with cars
        $rentals = Rental::with('car')
            ->whereIn('status', ['pending', 'confirmed', 'active', 'completed'])
            ->get();

        // Preset colors for different cars
        $colors = [
            '#3B82F6', // Blue
            '#10B981', // Green
            '#F59E0B', // Amber
            '#EC4899', // Pink
            '#8B5CF6', // Purple
            '#06B6D4', // Cyan
            '#EF4444', // Red
        ];

        // Unique car IDs to assign colors
        $carIds = $rentals->pluck('car_id')->unique()->values()->toArray();
        $carColorMap = [];
        foreach ($carIds as $index => $carId) {
            $carColorMap[$carId] = $colors[$index % count($colors)];
        }

        // Format events for FullCalendar
        $events = $rentals->map(function ($rental) use ($carColorMap) {
            $carName = $rental->car ? $rental->car->name : 'Kereta Padam';
            $plate = $rental->car ? $rental->car->plate_number : '';
            
            // FullCalendar's end date is exclusive for all-day events
            $fcEndDate = Carbon::parse($rental->end_date)->addDay()->toDateString();

            return [
                'id' => $rental->id,
                'title' => "{$carName} ({$rental->booking_code})",
                'start' => Carbon::parse($rental->start_date)->toDateString(),
                'end' => $fcEndDate,
                'color' => $carColorMap[$rental->car_id] ?? '#6B7280',
                'extendedProps' => [
                    'booking_code' => $rental->booking_code,
                    'customer_name' => $rental->customer_name ?? 'Pelanggan Walk-in',
                    'customer_phone' => $rental->customer_phone ?? '-',
                    'car_name' => $carName,
                    'plate_number' => $plate,
                    'start_date' => Carbon::parse($rental->start_date)->format('d/m/Y'),
                    'end_date' => Carbon::parse($rental->end_date)->format('d/m/Y'),
                    'total_days' => $rental->total_days,
                    'total_amount' => number_format($rental->total_amount, 2),
                    'deposit_paid' => number_format($rental->deposit_paid, 2),
                    'balance_due' => number_format($rental->balance_due, 2),
                    'status' => ucfirst($rental->status),
                    'status_badge' => $rental->status,
                    'detail_url' => route('admin.bookings.show', $rental->id),
                ]
            ];
        });

        return view('livewire.admin.booking-calendar', [
            'eventsJson' => json_encode($events),
        ]);
    }
}
