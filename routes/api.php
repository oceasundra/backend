<?php

use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TokenGeneratorController;
use App\Http\Controllers\UserController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::apiResource('/projects', ProjectController::class);

Route::post('/login', TokenGeneratorController::class);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', UserController::class);
    Route::post('logout', LogoutController::class);
});

