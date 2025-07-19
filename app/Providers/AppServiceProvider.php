<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Setting;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Date;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Define gates for role-based access
        Gate::define('super_admin', function ($user) {
            return $user->role === 'super_admin';
        });

        Gate::define('admin', function ($user) {
            return $user->role === 'admin';
        });

        Gate::define('patient', function ($user) {
            return $user->role === 'patient';
        });

        // Gate for admin or super_admin (for shared menu items)
        Gate::define('admin_or_super_admin', function ($user) {
            return in_array($user->role, ['admin', 'super_admin']);
        });

        // Alternative gate names for AdminLTE compatibility
        Gate::define('admin-profile', function ($user) {
            return in_array($user->role, ['admin', 'super_admin']);
        });

        // Set timezone dynamically from settings
        try {
            $timezone = Setting::getValue('timezone', config('app.timezone'));
            Config::set('app.timezone', $timezone);
            date_default_timezone_set($timezone);
        } catch (\Exception $e) {
            // If settings table doesn't exist yet (during migrations), use default timezone
            $timezone = config('app.timezone');
            date_default_timezone_set($timezone);
        }
    }
}
