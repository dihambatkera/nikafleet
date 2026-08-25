<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@nikafleet.com'],
            [
                'name' => 'NikaFleet Admin',
                'email' => 'admin@nikafleet.com',
                'phone' => '+60 11-6824 7599',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        $admin->assignRole('admin');

        $this->command->info('Admin user created: admin@nikafleet.com / password123');
    }
}
