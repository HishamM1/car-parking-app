<?php

use App\Http\Controllers\Api\v1\Auth\LoginController;
use App\Http\Controllers\Api\v1\Auth\RegisterController;
use App\Http\Controllers\Api\v1\Auth\ProfileController;
use App\Http\Controllers\Api\v1\Auth\PasswordUpdateController;
use App\Http\Controllers\Api\v1\Auth\LogoutController;
use App\Http\Controllers\Api\v1\VehicleController;
use App\Http\Controllers\Api\v1\ZoneController;
use App\Http\Controllers\Api\v1\ParkingController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('auth/register', RegisterController::class);
Route::post('auth/login', LoginController::class);
Route::get('zones', [ZoneController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('profile', [ProfileController::class, 'show']);
    Route::put('profile', [ProfileController::class, 'update']);
    Route::put('password', PasswordUpdateController::class);
    Route::post('auth/logout', LogoutController::class);

    Route::apiResource('vehicles', VehicleController::class);

    Route::get('parkings', [ParkingController::class, 'index']);
    Route::get('parkings/history', [ParkingController::class, 'history']);
    Route::get('parkings/{parking}', [ParkingController::class, 'show']);
    Route::post('parkings/start', [ParkingController::class, 'start']);
    Route::put('parkings/{parking}', [ParkingController::class, 'stop']);

});