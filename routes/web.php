<?php

use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});
Route::get('/invoice', function () {
    return view('pages/invoice');
});
Route::post('/invoice', [InvoicesController::class, 'makeInvoice']);

Route::get('/privacy-policy', function () {
    return view('pages.privacy');
});
Route::get('/terms-of-service', function () {
    return view('pages.terms');
});
Route::get('/contact-us', function () {
    return view('pages.contact');
});
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
