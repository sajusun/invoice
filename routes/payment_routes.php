<?php

use App\Http\Controllers\HomePageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\TwoCheckoutController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/payment/{plan}', [PaymentController::class, 'showPaymentForm'])->name('payment.form');
//    Route::post('/payment/process', [PaymentController::class, 'processPayment'])->name('payment.process');
    Route::post('/payment/process', [HomePageController::class, 'maintenanceMode'])->name('payment.process');

//    Route::get('/stripe/checkout', [StripePaymentController::class, 'createCheckoutSession'])->name('stripe.checkout');
//    Route::get('/stripe/success', [StripePaymentController::class, 'success'])->name('stripe.success');
//    Route::get('/stripe/cancel', [StripePaymentController::class, 'cancel'])->name('stripe.cancel');

    Route::get('/checkout', [TwoCheckoutController::class, 'redirectToCheckout'])->name('twocheckout.checkout');
    Route::get('/payment-success', [TwoCheckoutController::class, 'paymentSuccess'])->name('twocheckout.success');

});

