<?php

use App\Http\Controllers\Api\CustomerAuthController;
use Illuminate\Support\Facades\Route;

// ----------------------------------------------------
// PUBLIC CUSTOMER ROUTES
// Customer does NOT need to be logged in yet.
// ----------------------------------------------------

Route::post('/customer/activate', [
    CustomerAuthController::class,
    'activate'
]);

Route::post('/customer/login', [
    CustomerAuthController::class,
    'login'
]);


// ----------------------------------------------------
// PROTECTED CUSTOMER ROUTES
// Requires Sanctum token.
// ----------------------------------------------------

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/customer/membership', [
        CustomerAuthController::class,
        'membership'
    ]);

    Route::get('/customer/transactions', [
    CustomerAuthController::class,
    'transactions'
]);

});