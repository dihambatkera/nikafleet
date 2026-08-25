<?php

use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\CarController as AdminCarController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TimeSlotController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\WhatsAppTemplateController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserCarController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ----------------------------------------------------------------
// Public User Routes
// ----------------------------------------------------------------
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/cars', [UserCarController::class, 'index'])->name('cars.index');
Route::get('/cars/{id}', [UserCarController::class, 'show'])->name('cars.show');

Route::post('/bookings/store', [BookingController::class, 'store'])->name('bookings.store');
Route::get('/booking/confirm/{code}', [BookingController::class, 'confirm'])->name('bookings.confirm');

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Public API
Route::get('/api/availability', function () {
    try {
        $available = \App\Models\Car::where('status', 'available')->count();
    } catch (\Exception $e) {
        $available = 0;
    }
    return response()->json(['available' => $available]);
})->name('api.availability');

// ----------------------------------------------------------------
// Admin Authentication Routes
// ----------------------------------------------------------------
Route::prefix('adminLogin')->name('admin.login')->group(function () {
    Route::get('/', [AdminLoginController::class, 'showLogin'])
        ->name(''); // resolves as "admin.login"

    Route::post('/', [AdminLoginController::class, 'login'])
        ->name('.post'); // resolves as "admin.login.post"
});

// Admin logout
Route::post('admin/logout', [AdminLoginController::class, 'logout'])
    ->name('admin.logout')
    ->middleware('auth');

// ----------------------------------------------------------------
// Admin Panel Routes — Protected (all admins)
// ----------------------------------------------------------------
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', fn() => redirect()->route('admin.dashboard'));

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // ── Bookings Management ──────────────────────────────────────
        Route::get('/bookings/calendar', [AdminBookingController::class, 'calendar'])->name('bookings.calendar');
        Route::get('/bookings/create', [AdminBookingController::class, 'create'])->name('bookings.create');
        Route::post('/bookings/admin-store', [AdminBookingController::class, 'adminStore'])->name('bookings.adminStore');
        Route::get('/bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
        Route::get('/bookings/{id}', [AdminBookingController::class, 'show'])->name('bookings.show');
        Route::put('/bookings/{id}/status', [AdminBookingController::class, 'updateStatus'])->name('bookings.updateStatus');
        Route::get('/bookings/{id}/receipt', [AdminBookingController::class, 'receipt'])->name('bookings.receipt');
        Route::post('/bookings/{id}/confirm', [AdminBookingController::class, 'confirm'])->name('bookings.confirm');
        Route::post('/bookings/{id}/start', [AdminBookingController::class, 'start'])->name('bookings.start');
        Route::post('/bookings/{id}/complete', [AdminBookingController::class, 'complete'])->name('bookings.complete');
        Route::post('/bookings/{id}/end-session', [AdminBookingController::class, 'complete'])->name('bookings.endSession');
        Route::post('/bookings/{id}/cancel', [AdminBookingController::class, 'cancel'])->name('bookings.cancel');
        Route::post('/bookings/{id}/notes', [AdminBookingController::class, 'updateNotes'])->name('bookings.notes');

        // ── Vehicle Management ───────────────────────────────────────
        Route::get('/cars', [AdminCarController::class, 'index'])->name('cars.index');
        Route::get('/cars/create', [AdminCarController::class, 'create'])->name('cars.create');
        Route::post('/cars', [AdminCarController::class, 'store'])->name('cars.store');
        Route::get('/cars/{id}', [AdminCarController::class, 'show'])->name('cars.show');
        Route::get('/cars/{id}/edit', [AdminCarController::class, 'edit'])->name('cars.edit');
        Route::put('/cars/{id}', [AdminCarController::class, 'update'])->name('cars.update');
        Route::delete('/cars/{id}', [AdminCarController::class, 'destroy'])->name('cars.destroy');
        Route::post('/cars/{id}/images', [AdminCarController::class, 'uploadImages'])->name('cars.uploadImages');
        Route::delete('/cars/{id}/images/{imgId}', [AdminCarController::class, 'deleteImage'])->name('cars.deleteImage');

        // ── Location Management ──────────────────────────────────────
        Route::get('/locations', [LocationController::class, 'index'])->name('locations.index');
        Route::post('/locations', [LocationController::class, 'store'])->name('locations.store');
        Route::put('/locations/{id}', [LocationController::class, 'update'])->name('locations.update');
        Route::delete('/locations/{id}', [LocationController::class, 'destroy'])->name('locations.destroy');
        Route::post('/locations/{id}/toggle', [LocationController::class, 'toggleStatus'])->name('locations.toggle');

        // ── Time Slot Management ─────────────────────────────────────
        Route::get('/time-slots', [TimeSlotController::class, 'index'])->name('time-slots.index');
        Route::post('/time-slots', [TimeSlotController::class, 'store'])->name('time-slots.store');
        Route::put('/time-slots/{id}', [TimeSlotController::class, 'update'])->name('time-slots.update');
        Route::delete('/time-slots/{id}', [TimeSlotController::class, 'destroy'])->name('time-slots.destroy');
        Route::post('/time-slots/{id}/toggle', [TimeSlotController::class, 'toggleStatus'])->name('time-slots.toggle');

        // ── WhatsApp Template ────────────────────────────────────────
        Route::get('/whatsapp-template', [WhatsAppTemplateController::class, 'index'])->name('whatsapp.index');
        Route::post('/whatsapp-template', [WhatsAppTemplateController::class, 'update'])->name('whatsapp.update');

        // ── Settings ─────────────────────────────────────────────────
        Route::get('/tetapan', [SettingController::class, 'index'])->name('settings.index');
        Route::post('/tetapan', [SettingController::class, 'update'])->name('settings.update');

        Route::prefix('tetapan')->name('settings.')->group(function () {
            Route::post('/maklumat-syarikat', [SettingController::class, 'saveCompany'])->name('company');
            Route::post('/tempahan', [SettingController::class, 'saveBooking'])->name('booking');
            Route::post('/kewangan', [SettingController::class, 'saveFinance'])->name('finance');
            Route::post('/tukar-kata-laluan', [SettingController::class, 'updatePassword'])->name('password');
            Route::get('/eksport-excel', [SettingController::class, 'exportExcel'])->name('export.excel');
            Route::get('/sandaran-db', [SettingController::class, 'downloadBackup'])->name('export.backup');
            Route::post('/set-semula', [SettingController::class, 'resetDemoData'])->name('reset');
        });

        // ── User Management (Superadmin only) ───────────────────────
        Route::middleware(['superadmin'])->group(function () {
            Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
            Route::post('/users', [UserManagementController::class, 'store'])->name('users.store');
            Route::put('/users/{id}', [UserManagementController::class, 'update'])->name('users.update');
            Route::delete('/users/{id}', [UserManagementController::class, 'destroy'])->name('users.destroy');
            Route::post('/users/{id}/toggle', [UserManagementController::class, 'toggleStatus'])->name('users.toggle');
            Route::post('/users/{id}/reset-password', [UserManagementController::class, 'resetPassword'])->name('users.resetPassword');
        });
    });

// ----------------------------------------------------------------
// General Auth Routes (Breeze — for regular users)
// ----------------------------------------------------------------
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
