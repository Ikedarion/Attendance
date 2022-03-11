<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ReservationController;

Route::get('/shops', [ShopController::class, 'index']);
Route::get('/shops/search', [ShopController::class, 'search']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/shops/{shop_id}', [ShopController::class, 'show']);

    Route::post('/likes', [LikeController::class, 'store']);
    Route::delete('/likes/{like_id}', [LikeController::class, 'destroy']);

    Route::get('/users/{usere_id}', [UserController::class, 'show']);

    Route::post('/reservations', [ReservationController::class, 'store']);
    Route::patch('/reservations/{reservation_id}', [ReservationController::class, 'update']);
    Route::delete('/reservations/{reservation_id}', [ReservationController::class, 'destroy']);
});
