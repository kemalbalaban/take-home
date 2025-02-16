<?php
use App\Http\Controllers\Api\OrderController;
use Illuminate\Support\Facades\Route;

Route::controller(OrderController::class)->group(function () {
    Route::get('/orders', 'index');
    Route::post('/orders', 'store');
    Route::delete('orders/{order}', 'destroy');
});
