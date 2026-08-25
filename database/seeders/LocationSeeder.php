<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        $locations = [
            ['name' => 'Rawang, Selangor', 'address' => 'Rawang, Selangor, Malaysia', 'sort_order' => 1],
            ['name' => 'Kangar', 'address' => 'Kangar, Perlis, Malaysia', 'sort_order' => 2],
            ['name' => 'Padang Besar', 'address' => 'Padang Besar, Perlis, Malaysia', 'sort_order' => 3],
            ['name' => 'Kuala Perlis', 'address' => 'Kuala Perlis, Perlis, Malaysia', 'sort_order' => 4],
        ];

        foreach ($locations as $loc) {
            Location::firstOrCreate(
                ['name' => $loc['name']],
                array_merge($loc, ['status' => 'active'])
            );
        }

        $this->command->info('Locations seeded.');
    }
}
