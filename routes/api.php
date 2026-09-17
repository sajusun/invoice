<?php

use App\Http\Controllers\Admin\AdminNotificationController;
use App\Http\Controllers\Api\V1\CustomerApiController;
use App\Http\Controllers\Api\V1\InvoiceApiController;
use App\Http\Controllers\Api\V1\MeApiController;
use App\Http\Controllers\UserNotificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Legacy Sanctum user endpoint
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// User notifications
Route::middleware(['web', 'auth:sanctum'])->prefix('user')->name('user.')->group(function () {
    Route::get('/notifications', [UserNotificationController::class, 'index'])->name('notifications');
    Route::post('/notifications/read/{id}', [UserNotificationController::class, 'markAsRead'])->name('notifications.read');
});

// Admin notifications
Route::middleware(['web', 'auth:admin'])->name('admin.')->group(function () {
    Route::get('admin/notifications', [AdminNotificationController::class, 'index'])->name('notifications');
    Route::post('admin/notifications/read/{id}', [AdminNotificationController::class, 'markAsRead'])->name('notifications.read');
});

/*
|--------------------------------------------------------------------------
| Developer RESTful API (V1) - Invoicing-as-a-Service
|--------------------------------------------------------------------------
| Authenticated via Secret Key: Authorization: Bearer inv_live_sk_...
*/
Route::prefix('v1')->middleware(['auth.api_key', 'throttle:120,1'])->group(function () {
    // Developer profile & quota stats
    Route::get('/me', [MeApiController::class, 'show']);
    Route::get('/me/usage', [MeApiController::class, 'usage']);

    // Invoices API
    Route::get('/invoices', [InvoiceApiController::class, 'index']);
    Route::post('/invoices', [InvoiceApiController::class, 'store']);
    Route::get('/invoices/{id}', [InvoiceApiController::class, 'show']);
    Route::match(['put', 'patch'], '/invoices/{id}', [InvoiceApiController::class, 'update']);
    Route::post('/invoices/{id}/mark-paid', [InvoiceApiController::class, 'markPaid']);
    Route::post('/invoices/{id}/send-email', [InvoiceApiController::class, 'sendEmail']);
    Route::post('/invoices/{id}/duplicate', [InvoiceApiController::class, 'duplicate']);
    Route::delete('/invoices/{id}', [InvoiceApiController::class, 'destroy']);
    Route::get('/invoices/{id}/pdf', [InvoiceApiController::class, 'pdf']);

    // Customers API
    Route::get('/customers', [CustomerApiController::class, 'index']);
    Route::post('/customers', [CustomerApiController::class, 'store']);
    Route::get('/customers/{id}', [CustomerApiController::class, 'show']);
    Route::match(['put', 'patch'], '/customers/{id}', [CustomerApiController::class, 'update']);
    Route::delete('/customers/{id}', [CustomerApiController::class, 'destroy']);
});
