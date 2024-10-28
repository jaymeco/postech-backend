<?php

use App\Http\Customer\Controllers\CustomerController;
use App\Http\Establishment\Controllers\ProductController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::prefix('customer')->group(function () {
    Route::post('/', [CustomerController::class, 'create']);
});

Route::prefix('establishment')->group(function () {
    Route::prefix('categories')->group(function () {
        Route::prefix('{categoryUuid}')->group(function () {
            Route::get('/products', [ProductController::class, 'getAllByCategory']);
        });
    });
    Route::prefix('products')->group(function () {
        Route::post('/', [ProductController::class, 'create']);
        Route::prefix('{productUuid}')->group(function () {
            Route::put('/', [ProductController::class, 'update']);
        });
    });
});
