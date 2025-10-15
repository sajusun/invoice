<?php

use App\Http\Controllers\Admin\AdminNotificationController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\UserNotificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::middleware(['web','auth:sanctum'])->prefix('user')->name('user.')->group(function () {
    Route::get('/notifications', [UserNotificationController::class, 'index'])->name('notifications');
    Route::post('/notifications/read/{id}', [UserNotificationController::class, 'markAsRead'])->name('notifications.read');
});


Route::middleware(['web','auth:admin'])->name('admin.')->group(function () {
    Route::get('admin/notifications', [AdminNotificationController::class, 'index'])->name('notifications');
    Route::post('admin/notifications/read/{id}', [AdminNotificationController::class, 'markAsRead'])->name('notifications.read');
});



