<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('auth/login', [\App\Http\Controllers\AuthController::class, 'login']);
Route::middleware('auth:api')->group(function () {
    Route::post('auth/logout', [\App\Http\Controllers\AuthController::class, 'logout']);
    Route::get('auth/me', [\App\Http\Controllers\AuthController::class, 'me']);
});
