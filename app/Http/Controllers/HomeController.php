<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Location;
use App\Models\Rental;
use App\Models\Setting;
use App\Models\TimeSlot;

class HomeController extends Controller
{
    private const DEFAULT_WA_TEMPLATE = "Salam NikaFleet,\n\nSaya ingin membuat tempahan sewa kereta. Berikut adalah maklumat saya:\n\nNama            : {customer_name}\nNo. Telefon     : {customer_phone}\n\nKenderaan       : {vehicle_name}\nHarga Sewa      : RM {price_per_day} / hari\n\nTarikh Ambil    : {pickup_date}\nMasa Ambil      : {pickup_time}\nTarikh Pulang   : {return_date}\nMasa Pulang     : {return_time}\nTempoh          : {duration}\nLokasi Ambil    : {location}\n\nAnggaran Harga  : RM {estimated_price}\n\nSila sahkan ketersediaan dan butiran selanjutnya. Terima kasih.";

    public function index()
    {
        // ─── LIVE STATS ───────────────────────────────────────────────
        try {
            $availableCars   = Car::where('status', 'available')->count();
            $totalFleet      = Car::whereNotIn('status', ['hidden'])->count();
            $completedOrders = Rental::where('status', 'completed')->count();
        } catch (\Exception $e) {
            $availableCars   = 0;
            $totalFleet      = 0;
            $completedOrders = 0;
        }

        // ─── FLEET DATA (from DB, with sample fallback) ───────────────
        $dbCars = collect();
        try {
            $dbCars = Car::where('status', 'available')
                ->with('images')
                ->latest()
                ->get()
                ->map(function ($car) {
                    return [
                        'id'           => $car->id,
                        'name'         => $car->name ?? $car->brand . ' ' . $car->model,
                        'type'         => ucfirst($car->type ?? 'Sedan'),
                        'transmission' => ucfirst($car->transmission ?? 'Auto'),
                        'seats'        => $car->seats ?? 5,
                        'fuel'         => ucfirst($car->fuel_type ?? 'Petrol'),
                        'year'         => $car->year ?? 2023,
                        'price'        => (int) $car->price_per_day,
                        'image'        => $car->primary_image_url,
                    ];
                });
        } catch (\Exception $e) {
            // Silent fallback
        }

        // Hardcoded sample cars — used only if DB is empty
        $sampleCars = $dbCars->isNotEmpty() ? $dbCars->toArray() : [
            [
                'id'           => 1,
                'name'         => 'Perodua Axia',
                'type'         => 'Hatchback',
                'transmission' => 'Auto',
                'seats'        => 5,
                'fuel'         => 'Petrol',
                'year'         => 2023,
                'price'        => 80,
                'image'        => 'https://upload.wikimedia.org/wikipedia/commons/thumb/7/7f/2023_Perodua_Axia_1.0_X_%28D74A%29%2C_front_7.15.23.jpg/1280px-2023_Perodua_Axia_1.0_X_%28D74A%29%2C_front_7.15.23.jpg',
            ],
            [
                'id'           => 2,
                'name'         => 'Perodua Myvi',
                'type'         => 'Hatchback',
                'transmission' => 'Auto',
                'seats'        => 5,
                'fuel'         => 'Petrol',
                'year'         => 2023,
                'price'        => 95,
                'image'        => 'https://upload.wikimedia.org/wikipedia/commons/thumb/0/06/2022_Perodua_Myvi_1.5_AV_%28A%29_%28facelift%29%2C_front_6.26.22.jpg/1280px-2022_Perodua_Myvi_1.5_AV_%28A%29_%28facelift%29%2C_front_6.26.22.jpg',
            ],
            [
                'id'           => 3,
                'name'         => 'Perodua Bezza',
                'type'         => 'Sedan',
                'transmission' => 'Auto',
                'seats'        => 5,
                'fuel'         => 'Petrol',
                'year'         => 2023,
                'price'        => 90,
                'image'        => 'https://upload.wikimedia.org/wikipedia/commons/thumb/3/38/2020_Perodua_Bezza_1.3_Advance_%28facelift%29_front.jpg/1280px-2020_Perodua_Bezza_1.3_Advance_%28facelift%29_front.jpg',
            ],
        ];

        // Update fleet count if using sample data
        if ($dbCars->isEmpty()) {
            $totalFleet    = count($sampleCars);
            $availableCars = count($sampleCars);
        }

        // ─── LOCATIONS (dynamic from DB) ─────────────────────────────
        $locations = collect();
        try {
            $locations = Location::active()->orderBy('sort_order')->get();
        } catch (\Exception $e) {
            // If table doesn't exist yet, fail gracefully
        }

        // ─── TIME SLOTS (dynamic from DB) ────────────────────────────
        $timeSlots = collect();
        try {
            $timeSlots = TimeSlot::active()->orderBy('sort_order')->get();
        } catch (\Exception $e) {
            // If table doesn't exist yet, fail gracefully
        }

        // ─── WHATSAPP TEMPLATE (from settings DB) ────────────────────
        $whatsappTemplate = self::DEFAULT_WA_TEMPLATE;
        try {
            $whatsappTemplate = Setting::get('booking_whatsapp_template', self::DEFAULT_WA_TEMPLATE);
        } catch (\Exception $e) {
            // Fallback to default
        }

        return view('home', compact(
            'availableCars',
            'totalFleet',
            'completedOrders',
            'sampleCars',
            'locations',
            'timeSlots',
            'whatsappTemplate',
        ));
    }
}
