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
Route::controller(Api\AuthController::class)->prefix('auth')->group(function() {
    Route::post('register', 'register');
    Route::post('login', 'login');
    Route::middleware('auth:sanctum')->group(function() {
        Route::post('logout', 'logout');
        Route::get('user', 'getAuthenticatedUser');
    });
});

/*
* Protected routes
*/
Route::middleware('auth:sanctum')->group( function () {
    Route::apiResource('patients', Api\PatientController::class);
    Route::apiResource('sessions', Api\SessionController::class);
});

/**
 * Fallback function
 * Keep this at the end of the file
 */
Route::fallback(function(){
    return response()->json([
        'message' => 'Page Not Found. If error persists, contact info@ipmedth.nl'], 404);
});