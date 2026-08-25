<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Car;
use App\Models\Rental;
use App\Models\Revenue;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;

class BookingManagementTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected Car $car;
    protected Rental $rental;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed roles and permissions
        $adminRole = Role::create(['name' => 'admin']);
        
        // Create Admin User
        $this->admin = User::factory()->create([
            'email' => 'admin@nikafleet.com',
            'role' => 'admin',
        ]);
        $this->admin->assignRole('admin');

        // Create a car
        $this->car = Car::create([
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
            'description' => 'Compact and reliable.',
        ]);

        // Create a rental/booking
        $this->rental = Rental::create([
            'car_id' => $this->car->id,
            'customer_name' => 'Ahmad Albab',
            'customer_phone' => '0123456789',
            'start_date' => now()->addDays(2)->toDateString(),
            'end_date' => now()->addDays(5)->toDateString(),
            'total_days' => 3,
            'price_per_day' => 130.00,
            'total_amount' => 390.00,
            'deposit_paid' => 100.00,
            'balance_due' => 290.00,
            'status' => 'pending',
        ]);
    }

    /** @test */
    public function admin_can_view_bookings_list()
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.bookings.index'));

        $response->assertStatus(200);
        $response->assertSee('Ahmad Albab');
        $response->assertSee('VGD 8834');
    }

    /** @test */
    public function admin_can_view_booking_details_and_detect_conflict()
    {
        // Create an overlapping confirmed booking to trigger conflict alert
        $conflictBooking = Rental::create([
            'car_id' => $this->car->id,
            'customer_name' => 'Siti Aminah',
            'customer_phone' => '0198765432',
            'start_date' => now()->addDays(3)->toDateString(),
            'end_date' => now()->addDays(6)->toDateString(),
            'total_days' => 3,
            'price_per_day' => 130.00,
            'total_amount' => 390.00,
            'deposit_paid' => 100.00,
            'balance_due' => 290.00,
            'status' => 'confirmed',
        ]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.bookings.show', $this->rental->id));

        $response->assertStatus(200);
        $response->assertSee('Kereta ini sudah ditempah untuk tarikh tersebut!');
        $response->assertSee($conflictBooking->booking_code);
    }

    /** @test */
    public function admin_can_confirm_booking()
    {
        $response = $this->actingAs($this->admin)
            ->post(route('admin.bookings.confirm', $this->rental->id));

        $response->assertRedirect();
        $this->assertEquals('confirmed', $this->rental->fresh()->status);
        $this->assertNotNull($this->rental->fresh()->confirmed_at);
    }

    /** @test */
    public function admin_can_start_rental()
    {
        $this->rental->update(['status' => 'confirmed']);

        $response = $this->actingAs($this->admin)
            ->post(route('admin.bookings.start', $this->rental->id));

        $response->assertRedirect();
        $this->assertEquals('active', $this->rental->fresh()->status);
        $this->assertNotNull($this->rental->fresh()->started_at);
        $this->assertEquals('rented', $this->car->fresh()->status);
    }

    /** @test */
    public function admin_can_complete_rental_and_auto_create_revenue_entry()
    {
        $this->rental->update(['status' => 'active']);

        $response = $this->actingAs($this->admin)
            ->post(route('admin.bookings.complete', $this->rental->id));

        $response->assertRedirect();
        $this->assertEquals('completed', $this->rental->fresh()->status);
        $this->assertNotNull($this->rental->fresh()->completed_at);
        $this->assertEquals('available', $this->car->fresh()->status);

        // Check revenue entry
        $this->assertDatabaseHas('revenues', [
            'rental_id' => $this->rental->id,
            'type' => 'rental',
            'amount' => 390.00,
        ]);
    }

    /** @test */
    public function admin_can_cancel_rental_with_reason_and_refund()
    {
        $response = $this->actingAs($this->admin)
            ->post(route('admin.bookings.cancel', $this->rental->id), [
                'reason' => 'Customer request',
                'mark_refund' => '1',
            ]);

        $response->assertRedirect();
        $this->assertEquals('refunded', $this->rental->fresh()->status);
        $this->assertStringContainsString('Sebab Batal: Customer request', $this->rental->fresh()->admin_notes);

        // Check refund revenue entry
        $this->assertDatabaseHas('revenues', [
            'rental_id' => $this->rental->id,
            'type' => 'refund',
            'amount' => -100.00, // Deposit paid was 100.00
        ]);
    }

    /** @test */
    public function admin_can_auto_save_notes()
    {
        $response = $this->actingAs($this->admin)
            ->post(route('admin.bookings.notes', $this->rental->id), [
                'admin_notes' => 'Updated admin notes text',
            ]);

        $response->assertJson(['success' => true]);
        $this->assertEquals('Updated admin notes text', $this->rental->fresh()->admin_notes);
    }

    /** @test */
    public function admin_can_download_receipt_pdf()
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.bookings.receipt', $this->rental->id));

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
    }
}
