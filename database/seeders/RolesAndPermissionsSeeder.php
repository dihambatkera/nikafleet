<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Define permissions
        $permissions = [
            // Cars
            'view cars',
            'create cars',
            'edit cars',
            'delete cars',

            // Rentals / Bookings
            'view rentals',
            'create rentals',
            'edit rentals',
            'delete rentals',
            'confirm rentals',
            'cancel rentals',

            // Expenses
            'view expenses',
            'create expenses',
            'edit expenses',
            'delete expenses',

            // Revenues
            'view revenues',
            'create revenues',

            // Users
            'view users',
            'create users',
            'edit users',
            'delete users',

            // Settings
            'view settings',
            'edit settings',

            // Reports
            'view reports',
            'export reports',

            // New: Locations
            'manage locations',

            // New: Time Slots
            'manage time_slots',

            // New: WhatsApp Template
            'manage whatsapp_template',

            // New: Admin Users management
            'manage users',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Superadmin role — absolute full access
        $superAdminRole = Role::firstOrCreate(['name' => 'superadmin', 'guard_name' => 'web']);
        $superAdminRole->givePermissionTo(Permission::all());

        // Admin role — operational management (no user management)
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $adminRole->givePermissionTo([
            'view cars', 'create cars', 'edit cars', 'delete cars',
            'view rentals', 'create rentals', 'edit rentals', 'confirm rentals', 'cancel rentals',
            'view expenses', 'view revenues',
            'view settings',
            'manage locations',
            'manage time_slots',
            'manage whatsapp_template',
        ]);

        // User role — limited access (customer-facing)
        $userRole = Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);
        $userRole->givePermissionTo([
            'view cars',
            'view rentals',
            'create rentals',
        ]);
    }
}
