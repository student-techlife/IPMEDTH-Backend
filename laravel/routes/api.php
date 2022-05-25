<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api;

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

/*
* Routes for authentication
*/
Route::controller(Api\AuthController::class)->as('api.auth.')->prefix('auth')->group(function() {
    Route::post('register', 'register')->name('register');
    Route::post('login', 'login')->name('login');
    Route::middleware('auth:sanctum')->group(function() {
        Route::post('logout', 'logout')->name('logout');
        Route::get('user', 'getAuthenticatedUser')->name('user');
    });
});

/*
* Protected routes
*/
Route::middleware('auth:sanctum')->as('api.')->group( function () {
    Route::apiResource('patients', Api\PatientController::class)->names('patients');
    Route::apiResource('measurements', Api\MeasurementController::class)->names('measurements');
    Route::apiResource('sessions', Api\SessionController::class)->names('sessions');
});

/**
 * Fallback function
 * Keep this at the end of the file
 */
Route::fallback(function(){
    return response()->json([
        'message' => 'Page Not Found. If error persists, contact info@ipmedth.nl'], 404);
});