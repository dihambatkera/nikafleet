<?php

namespace App\Providers;

use App\Models\Car;
use App\Models\Expense;
use App\Models\Rental;
use App\Policies\CarPolicy;
use App\Policies\ExpensePolicy;
use App\Policies\RentalPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if (file_exists($helperFile = app_path('helpers.php'))) {
            require_once $helperFile;
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force HTTPS & Root URL in production / behind reverse proxy (Render)
        if (app()->environment('production') || str_starts_with(config('app.url'), 'https://') || request()->header('x-forwarded-proto') === 'https') {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }
        if (!empty(config('app.url')) && !app()->environment('local')) {
            \Illuminate\Support\Facades\URL::forceRootUrl(config('app.url'));
        }

        // Register policies
        Gate::policy(Car::class, CarPolicy::class);
        Gate::policy(Rental::class, RentalPolicy::class);
        Gate::policy(Expense::class, ExpensePolicy::class);

        // Admin bypass — admin and superadmin can do everything
        Gate::before(function ($user, $ability) {
            if ($user->isAdmin()) {
                return true;
            }
        });

        // Dynamic Alerts Composer for layouts.admin and dashboard
        view()->composer(['layouts.admin', 'admin.dashboard'], function ($view) {
            $now = \Carbon\Carbon::now();
            $pendingBookings24h = \App\Models\Rental::where('status', 'pending')
                ->where('created_at', '<=', $now->copy()->subHours(24))
                ->get();

            $expiringCars = \App\Models\Car::where(function ($q) use ($now) {
                $q->where(function ($q2) use ($now) {
                    $q2->whereNotNull('road_tax_expiry')
                        ->where('road_tax_expiry', '<=', $now->copy()->addDays(30));
                })->orWhere(function ($q2) use ($now) {
                    $q2->whereNotNull('insurance_expiry')
                        ->where('insurance_expiry', '<=', $now->copy()->addDays(30));
                });
            })->get();

            $serviceDueCars = \App\Models\Car::whereNotNull('next_service_due')
                ->where('next_service_due', '<=', $now->copy()->addDays(30))
                ->get();

            $badgeCount = $pendingBookings24h->count() + $expiringCars->count() + $serviceDueCars->count();

            $view->with(compact('pendingBookings24h', 'expiringCars', 'serviceDueCars', 'badgeCount'));
        });
    }
}
