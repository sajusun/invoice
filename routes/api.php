<?php

use App\Http\Controllers\CustomersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
//Route::get('customers/{number}', [CustomersController::class,'info_by_number']);



//meal app api below
require __DIR__.'/meal_app.php';
