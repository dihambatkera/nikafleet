<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rental;
use App\Models\Car;
use Carbon\Carbon;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        $cars = Car::all();
        if ($cars->isEmpty()) {
            $this->command->error('No cars found. Run CarSeeder first.');
            return;
        }

        $myvi = $cars->where('model', 'Myvi')->first() ?? $cars->first();
        $saga = $cars->where('model', 'Saga')->first() ?? $cars->first();
        $civic = $cars->where('model', 'Civic')->first() ?? $cars->first();
        $vellfire = $cars->where('model', 'Vellfire')->first() ?? $cars->first();

        // 1. Pending Booking
        Rental::create([
            'car_id' => $myvi->id,
            'customer_name' => 'Ahmad Albab',
            'customer_phone' => '012-3456789',
            'start_date' => Carbon::now()->addDays(2)->toDateString(),
            'end_date' => Carbon::now()->addDays(5)->toDateString(),
            'total_days' => 3,
            'price_per_day' => $myvi->price_per_day,
            'total_amount' => $myvi->price_per_day * 3,
            'deposit_paid' => 100.00,
            'balance_due' => ($myvi->price_per_day * 3) - 100.00,
            'status' => 'pending',
            'pickup_location' => 'Rawang, Selangor',
            'dropoff_location' => 'Rawang, Selangor',
            'customer_notes' => 'Tolong basuh kereta bersih-bersih ya.',
        ]);

        // 2. Confirmed Booking (with overlap conflict for demonstration)
        Rental::create([
            'car_id' => $myvi->id,
            'customer_name' => 'Siti Aminah',
            'customer_phone' => '019-8765432',
            // overlap with Ahmad Albab
            'start_date' => Carbon::now()->addDays(3)->toDateString(),
            'end_date' => Carbon::now()->addDays(6)->toDateString(),
            'total_days' => 3,
            'price_per_day' => $myvi->price_per_day,
            'total_amount' => $myvi->price_per_day * 3,
            'deposit_paid' => 150.00,
            'balance_due' => ($myvi->price_per_day * 3) - 150.00,
            'status' => 'confirmed',
            'confirmed_at' => Carbon::now(),
            'pickup_location' => 'Rawang, Selangor',
            'dropoff_location' => 'Rawang, Selangor',
        ]);

        // 3. Active Booking
        Rental::create([
            'car_id' => $civic->id,
            'customer_name' => 'Mujahid Bin Ahmad',
            'customer_phone' => '011-6824 7599',
            'start_date' => Carbon::now()->subDays(2)->toDateString(),
            'end_date' => Carbon::now()->addDays(2)->toDateString(),
            'total_days' => 4,
            'price_per_day' => $civic->price_per_day,
            'total_amount' => $civic->price_per_day * 4,
            'deposit_paid' => 200.00,
            'balance_due' => ($civic->price_per_day * 4) - 200.00,
            'status' => 'active',
            'confirmed_at' => Carbon::now()->subDays(3),
            'started_at' => Carbon::now()->subDays(2),
            'pickup_location' => 'Rawang, Selangor',
            'dropoff_location' => 'Rawang, Selangor',
        ]);

        // 4. Completed Booking
        Rental::create([
            'car_id' => $vellfire->id,
            'customer_name' => 'Cristiano Ronaldo',
            'customer_phone' => '017-6543210',
            'start_date' => Carbon::now()->subDays(10)->toDateString(),
            'end_date' => Carbon::now()->subDays(6)->toDateString(),
            'total_days' => 4,
            'price_per_day' => $vellfire->price_per_day,
            'total_amount' => $vellfire->price_per_day * 4,
            'deposit_paid' => 500.00,
            'balance_due' => ($vellfire->price_per_day * 4) - 500.00,
            'status' => 'completed',
            'confirmed_at' => Carbon::now()->subDays(12),
            'started_at' => Carbon::now()->subDays(10),
            'completed_at' => Carbon::now()->subDays(6),
            'pickup_location' => 'Rawang, Selangor',
            'dropoff_location' => 'Rawang, Selangor',
        ]);

        $this->command->info('Test bookings seeded.');
    }
}
