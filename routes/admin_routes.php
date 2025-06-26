<?php
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [LoginController::class, 'login'])->name('admin.login.submit');
    Route::post('/logout', [LoginController::class, 'logout'])->name('admin.logout');

    // Protected admin routes
    Route::middleware(['admin'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

        Route::get('/dashboard/users-list', [DashboardController::class, 'all_user_list'])->name('admin.dashboard.users-list');

        Route::get('/dashboard/payments', [DashboardController::class, 'payments'])->name('admin.dashboard.payments');
        Route::get('/dashboard/payments/create', [DashboardController::class, 'view_payment_form'])->name('admin.dashboard.payments.create');
        Route::post('/dashboard/payments/create', [DashboardController::class, 'make_payments'])->name('admin.dashboard.payments.create');
    });
});
