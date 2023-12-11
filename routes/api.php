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

Route::post('/v1/register/customer', [App\Http\Controllers\api\v1\AuthController::class, 'registerCustomer'])->name('api.creation_customer');
Route::post('/v1/register/supplier', [App\Http\Controllers\api\v1\AuthController::class, 'registerSupplier'])->name('api.creation_supplier');
Route::post('/v1/register/administrator', [App\Http\Controllers\api\vi\AuthController::class, 'registerAdministrator'])->name('api.creation_administrator');


Route::middleware('auth:sanctum')->group(function () {
    //ruta para el CRUD de usuarios

    Route::post('/v1/logout', [App\Http\Controllers\api\v1\AuthController::class, 'logout'])->name('api.logout');
    Route::singleton('/v1/location', App\Http\Controllers\api\v1\LocationController::class);
    Route::post('/v1/location', [App\Http\Controllers\api\v1\LocationController::class, 'store']);
    Route::apiResource('/v1/applications', App\Http\Controllers\api\v1\ApplicationController::class);

    Route::middleware('checkCustomerIdentifier')->group(function () {
        //Se definen las rutas a las que tiene acceso customer
        Route::singleton('/v1/customers/profile', App\Http\Controllers\api\v1\CustomerController::class);
        //Se definen las rutas a las que tiene acceso customer una vez haya ingresado su dirección residencial
        Route::middleware('checkCustomerLocation')->group(function () {
            Route::apiResource('/v1/suppliers/{id}/messages', App\Http\Controllers\api\v1\MessageController::class)->except(['update', 'destroy']);
            Route::apiResource('/v1/suppliers/{id}/ratings', App\Http\Controllers\api\v1\RatingController::class);
            Route::apiResource('/v1/suppliers/{id}/contracts', App\Http\Controllers\api\v1\ContractController::class)->except(['store', 'destroy']);
        });
    }); 
    
    Route::middleware('checkSupplierIdentifier')->group(function () {
        //Se definen las rutas a las que tiene acceso supplier
        Route::singleton('/v1/suppliers/profile', App\Http\Controllers\api\v1\SupplierController::class);//->only(['show', 'update']);
        //Se definen las rutas a las que tiene acceso supplier una vez haya ingresado la dirección del establecimiento
        Route::middleware('checkSupplierLocation')->group(function () {
            Route::apiResource('/v1/customers/{id}/messages', App\Http\Controllers\api\v1\MessageController::class)->except(['update', 'destroy']);
            Route::get('/v1/ratings', [App\Http\Controllers\api\v1\RatingController::class, 'list']);
            Route::apiResource('/v1/customers/{id}/contracts', App\Http\Controllers\api\v1\ContractController::class)->except(['update', 'destroy']);
        });
    });   

    Route::middleware(['checkAdminIdentifier'])->group(function () {
        // Definir rutas para las funciones de administración aquí
        Route::singleton('/v1/administrators/profile', App\Http\Controllers\api\v1\AdministratorController::class);
        Route::get('/v1/suppliers/{id}/ratings', [App\Http\Controllers\api\v1\RatingController::class, ['index', 'show']]);
        Route::get('/v1/contracts', [App\Http\Controllers\api\v1\ContractController::class, ['list', 'ShowSinParametros']]);
    });

    //Route::apiResource('/v1/suppliers', App\Http\Controllers\api\v1\SupplierController::class)->only(['index'])->middleware('checkCustomerIdentifier', 'checkAdminIdentifier');
    //Route::apiResource('/v1/customers', App\Http\Controllers\api\v1\CustomerController::class)->only(['index'])->middleware('checkSupplierIdentifier', 'checkAdminIdentifier');
}
); 