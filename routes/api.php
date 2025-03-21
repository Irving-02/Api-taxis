<?php

use App\Http\Controllers\TaxiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
    //taxis
    Route::get('/taxis', [TaxiController::class, 'index']);
    Route::post('/taxis', [TaxiController::class, 'store']);
    Route::get('/taxis/{id}', [TaxiController::class, 'show']);
    Route::put('/{id}', [TaxiController::class, 'update']);
    Route::delete('/{id}', [TaxiController::class, 'destroy']);
});