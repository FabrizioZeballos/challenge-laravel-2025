<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

// Testing route
Route::get('/ping', function () {
    return response()->json([
        'message' => 'pong',
        'status' => 'OK',
    ]);
});

Route::post('/orders', [OrderController::class, 'store']);