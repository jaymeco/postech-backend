<?php

use App\Http\Customer\Controllers\CustomerController;
use App\Http\Customer\Controllers\OrderController as CustomerOrderController;
use App\Http\Establishment\Controllers\OrderController;
use App\Http\Establishment\Controllers\ProductController;
use App\Http\Mock\Controllers\MockPaymentController;
use App\Http\Webhook\Controllers\OrderController as WebhookOrderController;
use Illuminate\Support\Facades\Route;

Route::prefix('customer')->group(function () {
    Route::post('/', [CustomerController::class, 'create']);

    Route::prefix('orders')->group(function () {
        Route::prefix('{orderUuid}')->group(function () {
            Route::get('/', [CustomerOrderController::class, 'getByUuid']);
            Route::get('/check-payment', [CustomerOrderController::class, 'checkOrderPayment']);
            Route::put('/checkout', [CustomerOrderController::class, 'checkout']);
        });
        Route::post('/', [CustomerOrderController::class, 'create']);
    });
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
            Route::delete('/', [ProductController::class, 'delete']);
        });
    });
    Route::prefix('orders')->group(function () {
        Route::get('/', [OrderController::class, 'list']);
    });
});

Route::prefix('mock')->group(function () {
    Route::post('/qrs', [MockPaymentController::class, 'sendQrCode']);
});

Route::prefix('v1/webhooks')->group(function () {
    Route::post('/orders/{orderUUid}/process-payment', [WebhookOrderController::class, 'processPayment']);
});
