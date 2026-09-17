<?php

use App\Http\Controllers\StripePaymentController;
use Illuminate\Support\Facades\Route;

// Public webhook route (Stripe calls this directly)
Route::post('/stripe/webhook', [StripePaymentController::class, 'webhook'])->name('stripe.webhook');

Route::middleware(['auth', 'verified'])->group(function () {
    // Checkout & Order Review
    Route::get('/checkout/{plan}', [StripePaymentController::class, 'showCheckout'])->name('payment.form');
    Route::get('/payment/{plan}', [StripePaymentController::class, 'showCheckout'])->name('payment.checkout');

    // Stripe Checkout Initiation
    Route::post('/stripe/checkout', [StripePaymentController::class, 'createCheckoutSession'])->name('stripe.checkout');

    // Success & Cancel Callbacks
    Route::get('/stripe/success', [StripePaymentController::class, 'success'])->name('stripe.success');
    Route::get('/stripe/cancel', [StripePaymentController::class, 'cancel'])->name('stripe.cancel');
});
