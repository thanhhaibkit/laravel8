<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JwtAuthController;

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
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/

Route::prefix('v1.0')->group(function () {
    Route::group([
        'middleware' => 'api',
        'prefix' => 'auth'
    ], function ($router) {
        // Below mention routes are public, user can access those without any restriction.
        // Create New User
        Route::post('register', [JwtAuthController::class, 'register']);
        // Login User
        Route::post('login', [JwtAuthController::class, 'login']);

        // Below mention routes are available only for the authenticated users.
        // -> move to controller constractor
        //Route::middleware('auth:api')->group(function () {
            // Refresh the JWT Token
            Route::get('refresh', [JwtAuthController::class, 'refresh']);
            // Get user info
            Route::get('user', [JwtAuthController::class, 'user']);
            // Logout user from application
            Route::post('logout', [JwtAuthController::class, 'logout']);
        //});
    });
});
