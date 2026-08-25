<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * ProductionDataSeeder
 *
 * Seeds your NikaFleet production PostgreSQL database with all data
 * that was previously in MySQL. Run via:
 *
 *   php artisan db:seed --class=ProductionDataSeeder
 *
 * This seeder is idempotent – safe to run multiple times.
 */
class ProductionDataSeeder extends Seeder
{
    public function run(): void
    {
        // ── 1. Users ──────────────────────────────────────────────────────────
        DB::table('users')->insertOrIgnore([
            [
                'id'                => 1,
                'name'              => 'NikaFleet Admin',
                'email'             => 'admin@nikafleet.com',
                'phone'             => '+60 11-6824 7599',
                'email_verified_at' => '2026-06-28 15:20:11',
                'password'          => '$2y$12$EKsB/dWTK1VtZBGAgKtsQ.ttZGjNfO0AZ5GekYWHBeVhoM8I/ATfa',
                'role'              => 'superadmin',
                'is_active'         => true,
                'avatar'            => null,
                'remember_token'    => null,
                'created_at'        => '2026-06-28 15:20:11',
                'updated_at'        => '2026-08-24 18:51:26',
                'deleted_at'        => null,
            ],
        ]);

        // ── 2. Cars ───────────────────────────────────────────────────────────
        DB::table('cars')->insertOrIgnore([
            ['id'=>1,'name'=>'Perodua Myvi 1.5 AV','plate_number'=>'VGD 8834','brand'=>'Perodua','model'=>'Myvi','year'=>2023,'color'=>'Granite Grey','type'=>'hatchback','transmission'=>'auto','seats'=>5,'fuel_type'=>'petrol','price_per_day'=>130.00,'price_per_week'=>800.00,'deposit_amount'=>150.00,'late_return_penalty'=>null,'mileage'=>12500,'last_service_date'=>null,'next_service_due'=>null,'insurance_expiry'=>null,'road_tax_expiry'=>null,'location'=>'Rawang, Selangor','status'=>'available','featured'=>true,'description'=>'Sleek, compact and reliable. The legendary Malaysian hatchback with Advanced Safety Assist (ASA) 3.0. Perfect for city driving and fuel efficiency.','availability_note'=>'Available daily','created_at'=>'2026-06-28 15:20:11','updated_at'=>'2026-08-24 19:40:11','deleted_at'=>'2026-08-24 19:40:11'],
            ['id'=>2,'name'=>'Proton Saga 1.3 Premium','plate_number'=>'WUX 5521','brand'=>'Proton','model'=>'Saga','year'=>2022,'color'=>'Snow White','type'=>'sedan','transmission'=>'auto','seats'=>5,'fuel_type'=>'petrol','price_per_day'=>110.00,'price_per_week'=>700.00,'deposit_amount'=>100.00,'late_return_penalty'=>null,'mileage'=>24000,'last_service_date'=>null,'next_service_due'=>null,'insurance_expiry'=>null,'road_tax_expiry'=>null,'location'=>'Rawang, Selangor','status'=>'available','featured'=>true,'description'=>"Malaysia's favorite budget sedan. Comfortable ride, modern infotainment with Bluetooth connectivity, and stable handling.",'availability_note'=>'Available daily','created_at'=>'2026-06-28 15:20:11','updated_at'=>'2026-06-28 15:20:11','deleted_at'=>null],
            ['id'=>3,'name'=>'Honda Civic 1.5 VTEC Turbo','plate_number'=>'BRT 7789','brand'=>'Honda','model'=>'Civic','year'=>2023,'color'=>'Platinum White Pearl','type'=>'sedan','transmission'=>'auto','seats'=>5,'fuel_type'=>'petrol','price_per_day'=>320.00,'price_per_week'=>2000.00,'deposit_amount'=>300.00,'late_return_penalty'=>null,'mileage'=>8900,'last_service_date'=>null,'next_service_due'=>null,'insurance_expiry'=>null,'road_tax_expiry'=>null,'location'=>'Rawang, Selangor','status'=>'available','featured'=>true,'description'=>'Premium sporty sedan with high-performance VTEC Turbo engine, premium leather seats, Honda SENSING suite, and high-end aesthetics.','availability_note'=>'Available daily','created_at'=>'2026-06-28 15:20:11','updated_at'=>'2026-06-28 15:20:11','deleted_at'=>null],
            ['id'=>4,'name'=>'Toyota Vellfire 2.5 Golden Eye','plate_number'=>'VJL 9900','brand'=>'Toyota','model'=>'Vellfire','year'=>2021,'color'=>'Burning Black','type'=>'mpv','transmission'=>'auto','seats'=>7,'fuel_type'=>'petrol','price_per_day'=>550.00,'price_per_week'=>3500.00,'deposit_amount'=>500.00,'late_return_penalty'=>null,'mileage'=>45000,'last_service_date'=>null,'next_service_due'=>null,'insurance_expiry'=>null,'road_tax_expiry'=>null,'location'=>'Rawang, Selangor','status'=>'available','featured'=>true,'description'=>'Luxury MPV designed for VIP comfort. Double sunroof, pilot seats, ambient lighting, power sliding doors, and spacious interior.','availability_note'=>'Weekend bookings require 2 days minimum','created_at'=>'2026-06-28 15:20:11','updated_at'=>'2026-06-28 15:20:11','deleted_at'=>null],
            ['id'=>5,'name'=>'Proton X70 1.5 TGDI Premium','plate_number'=>'WVD 4321','brand'=>'Proton','model'=>'X70','year'=>2022,'color'=>'Space Grey','type'=>'suv','transmission'=>'auto','seats'=>5,'fuel_type'=>'petrol','price_per_day'=>250.00,'price_per_week'=>1500.00,'deposit_amount'=>250.00,'late_return_penalty'=>null,'mileage'=>19800,'last_service_date'=>null,'next_service_due'=>null,'insurance_expiry'=>null,'road_tax_expiry'=>null,'location'=>'Rawang, Selangor','status'=>'available','featured'=>false,'description'=>'Premium SUV with panoramic sunroof, Nappa leather seats, voice command infotainment, and outstanding riding comfort.','availability_note'=>'Available daily','created_at'=>'2026-06-28 15:20:11','updated_at'=>'2026-06-28 15:20:11','deleted_at'=>null],
        ]);

        // ── 3. Car Images ─────────────────────────────────────────────────────
        DB::table('car_images')->insertOrIgnore([
            ['id'=>1,'car_id'=>1,'image_path'=>'placeholder_perodua.png','is_primary'=>true,'sort_order'=>1,'created_at'=>'2026-06-28 15:20:11','updated_at'=>'2026-06-28 15:20:11'],
            ['id'=>4,'car_id'=>4,'image_path'=>'placeholder_toyota.png','is_primary'=>true,'sort_order'=>1,'created_at'=>'2026-06-28 15:20:11','updated_at'=>'2026-06-28 15:20:11'],
            ['id'=>6,'car_id'=>2,'image_path'=>'cars/2/6a8d12db873b0.webp','is_primary'=>true,'sort_order'=>1,'created_at'=>'2026-08-24 19:58:28','updated_at'=>'2026-08-24 19:58:45'],
            ['id'=>7,'car_id'=>3,'image_path'=>'cars/3/6a8d133c85a7c.webp','is_primary'=>true,'sort_order'=>1,'created_at'=>'2026-08-24 19:59:57','updated_at'=>'2026-08-24 19:59:57'],
            ['id'=>8,'car_id'=>5,'image_path'=>'cars/5/6a8d14b5c1105.webp','is_primary'=>true,'sort_order'=>1,'created_at'=>'2026-08-24 20:06:15','updated_at'=>'2026-08-24 20:06:15'],
        ]);

        // ── 4. Rentals ────────────────────────────────────────────────────────
        DB::table('rentals')->insertOrIgnore([
            ['id'=>1,'user_id'=>null,'car_id'=>1,'customer_name'=>'Ahmad Albab','customer_phone'=>'012-3456789','booking_code'=>'NF-VIDFQEET','start_date'=>'2026-06-30','end_date'=>'2026-07-03','total_days'=>3,'price_per_day'=>130.00,'total_amount'=>390.00,'deposit_paid'=>100.00,'balance_due'=>290.00,'status'=>'pending','payment_method'=>null,'payment_proof'=>null,'pickup_location'=>'Rawang, Selangor','dropoff_location'=>'Rawang, Selangor','admin_notes'=>null,'customer_notes'=>'Tolong basuh kereta bersih-bersih ya.','confirmed_at'=>null,'started_at'=>null,'completed_at'=>null,'cancelled_at'=>null,'created_at'=>'2026-06-28 15:20:12','updated_at'=>'2026-06-28 15:20:12','deleted_at'=>null],
            ['id'=>2,'user_id'=>null,'car_id'=>1,'customer_name'=>'Siti Aminah','customer_phone'=>'019-8765432','booking_code'=>'NF-VCRXAGO6','start_date'=>'2026-07-01','end_date'=>'2026-07-04','total_days'=>3,'price_per_day'=>130.00,'total_amount'=>390.00,'deposit_paid'=>150.00,'balance_due'=>240.00,'status'=>'confirmed','payment_method'=>null,'payment_proof'=>null,'pickup_location'=>'Rawang, Selangor','dropoff_location'=>'Rawang, Selangor','admin_notes'=>null,'customer_notes'=>null,'confirmed_at'=>'2026-06-28 15:20:12','started_at'=>null,'completed_at'=>null,'cancelled_at'=>null,'created_at'=>'2026-06-28 15:20:12','updated_at'=>'2026-06-28 15:20:12','deleted_at'=>null],
            ['id'=>3,'user_id'=>null,'car_id'=>3,'customer_name'=>'Mujahid Bin Ahmad','customer_phone'=>'011-6824 7599','booking_code'=>'NF-ELDFAZVA','start_date'=>'2026-06-26','end_date'=>'2026-06-30','total_days'=>4,'price_per_day'=>320.00,'total_amount'=>1280.00,'deposit_paid'=>200.00,'balance_due'=>1080.00,'status'=>'active','payment_method'=>null,'payment_proof'=>null,'pickup_location'=>'Rawang, Selangor','dropoff_location'=>'Rawang, Selangor','admin_notes'=>null,'customer_notes'=>null,'confirmed_at'=>'2026-06-25 15:20:12','started_at'=>'2026-06-26 15:20:12','completed_at'=>null,'cancelled_at'=>null,'created_at'=>'2026-06-28 15:20:12','updated_at'=>'2026-06-28 15:20:12','deleted_at'=>null],
            ['id'=>4,'user_id'=>null,'car_id'=>4,'customer_name'=>'Cristiano Ronaldo','customer_phone'=>'017-6543210','booking_code'=>'NF-PWHOUPRR','start_date'=>'2026-06-18','end_date'=>'2026-06-22','total_days'=>4,'price_per_day'=>550.00,'total_amount'=>2200.00,'deposit_paid'=>500.00,'balance_due'=>1700.00,'status'=>'completed','payment_method'=>null,'payment_proof'=>null,'pickup_location'=>'Rawang, Selangor','dropoff_location'=>'Rawang, Selangor','admin_notes'=>null,'customer_notes'=>null,'confirmed_at'=>'2026-06-16 15:20:12','started_at'=>'2026-06-18 15:20:12','completed_at'=>'2026-06-22 15:20:12','cancelled_at'=>null,'created_at'=>'2026-06-28 15:20:12','updated_at'=>'2026-06-28 15:20:12','deleted_at'=>null],
        ]);

        // ── 5. Locations ──────────────────────────────────────────────────────
        DB::table('locations')->insertOrIgnore([
            ['id'=>1,'name'=>'Rawang, Selangor','address'=>'Rawang, Selangor, Malaysia','status'=>'active','sort_order'=>1,'created_at'=>'2026-08-24 18:49:58','updated_at'=>'2026-08-24 18:49:58'],
            ['id'=>2,'name'=>'Kangar','address'=>'Kangar, Perlis, Malaysia','status'=>'inactive','sort_order'=>2,'created_at'=>'2026-08-24 18:49:58','updated_at'=>'2026-08-24 20:07:09'],
            ['id'=>3,'name'=>'Padang Besar','address'=>'Padang Besar, Perlis, Malaysia','status'=>'inactive','sort_order'=>3,'created_at'=>'2026-08-24 18:49:58','updated_at'=>'2026-08-24 20:07:09'],
            ['id'=>4,'name'=>'Kuala Perlis','address'=>'Kuala Perlis, Perlis, Malaysia','status'=>'inactive','sort_order'=>4,'created_at'=>'2026-08-24 18:49:58','updated_at'=>'2026-08-24 20:07:14'],
            ['id'=>5,'name'=>'UITM Tapah','address'=>null,'status'=>'active','sort_order'=>0,'created_at'=>'2026-08-24 20:07:27','updated_at'=>'2026-08-24 20:07:27'],
        ]);

        // ── 6. Time Slots ─────────────────────────────────────────────────────
        DB::table('time_slots')->insertOrIgnore([
            ['id'=>1,'label'=>'08:00 AM','time_value'=>'08:00','is_active'=>true,'sort_order'=>1,'created_at'=>'2026-08-24 18:50:15','updated_at'=>'2026-08-24 18:50:15'],
            ['id'=>2,'label'=>'10:00 AM','time_value'=>'10:00','is_active'=>true,'sort_order'=>2,'created_at'=>'2026-08-24 18:50:16','updated_at'=>'2026-08-24 18:50:16'],
            ['id'=>3,'label'=>'12:00 PM','time_value'=>'12:00','is_active'=>true,'sort_order'=>3,'created_at'=>'2026-08-24 18:50:16','updated_at'=>'2026-08-24 18:50:16'],
            ['id'=>4,'label'=>'02:00 PM','time_value'=>'14:00','is_active'=>true,'sort_order'=>4,'created_at'=>'2026-08-24 18:50:16','updated_at'=>'2026-08-24 18:50:16'],
            ['id'=>5,'label'=>'04:00 PM','time_value'=>'16:00','is_active'=>true,'sort_order'=>5,'created_at'=>'2026-08-24 18:50:16','updated_at'=>'2026-08-24 18:50:16'],
            ['id'=>6,'label'=>'06:00 PM','time_value'=>'18:00','is_active'=>true,'sort_order'=>6,'created_at'=>'2026-08-24 18:50:16','updated_at'=>'2026-08-24 18:50:16'],
        ]);

        // ── 7. Settings ───────────────────────────────────────────────────────
        DB::table('settings')->insertOrIgnore([
            ['id'=>1,'key'=>'company_name','value'=>'NikaFleet','created_at'=>'2026-06-28 15:20:11','updated_at'=>'2026-06-28 15:20:11'],
            ['id'=>2,'key'=>'tagline','value'=>'Nak sewa? Nika kan ada!','created_at'=>'2026-06-28 15:20:11','updated_at'=>'2026-06-28 15:20:11'],
            ['id'=>3,'key'=>'phone','value'=>'+60 11-6824 7599','created_at'=>'2026-06-28 15:20:11','updated_at'=>'2026-06-28 15:20:11'],
            ['id'=>4,'key'=>'whatsapp','value'=>'+60116824 7599','created_at'=>'2026-06-28 15:20:11','updated_at'=>'2026-06-28 15:20:11'],
            ['id'=>5,'key'=>'email','value'=>'admin@nikafleet.com','created_at'=>'2026-06-28 15:20:11','updated_at'=>'2026-06-28 15:20:11'],
            ['id'=>6,'key'=>'location','value'=>'Rawang, Selangor','created_at'=>'2026-06-28 15:20:11','updated_at'=>'2026-06-28 15:20:11'],
            ['id'=>7,'key'=>'address','value'=>'Rawang, Selangor, Malaysia','created_at'=>'2026-06-28 15:20:11','updated_at'=>'2026-06-28 15:20:11'],
            ['id'=>8,'key'=>'tiktok','value'=>'https://www.tiktok.com/@nika.fleet','created_at'=>'2026-06-28 15:20:11','updated_at'=>'2026-06-28 15:20:11'],
            ['id'=>9,'key'=>'currency','value'=>'RM','created_at'=>'2026-06-28 15:20:11','updated_at'=>'2026-06-28 15:20:11'],
            ['id'=>10,'key'=>'currency_code','value'=>'MYR','created_at'=>'2026-06-28 15:20:11','updated_at'=>'2026-06-28 15:20:11'],
            ['id'=>11,'key'=>'established','value'=>'November 2025','created_at'=>'2026-06-28 15:20:11','updated_at'=>'2026-06-28 15:20:11'],
            ['id'=>12,'key'=>'logo','value'=>null,'created_at'=>'2026-06-28 15:20:11','updated_at'=>'2026-06-28 15:20:11'],
            ['id'=>13,'key'=>'meta_title','value'=>'NikaFleet - Car Rental Rawang Selangor','created_at'=>'2026-06-28 15:20:11','updated_at'=>'2026-06-28 15:20:11'],
            ['id'=>14,'key'=>'meta_description','value'=>'NikaFleet menyediakan perkhidmatan sewa kereta di Rawang, Selangor. Nak sewa? Nika kan ada!','created_at'=>'2026-06-28 15:20:11','updated_at'=>'2026-06-28 15:20:11'],
        ]);

        // ── 8. Roles (Spatie) ─────────────────────────────────────────────────
        DB::table('roles')->insertOrIgnore([
            ['id'=>1,'name'=>'admin','guard_name'=>'web','created_at'=>'2026-06-28 15:20:08','updated_at'=>'2026-06-28 15:20:08'],
            ['id'=>2,'name'=>'user','guard_name'=>'web','created_at'=>'2026-06-28 15:20:08','updated_at'=>'2026-06-28 15:20:08'],
            ['id'=>3,'name'=>'superadmin','guard_name'=>'web','created_at'=>'2026-08-24 18:49:07','updated_at'=>'2026-08-24 18:49:07'],
        ]);

        // ── 9. Permissions ────────────────────────────────────────────────────
        $permissions = [
            [1,'view cars'],[2,'create cars'],[3,'edit cars'],[4,'delete cars'],
            [5,'view rentals'],[6,'create rentals'],[7,'edit rentals'],[8,'delete rentals'],
            [9,'confirm rentals'],[10,'cancel rentals'],
            [11,'view expenses'],[12,'create expenses'],[13,'edit expenses'],[14,'delete expenses'],
            [15,'view revenues'],[16,'create revenues'],
            [17,'view users'],[18,'create users'],[19,'edit users'],[20,'delete users'],
            [21,'view settings'],[22,'edit settings'],
            [23,'view reports'],[24,'export reports'],
            [25,'manage locations'],[26,'manage time_slots'],
            [27,'manage whatsapp_template'],[28,'manage users'],
        ];
        foreach ($permissions as [$id, $name]) {
            DB::table('permissions')->insertOrIgnore([
                'id' => $id, 'name' => $name, 'guard_name' => 'web',
                'created_at' => '2026-06-28 15:20:08', 'updated_at' => '2026-06-28 15:20:08',
            ]);
        }

        // ── 10. Role → Permissions ────────────────────────────────────────────
        // admin (1) has permissions 1–27, user (2) has 1,5,6, superadmin (3) has 1–28
        $rolePerms = [];
        foreach (range(1, 27) as $p) { $rolePerms[] = ['permission_id' => $p, 'role_id' => 1]; }
        foreach ([1, 5, 6] as $p)    { $rolePerms[] = ['permission_id' => $p, 'role_id' => 2]; }
        foreach (range(1, 28) as $p) { $rolePerms[] = ['permission_id' => $p, 'role_id' => 3]; }
        DB::table('role_has_permissions')->insertOrIgnore($rolePerms);

        // ── 11. Assign superadmin role to admin user ──────────────────────────
        DB::table('model_has_roles')->insertOrIgnore([
            ['role_id' => 3, 'model_type' => 'App\Models\User', 'model_id' => 1],
        ]);

        // ── 12. Fix PostgreSQL auto-increment sequences ────────────────────────
        // After inserting with explicit IDs, PostgreSQL sequences need resetting.
        // Skip on MySQL / SQLite.
        if (DB::getDriverName() === 'pgsql') {
            $sequences = [
                'users'       => 'users_id_seq',
                'cars'        => 'cars_id_seq',
                'car_images'  => 'car_images_id_seq',
                'rentals'     => 'rentals_id_seq',
                'locations'   => 'locations_id_seq',
                'time_slots'  => 'time_slots_id_seq',
                'settings'    => 'settings_id_seq',
                'roles'       => 'roles_id_seq',
                'permissions' => 'permissions_id_seq',
            ];
            foreach ($sequences as $table => $seq) {
                DB::statement("SELECT setval('{$seq}', (SELECT MAX(id) FROM {$table}))");
            }
        }

        $this->command->info('✅ Production data seeded successfully!');

    }
}
