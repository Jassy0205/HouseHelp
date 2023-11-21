<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/v1/login', [App\Http\Controllers\api\v1\AuthController::class, 'login'])->name('api.login');

Route::post('/v1/registro', [App\Http\Controllers\api\v1\UserController::class, 'store'])->name('api.creation_customer');
Route::post('/v1/registro_2', [App\Http\Controllers\api\v1\SupplierController::class, 'store'])->name('api.creation_supplier');

Route::middleware('auth:sanctum')->group(function () {
    //ruta para el CRUD de usuarios
    Route::singleton('/v1/profile', App\Http\Controllers\api\v1\CustomerController::class);

    Route::apiResource('/v1/messages', App\Http\Controllers\api\v1\MessageController::class);
    Route::post('/v1/logout', [App\Http\Controllers\api\v1\AuthController::class, 'logout'])->name('api.logout');

    Route::apiResource('/v1/customers', App\Http\Controllers\api\v1\CustomerController::class);
    Route::apiResource('/v1/locations', App\Http\Controllers\api\v1\LocationController::class);
    Route::apiResource('/v1/contracts', App\Http\Controllers\api\v1\ContractController::class);
    Route::apiResource('/v1/messages', App\Http\Controllers\api\v1\MessageController::class);
    Route::apiResource('/v1/ratings', App\Http\Controllers\api\v1\RatingController::class);
}
); 