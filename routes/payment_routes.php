<?php
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::get('/payment/{plan}', [PaymentController::class, 'showPaymentForm'])->name('payment.form');
Route::post('/payment/process', [PaymentController::class, 'processPayment'])->name('payment.process');
