<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::if('hasPermission', function ($permission) {
            $admin = Auth::guard('admin')->user();
            if (!$admin || !$admin->role) {
                return false;
            }
            return $admin->role->permissions->pluck('name')->contains($permission);
        });
    }
}
