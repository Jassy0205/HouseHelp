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

// Route::middleware('auth:sanctum')->get('/user', function () {
//     return $request->user();
// });

Route::post('/v1/login', [App\Http\Controllers\api\v1\AuthController::class, 'login'])->name('api.login');

Route::post('/v1/register-customers', [App\Http\Controllers\api\v1\AuthController::class, 'registerCustomer'])->name('api.creation_customer');
Route::post('/v1/register-suppliers', [App\Http\Controllers\api\v1\AuthController::class, 'registerSupplier'])->name('api.creation_supplier');
Route::post('/v1/register-administrator', [App\Http\Controllers\api\vi\AuthController::class, 'registerAdministrator'])->name('api.creation_administrator');


Route::middleware('auth:sanctum')->group(function () {
    //ruta para el CRUD de usuarios

    Route::post('/v1/logout', [App\Http\Controllers\api\v1\AuthController::class, 'logout'])->name('api.logout');
    Route::singleton('/v1/location', App\Http\Controllers\api\v1\LocationController::class);
    Route::post('/v1/location', [App\Http\Controllers\api\v1\LocationController::class, 'store'])->name('api.creation_location');
    Route::apiResource('/v1/applications', App\Http\Controllers\api\v1\ApplicationController::class);//->name('api.applications');

    Route::middleware('checkCustomerIdentifier')->group(function () {
        //Se definen las rutas a las que tiene acceso customer
        Route::singleton('/v1/profile-customers', App\Http\Controllers\api\v1\CustomerController::class);//->name('api.customer.profile');
        //Se definen las rutas a las que tiene acceso customer una vez haya ingresado su dirección residencial
        Route::middleware('checkCustomerLocation')->group(function () {
            Route::apiResource('/v1/suppliers/{id}/messages', App\Http\Controllers\api\v1\MessageController::class)->except(['update', 'destroy']);//->name('api.suppliers_messages');
            Route::apiResource('/v1/suppliers/{id}/ratings', App\Http\Controllers\api\v1\RatingController::class);
            Route::apiResource('/v1/suppliers/{id}/contracts', App\Http\Controllers\api\v1\ContractController::class)->except(['store', 'destroy']);//->name('api.suppliers_contracts.display');
        });
    }); 
    
    Route::middleware('checkSupplierIdentifier')->group(function () {
        //Se definen las rutas a las que tiene acceso supplier
        Route::singleton('/v1/profile-suppliers', App\Http\Controllers\api\v1\SupplierController::class);
        //Se definen las rutas a las que tiene acceso supplier una vez haya ingresado la dirección del establecimiento
        Route::middleware('checkSupplierLocation')->group(function () {
            Route::apiResource('/v1/customers/{id}/messages', App\Http\Controllers\api\v1\MessageController::class)->except(['update', 'destroy']);//->name('api.customer_messages');
            Route::get('/v1/ratings', [App\Http\Controllers\api\v1\RatingController::class, 'list'])->name('api.ratings.display');
            Route::apiResource('/v1/customers/{id}/contracts', App\Http\Controllers\api\v1\ContractController::class)->except(['update', 'destroy']);//->name('api.customers_contracts');
        });
    });   

    Route::middleware(['checkAdminIdentifier'])->group(function () {
        // Definir rutas para las funciones de administración aquí
        Route::singleton('/v1/profile-administrators', App\Http\Controllers\api\v1\AdministratorController::class);
        //Route::put('v1/customers/{id}/administrators',  App\Http\Controllers\api\v1\AdministratorController::class, 'verifyCustomer')
        Route::get('/v1/suppliers/{id}', [App\Http\Controllers\api\v1\SupplierController::class, 'checkAndSuspendSupplier'])->name('api.suppliers.suspend');
        Route::post('/v1/administrators', [App\Http\Controllers\api\v1\AdministratorController::class, 'store'])->name('api.creation_admin');
        Route::get('/v1/contracts', [App\Http\Controllers\api\v1\ContractController::class, 'list'])->name('api.contracts.display');
        Route::get('/v1/contracts/{id}', [App\Http\Controllers\api\v1\ContractController::class, 'ShowSinParametros'])->name('api.contract.display');
        Route::put('vi/customers/{id}', [App\Http\Controllers\api\v1\CustomerController::class, 'verifyCustomer'])->name('api.customers.verification');
    });

    Route::middleware('CustomerAdminMiddleware')->group(function () {
        Route::get('/v1/suppliers/{id}/ratings', [App\Http\Controllers\api\v1\RatingController::class, 'index'])->name('api.suppliers_ratings.display');
        Route::get('/v1/suppliers', [App\Http\Controllers\api\v1\SupplierController::class, 'index'])->name('api.suppliers.display');
    });

    Route::middleware('SupplierAdminMiddleware')->group(function () {
        Route::get('/v1/customers', [App\Http\Controllers\api\v1\CustomerController::class, 'index'])->name('api.customers.display');
    });
}
); 