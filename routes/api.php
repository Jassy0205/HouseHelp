<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
//use App\Http\Middleware\heckCustomerIdentifier;

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

Route::middleware('auth:sanctum')->get('/user', function () {
    return $request->user();
});

Route::post('/v1/login', [App\Http\Controllers\api\v1\AuthController::class, 'login'])->name('api.login');

Route::post('/v1/registro', [App\Http\Controllers\api\v1\CustomerController::class, 'store'])->name('api.creation_customer');
Route::post('/v1/registro_2', [App\Http\Controllers\api\v1\SupplierController::class, 'store'])->name('api.creation_supplier');


Route::middleware('auth:sanctum')->group(function () {
    //ruta para el CRUD de usuarios

    Route::post('/v1/logout', [App\Http\Controllers\api\v1\AuthController::class, 'logout'])->name('api.logout');

    Route::middleware('checkCustomerIdentifier')->group(function () {
        Route::apiResource('/v1/profile', App\Http\Controllers\api\v1\CustomerController::class)->except(['index', 'store']);
        Route::apiResource('/v1/suppliers/{id}/messages', App\Http\Controllers\api\v1\MessageController::class)->except(['update', 'destroy']);
        Route::apiResource('/v1/suppliers/{id}/ratings', App\Http\Controllers\api\v1\RatingController::class)->except(['list']);
        Route::apiResource('/v1/suppliers/{id}/contracts', App\Http\Controllers\api\v1\ContractController::class)->except(['store', 'destroy']);
        Route::apiResource('/v1/suppliers', App\Http\Controllers\api\v1\SupplierController::class)->only(['index']);
    }); 
    
    Route::middleware('checkSupplierIdentifier')->group(function () {
        Route::apiResource('/v1/profile', App\Http\Controllers\api\v1\SupplierController::class)->except(['index', 'store']);
        Route::apiResource('/v1/customers', App\Http\Controllers\api\v1\CustomerController::class)->only(['index']);
        Route::apiResource('/v1/customers/{id}/messages', App\Http\Controllers\api\v1\MessageController::class)->except(['update', 'destroy']);
        Route::apiResource('/v1/ratings', App\Http\Controllers\api\v1\RatingController::class)->only(['list']);
        Route::apiResource('/v1/customers/{id}/contracts', App\Http\Controllers\api\v1\ContractController::class)->except(['update']);
    });    
    
    Route::apiResource('/v1/locations', App\Http\Controllers\api\v1\LocationController::class)->only(['store', 'show', 'update']);
    Route::apiResource('/v1/applications', App\Http\Controllers\api\v1\ApplicationController::class);

    //Admin- Route::apiResource('/v1/contracts', App\Http\Controllers\api\v1\ContractController::class)->only(['list', 'ShowSinParametros']);
    //Admin- Route::apiResource('/v1/customers', App\Http\Controllers\api\v1\CustomerController::class)->only(['index']);

    Route::middleware(['auth', 'admin'])->group(function () {
        // Definir rutas para las funciones de administración aquí
    });
}
); 