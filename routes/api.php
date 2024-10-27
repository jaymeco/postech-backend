<?php

use App\Http\Customer\Controllers\CustomerController;
use App\Http\Establishment\Controllers\ProductController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::prefix('customer')->group(function () {
    Route::post('/', [CustomerController::class, 'create']);
});

Route::prefix('establishment')->group(function () {
    Route::prefix('products')->group(function () {
        Route::post('/', [ProductController::class, 'create']);
    });
});
