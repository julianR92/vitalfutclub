<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Api\ClienteApiController;
use App\Http\Controllers\Api\PlanApiController;
use App\Http\Controllers\Api\CiudadApiController;

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
// Endpoint 4: Get all active cities- ruta publica
Route::get('/ciudades', [CiudadApiController::class, 'getCiudades']);

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {


    Route::get('/user', fn(Request $request) => $request->user());
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/staff', [UserController::class, 'getStaff']);

    // ========================================
    // Payment Gateway API Endpoints
    // ========================================

    // Endpoint 1: Get client information by document
    Route::get('/cliente/{documento}', [ClienteApiController::class, 'getByDocumento']);

    // Endpoint 2: Verify if client has active plan in date range
    Route::post('/verify-plan', [PlanApiController::class, 'verifyPlan']);

    // Endpoint 3: Get all visible plans with details
    Route::get('/planes/visibles', [PlanApiController::class, 'getPlanesVisibles']);



    // Endpoint 5: Get all visible plans by city
    Route::get('/ciudades/{ciudadId}/planes', [CiudadApiController::class, 'getPlanesByCiudad']);
});


