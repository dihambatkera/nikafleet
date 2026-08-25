<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            'company_name'   => 'NikaFleet',
            'tagline'        => 'Nak sewa? Nika kan ada!',
            'phone'          => '+60 11-6824 7599',
            'whatsapp'       => '+60116824 7599',
            'email'          => 'admin@nikafleet.com',
            'location'       => 'Rawang, Selangor',
            'address'        => 'Rawang, Selangor, Malaysia',
            'tiktok'         => 'https://www.tiktok.com/@nika.fleet',
            'currency'       => 'RM',
            'currency_code'  => 'MYR',
            'established'    => 'November 2025',
            'logo'           => null,
            'meta_title'     => 'NikaFleet - Car Rental Rawang Selangor',
            'meta_description' => 'NikaFleet menyediakan perkhidmatan sewa kereta di Rawang, Selangor. Nak sewa? Nika kan ada!',
        ];

        foreach ($settings as $key => $value) {
            Setting::set($key, $value);
        }

        $this->command->info('Settings seeded.');
    }
}
