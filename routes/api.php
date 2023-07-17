<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\V1\TourController;
use App\Http\Controllers\V1\TravelController;
use Illuminate\Support\Facades\Route;

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

Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth:sanctum');

Route::name('api.')->group(function () {
    Route::prefix('v1')->name('v1')->group(function () {
        Route::get('/travels', [TravelController::class, 'index'])->name('travelIndex');
        Route::get('/travels/{travel:slug}/tours', [TourController::class, 'index'])->name('tourIndex');
    });
    Route::prefix('v1')->name('v1')->middleware('auth:sanctum')->group(function () {
        Route::middleware('restrictRole:admin')->group(function () {
            Route::post('/travel', [TravelController::class, 'store'])->name('travelStore');
            Route::post('/travels/{travel:slug}/tour', [TourController::class, 'store'])->name('tourStore');
        });
        Route::put('/travels/{travel:slug}', [TravelController::class, 'update'])->name('travelUpdate');
    });
});
