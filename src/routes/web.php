<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClockController;
use App\Http\Controllers\RegisterUserController;
use App\Http\Controllers\AttendanceController;
use Illuminate\Support\Facades\Storage;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('auth')->group(function () {
    Route::get('/email/verify',[RegisterUserController::class,'notice'])->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}',[RegisterUserController::class,'verify'])->middleware('signed')->name('verification.verify');
    Route::post('/email/verification-notification',[RegisterUserController::class,'resend'])
    ->middleware('throttle:6,1')->name('verification.send');
});

Route::middleware(['auth','verified'])->group(function () {
    Route::get('/', [ClockController::class, 'index'])->name('home');
    Route::post('/clock-in', [ClockController::class, 'clockIn'])->name('clock-in');
    Route::post('/clock-out', [ClockController::class, 'clockOut'])->name('clock-out');
    Route::post('/break-start', [ClockController::class, 'breakStart'])->name('break.start');
    Route::post('/break-end', [ClockController::class, 'breakEnd'])->name('break.end');
});

Route::middleware(['auth','admin', 'verified'])->group(function () {
    Route::get('/attendance',[AttendanceController::class,'index']);
    Route::get('/attendance/users',[AttendanceController::class,'list']);
    Route::get('/attendance/search',[AttendanceController::class,'search'])->name('attendance.search');
    Route::patch('/user/update', [AttendanceController::class, 'updateUser']);
    Route::delete('/user/delete', [AttendanceController::class, 'deleteUser']);

    Route::get('/attendance/user/{id}', [AttendanceController::class, 'show'])->name('attendance.show');
    Route::patch('/update', [AttendanceController::class, 'update']);
    Route::delete('/delete', [AttendanceController::class, 'delete']);
});

Route::post('/register', [RegisterUserController::class, 'store']);





