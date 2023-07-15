<?php

use App\Http\Controllers\V1\TravelControllerV1;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::name('api.')->group(function () {
    Route::prefix('v1')->name('v1')->group(function () {
        Route::get('/travels', [TravelControllerV1::class, 'index'])->name('travelIndex');
    });
    Route::prefix('v1')->name('v1')->middleware('auth:sanctum', 'verified')->group(function () {
        // Route::get('/travels', [TravelControllerV1::class, 'index'])->name('travelIndex')->middleware('restrictRole:admin');
        Route::get('/travel', [TravelControllerV1::class, 'store'])->name('travelStore');
    });
});
