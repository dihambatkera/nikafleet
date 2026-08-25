<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\CarImage;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    public function run(): void
    {
        $cars = [
            [
                'name' => 'Perodua Myvi 1.5 AV',
                'plate_number' => 'VGD 8834',
                'brand' => 'Perodua',
                'model' => 'Myvi',
                'year' => 2023,
                'color' => 'Granite Grey',
                'type' => 'hatchback',
                'transmission' => 'auto',
                'seats' => 5,
                'fuel_type' => 'petrol',
                'price_per_day' => 130.00,
                'price_per_week' => 800.00,
                'deposit_amount' => 150.00,
                'mileage' => 12500,
                'location' => 'Rawang, Selangor',
                'status' => 'available',
                'featured' => true,
                'description' => 'Sleek, compact and reliable. The legendary Malaysian hatchback with Advanced Safety Assist (ASA) 3.0. Perfect for city driving and fuel efficiency.',
                'availability_note' => 'Available daily',
            ],
            [
                'name' => 'Proton Saga 1.3 Premium',
                'plate_number' => 'WUX 5521',
                'brand' => 'Proton',
                'model' => 'Saga',
                'year' => 2022,
                'color' => 'Snow White',
                'type' => 'sedan',
                'transmission' => 'auto',
                'seats' => 5,
                'fuel_type' => 'petrol',
                'price_per_day' => 110.00,
                'price_per_week' => 700.00,
                'deposit_amount' => 100.00,
                'mileage' => 24000,
                'location' => 'Rawang, Selangor',
                'status' => 'available',
                'featured' => true,
                'description' => 'Malaysia\'s favorite budget sedan. Comfortable ride, modern infotainment with Bluetooth connectivity, and stable handling.',
                'availability_note' => 'Available daily',
            ],
            [
                'name' => 'Honda Civic 1.5 VTEC Turbo',
                'plate_number' => 'BRT 7789',
                'brand' => 'Honda',
                'model' => 'Civic',
                'year' => 2023,
                'color' => 'Platinum White Pearl',
                'type' => 'sedan',
                'transmission' => 'auto',
                'seats' => 5,
                'fuel_type' => 'petrol',
                'price_per_day' => 320.00,
                'price_per_week' => 2000.00,
                'deposit_amount' => 300.00,
                'mileage' => 8900,
                'location' => 'Rawang, Selangor',
                'status' => 'available',
                'featured' => true,
                'description' => 'Premium sporty sedan with high-performance VTEC Turbo engine, premium leather seats, Honda SENSING suite, and high-end aesthetics.',
                'availability_note' => 'Available daily',
            ],
            [
                'name' => 'Toyota Vellfire 2.5 Golden Eye',
                'plate_number' => 'VJL 9900',
                'brand' => 'Toyota',
                'model' => 'Vellfire',
                'year' => 2021,
                'color' => 'Burning Black',
                'type' => 'mpv',
                'transmission' => 'auto',
                'seats' => 7,
                'fuel_type' => 'petrol',
                'price_per_day' => 550.00,
                'price_per_week' => 3500.00,
                'deposit_amount' => 500.00,
                'mileage' => 45000,
                'location' => 'Rawang, Selangor',
                'status' => 'available',
                'featured' => true,
                'description' => 'Luxury MPV designed for VIP comfort. Double sunroof, pilot seats, ambient lighting, power sliding doors, and spacious interior.',
                'availability_note' => 'Weekend bookings require 2 days minimum',
            ],
            [
                'name' => 'Proton X70 1.5 TGDI Premium',
                'plate_number' => 'WVD 4321',
                'brand' => 'Proton',
                'model' => 'X70',
                'year' => 2022,
                'color' => 'Space Grey',
                'type' => 'suv',
                'transmission' => 'auto',
                'seats' => 5,
                'fuel_type' => 'petrol',
                'price_per_day' => 250.00,
                'price_per_week' => 1500.00,
                'deposit_amount' => 250.00,
                'mileage' => 19800,
                'location' => 'Rawang, Selangor',
                'status' => 'available',
                'featured' => false,
                'description' => 'Premium SUV with panoramic sunroof, Nappa leather seats, voice command infotainment, and outstanding riding comfort.',
                'availability_note' => 'Available daily',
            ],
        ];

        foreach ($cars as $carData) {
            $car = Car::create($carData);

            // Add placeholder images so our UI stays premium with fallback or generic car image vectors
            CarImage::create([
                'car_id' => $car->id,
                'image_path' => 'placeholder_' . strtolower($car->brand) . '.png',
                'is_primary' => true,
                'sort_order' => 1,
            ]);
        }
    }
}
