<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

Route::get('/orders', [OrderController::class, 'getActiveOrders']);

Route::get('/orders/{id}', [OrderController::class, 'show']);

Route::post('/orders', [OrderController::class, 'store']);

Route::post('/orders/{id}/advance', [OrderController::class, 'advance']);