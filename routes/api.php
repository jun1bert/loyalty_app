<?php

use App\Http\Controllers\Api\CustomerAuthController;
use Illuminate\Support\Facades\Route;

Route::post('/customer/activate', [
    CustomerAuthController::class,
    'activate'
]);

Route::post('/customer/login', [
    CustomerAuthController::class,
    'login'
]);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/customer/membership', [
        CustomerAuthController::class,
        'membership'
    ]);

});