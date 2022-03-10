<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/attendances', [AttendanceController::class, 'index']);
    Route::post('/attendances/start', [AttendanceController::class, 'start']);
    Route::post('/attendances/end', [AttendanceController::class, 'end']);
    Route::post('/attendances', [AttendanceController::class, 'store']);
    Route::patch('/attendances/{attendance_id}', [AttendanceController::class, 'update']);
    Route::delete('/attendances/{attendance_id}', [AttendanceController::class, 'destroy']);

    Route::get('/users/{user_id}', [UserController::class, 'show']);
});
