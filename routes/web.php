<?php

use App\Events\AdminNotification;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomePageController::class, 'home'])->name('home');
Route::get('/home', [HomePageController::class, 'home'])->name('main');
Route::get('/subscription-plan', [SubscriptionController::class, 'index'])->name('choose-plan');


Route::get('/invoice/builder', [InvoicesController::class, 'view'])->name('invoice.builder');
Route::get('/invoice/theme', [InvoicesController::class, 'theme']);
Route::get('/invoice/{id}/preview', [InvoicesController::class, 'previewInvoice'])->name('previewInvoice');
Route::get('/invoice/preview', [InvoicesController::class, 'previewInvoice']);
Route::post('/invoice/create', [InvoicesController::class, 'makeInvoice']);

Route::get('/invoice/all', [InvoicesController::class, 'get_all_invoices'])->name('invoices');
Route::post('/invoice/{id}', [InvoicesController::class, 'get_invoice']);
Route::get('/invoice/search', [InvoicesController::class, 'search_invoice']);
Route::get('/invoice/status', [InvoicesController::class, 'change_status'])->name('changeStatus');

Route::get('invoice/find/customer/{number}', [CustomersController::class, 'find_by_number']);
Route::get('/dashboard/customers/{id}/view', [CustomersController::class, 'customer_details'])->name('customers.details');

Route::get('/dashboard/customers/{id}/update', [CustomersController::class, 'customers_data_update'])->name('customers.update');
Route::post('/dashboard/customers/{id}/update', [CustomersController::class, 'customers_data_update'])->name('customers.update');

Route::get('/dashboard/customers/search', [DashboardController::class, 'search_customers']);
Route::get('/dashboard/customers/{id}', [DashboardController::class, 'get_customer_data']);
Route::get('/dashboard/customers/{id}/invoice', [DashboardController::class, 'get_customer_invoice']);

Route::get('/privacy-policy', function () {
    return view('pages.privacy');
})->name('pp');
Route::get('/terms-of-service', function () {
    return view('pages.terms');
})->name('t&c');

// Static Pages
Route::view('/about', 'pages.about')->name('about');
Route::view('/careers', 'pages.careers')->name('careers');
Route::view('/blog', 'pages.blog')->name('blog');
Route::view('/guides', 'pages.guides')->name('guides');
Route::view('/support', 'pages.support')->name('support');
Route::view('/integrations', 'pages.integrations')->name('integrations');
Route::view('/api-docs', 'pages.api-docs')->name('api-docs');

Route::get('/contact-us', [HomePageController::class, 'contact_form'])->name('contact.form');
Route::post('/contact-us', [HomePageController::class, 'submit_contact'])->name('contact.form');

Route::get('/dashboard', [DashboardController::class, 'dashboard'])->middleware(['auth'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard/customers', [DashboardController::class, 'customers'])->name('customers');

    Route::get('/settings', [SettingsController::class, 'edit'])->name('settings.edit');
    Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');
    Route::get('dashboard/my-plan', [DashboardController::class, 'my_plan'])->name('subscription.plan');
});


Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/invoice/{invoiceNumber}/delete', [InvoicesController::class, 'delete_invoice']);
    Route::post('/customer/{id}/delete', [CustomersController::class, 'delete_customer']);
    //Route::get('/invoice/{invoiceNumber}/update', [InvoicesController::class, 'delete_invoice'])->name('invoice.update');
});

require __DIR__ . '/auth.php';
require __DIR__ . '/admin_routes.php';
require __DIR__ . '/payment_routes.php';
require __DIR__.'/admin/admin.php';
