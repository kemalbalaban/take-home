<?php
use App\Http\Controllers\Api\OrderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DiscountController;

Route::controller(OrderController::class)->group(function () {
    Route::get('/orders', 'index');
    Route::post('/orders', 'store');
    Route::delete('orders/{order}', 'destroy');
});

Route::controller(DiscountController::class)->group(function () {
    Route::post('/discounts/{order_id}', 'applyDiscount');
    Route::get('/discounts/rules',  'getDiscountRules');
});
