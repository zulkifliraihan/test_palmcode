<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CountryController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('authentication')->group(function () {
    Route::middleware(['auth.jwt-token'])->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
    });
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});
Route::middleware(['auth.jwt-token'])->group(function () {
    Route::prefix('bookings')->group(function () {
        Route::get('/', [BookingController::class, 'index']);
        Route::post('/', [BookingController::class, 'create']);
        Route::get('/{id}', [BookingController::class, 'detail']);
        Route::post('/{id}', [BookingController::class, 'update']);
        Route::delete('/{id}', [BookingController::class, 'delete']);
    });
    
    Route::prefix('countries')->group(function () {
        Route::get('/', [CountryController::class, 'index']);
        Route::post('/', [CountryController::class, 'create']);
        Route::get('/{id}', [CountryController::class, 'detail']);
        Route::put('/{id}', [CountryController::class, 'update']);
        Route::delete('/{id}', [CountryController::class, 'delete']);
    });
    
});

Route::prefix('public')->group(function () {
    Route::get('/countries', [CountryController::class, 'index']);
    Route::post('/bookings/create', [BookingController::class, 'create']);

});