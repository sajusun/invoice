<?php

use App\Http\Controllers\CustomersController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});
Route::get('/invoice', function () {
    return view('pages/invoice');
});
Route::post('/invoice/create', [InvoicesController::class, 'makeInvoice']);
Route::get('/invoice/all', [InvoicesController::class, 'get_all_invoices']);
Route::post('/invoice/{id}', [InvoicesController::class, 'get_invoice']);
Route::get('invoice/find/customer/{number}', [CustomersController::class, 'find_by_number']);


Route::get('/dashboard/customers', [DashboardController::class, 'customers'])->name('customers');
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

require __DIR__.'/auth.php';
