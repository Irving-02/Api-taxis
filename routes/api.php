<?php

use App\Http\Controllers\CobroController;
use App\Http\Controllers\EstadoDeCuentaController;
use App\Http\Controllers\GastoController;
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

Route::middleware('auth:sanctum')->get('/clientAuth', [AuthController::class, 'client']);
Route::middleware('auth:sanctum')->group(function () {

    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
    //taxis
    Route::get('/taxis', [TaxiController::class, 'index']);
    Route::post('/taxis', [TaxiController::class, 'store']);
    Route::get('/taxis/{id}', [TaxiController::class, 'show']);
    Route::put('/{id}', [TaxiController::class, 'update']);
    Route::delete('/{id}', [TaxiController::class, 'destroy']);
    Route::get('/total_carros', [TaxiController::class, 'countTaxis']);
    Route::get('/total_taxis', [TaxiController::class, 'countEspeciales']);
    Route::get('/total_tolerados', [TaxiController::class, 'countTolerados']);
    Route::get('/total_verificados', [TaxiController::class, 'countVerificados']);
    Route::apiResource('pagos', CobroController::class);
    Route::apiResource('gastos', GastoController::class);

    Route::apiResource('estado-de-cuenta', EstadoDeCuentaController::class);

});