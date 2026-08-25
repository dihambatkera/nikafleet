<?php

namespace Database\Seeders;

use App\Models\TimeSlot;
use Illuminate\Database\Seeder;

class TimeSlotSeeder extends Seeder
{
    public function run(): void
    {
        $slots = [
            ['label' => '08:00 AM', 'time_value' => '08:00', 'sort_order' => 1],
            ['label' => '10:00 AM', 'time_value' => '10:00', 'sort_order' => 2],
            ['label' => '12:00 PM', 'time_value' => '12:00', 'sort_order' => 3],
            ['label' => '02:00 PM', 'time_value' => '14:00', 'sort_order' => 4],
            ['label' => '04:00 PM', 'time_value' => '16:00', 'sort_order' => 5],
            ['label' => '06:00 PM', 'time_value' => '18:00', 'sort_order' => 6],
        ];

        foreach ($slots as $slot) {
            TimeSlot::firstOrCreate(
                ['time_value' => $slot['time_value']],
                array_merge($slot, ['is_active' => true])
            );
        }

        $this->command->info('Time slots seeded.');
    }
}
