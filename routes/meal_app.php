<?php

use App\Http\Controllers\MealApp\BalanceController;
use App\Http\Controllers\MealApp\ExpenseController;
use App\Http\Controllers\MealApp\ManagerController;
use App\Http\Controllers\MealApp\UserController;
use Illuminate\Support\Facades\Route;

Route::post('mealApp/register', [ManagerController::class, 'store']);
Route::post('mealApp/login', [ManagerController::class, 'login']);
Route::post('mealApp/user-login',[UserController::class, 'loginUser']);
Route::post('mealApp/forgot-password', [ManagerController::class, 'forgotPassword']);
Route::post('mealApp/reset-password', [ManagerController::class, 'resetPassword']);

Route::middleware(['auth:sanctum'])->group(function () {
Route::get('mealApp/get-all-users', [UserController::class, 'getAllUsers']);
Route::get('mealApp/get-all-balance/{month}', [BalanceController::class, 'getBalanceByMonth']);
Route::get('mealApp/get-all-expenses/{month}', [ExpenseController::class, 'getExpensesByMonth']);
Route::post('mealApp/logout', [UserController::class, 'logoutUser']);
Route::get('mealApp/getManagers', [ManagerController::class, 'index']);

});
Route::middleware(['auth:sanctum', 'manager'])->group(function () {
Route::post('mealApp/logout-manager', [ManagerController::class, 'logoutManager']);
Route::post('mealApp/create-user', [UserController::class, 'createUser']);
Route::post('mealApp/add-balance', [BalanceController::class, 'store']);
Route::post('mealApp/add-expense', [ExpenseController::class, 'store']);
Route::delete('mealApp/delete-expense/{id}', [ExpenseController::class, 'destroy']);
Route::delete('mealApp/delete-manager/{id}', [BalanceController::class, 'destroy']);
Route::get('mealApp/user-search', [UserController::class, 'userSearch']);
Route::get('mealApp/user-search/{query}', [UserController::class, 'userSearchApp']);
Route::delete('mealApp/delete-user/{id}', [UserController::class, 'deleteUser']);

});
