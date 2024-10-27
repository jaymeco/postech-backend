<?php

use App\Http\Customer\Controllers\CustomerController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::prefix('customer')->group(function () {
    Route::post('/', [CustomerController::class, 'create']);
});

