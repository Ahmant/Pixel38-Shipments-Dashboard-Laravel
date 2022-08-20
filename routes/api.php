<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\ShipmentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('auth')->controller(AuthController::class)->group(function () {
    Route::post('register', 'register')->name('register');
    Route::post('login', 'login')->name('login');
});

Route::prefix('email-verification')->controller(EmailVerificationController::class)->group(function () {
    Route::post('verify/{user}', 'verify');
});

Route::prefix('shipments')->middleware('auth:sanctum')->controller(ShipmentController::class)->group(function () {
    Route::get('', 'index');
    Route::post('', 'store');
    Route::get('{shipment}', 'show')->where('shipment', '[0-9]+');
    Route::put('{shipment}', 'update')->where('shipment', '[0-9]+');
    Route::delete('{shipment}', 'destroy')->where('shipment', '[0-9]+');
    Route::get('count-by-status', 'countByStatus');
});