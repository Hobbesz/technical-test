<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PartController;
use App\Http\Controllers\TurbineController;
use App\Http\Controllers\WindFarmController;
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

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('wind-farms', WindFarmController::class)
        ->only('index', 'show', 'destroy');

    Route::apiResource('wind-farms.turbines', TurbineController::class)
        ->only('index', 'show');

    Route::apiResource('wind-farms.turbines.parts', PartController::class)
        ->only('index', 'show', 'update');
});
