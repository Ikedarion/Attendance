<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\PurchaseController;
use Illuminate\Support\Facades\Route;

Route::get('/items', [ItemController::class, 'index']);
Route::get('/items/search', [ItemController::class, 'search']);
Route::get('/items/{item_id}', [ItemController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/cart_items', [CartItemController::class, 'index']);
    Route::post('/cart_items', [CartItemController::class, 'store']);
    Route::patch('/cart_items/{cart_item_id}', [CartItemController::class, 'update']);
    Route::delete('/cart_items/{cart_item_id}', [CartItemController::class, 'destroy']);

    Route::post('/purchases', [PurchaseController::class, 'store']);
});
