<?php

use App\Http\Controllers\CustomersController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Support\Facades\Route;

//Route::get('/', function () {
//    return view('index');
//});

Route::get('/', [DashboardController::class, 'homePage'])->name('home');
Route::get('/pricing', [SubscriptionController::class, 'index'])->name('plan');


Route::get('/invoice/builder', [InvoicesController::class, 'view'])->name('invoiceBuilder');
Route::get('/invoice/theme', [InvoicesController::class, 'theme']);
Route::get('/invoice/{id}/preview', [InvoicesController::class, 'previewInvoice'])->name('previewInvoice');
Route::get('/invoice/preview', [InvoicesController::class, 'previewInvoice']);
Route::post('/invoice/create', [InvoicesController::class, 'makeInvoice']);

Route::get('/invoice/all', [InvoicesController::class, 'get_all_invoices']);
Route::post('/invoice/{id}', [InvoicesController::class, 'get_invoice']);
Route::get('/invoice/search', [InvoicesController::class, 'search_invoice']);
Route::get('/invoice/status', [InvoicesController::class, 'change_status'])->name('changeStatus');

Route::get('invoice/find/customer/{number}', [CustomersController::class, 'find_by_number']);
Route::get('/dashboard/customers', [DashboardController::class, 'customers'])->name('customers');
Route::get('/dashboard/customers/{id}/view', [CustomersController::class, 'customer_details'])->name('customers.details');

Route::get('/dashboard/customers/{id}/update', [CustomersController::class, 'customers_data_update'])->name('customers.update');
Route::post('/dashboard/customers/{id}/update', [CustomersController::class, 'customers_data_update'])->name('customers.update');

Route::get('/dashboard/customers/search', [DashboardController::class, 'search_customers']);
Route::get('/dashboard/customers/{id}', [DashboardController::class, 'get_customer_data']);
Route::get('/dashboard/customers/{id}/invoice', [DashboardController::class, 'get_customer_invoice']);

Route::get('/privacy-policy', function () {
    return view('pages.privacy');
});
Route::get('/terms-of-service', function () {
    return view('pages.terms');
});
Route::get('/contact-us', function () {
    return view('pages.contact');
});

Route::get('/dashboard',[DashboardController::class,'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/settings', [SettingsController::class, 'edit'])->name('settings.edit');
    Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');
});
Route::middleware(['auth','verified'])->group(function () {
    Route::post('/invoice/{invoiceNumber}/delete', [InvoicesController::class, 'delete_invoice']);
    Route::post('/customer/{id}/delete', [CustomersController::class, 'delete_customer']);
    //Route::get('/invoice/{invoiceNumber}/update', [InvoicesController::class, 'delete_invoice'])->name('invoice.update');
});

require __DIR__.'/auth.php';
require __DIR__.'/admin_routes.php';
