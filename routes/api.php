<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\Auth\LoginController;


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
//Route::post('/users', [ AuthController::class, 'Register']);
Route::post('/users', [\App\Http\Controllers\AuthController::class, 'Register']);
Route::get('/customers', [\App\Http\Controllers\CustomersController::class, 'getAllCustomers']);
Route::get('/customers/{id}', 'customersController@getCustomer');
Route::put('/users/{id}', 'AuthController@update');
Route::delete('/users/{id}', 'AuthController@deleteUser');

// Login route
Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'login']);






Route::middleware('auth:sanctum')->group(function () {
    Route::middleware(RoleMiddleware::class . ':admin')->group(function () {
        // Admin routes here
    });

    Route::middleware(RoleMiddleware::class . ':user')->group(function () {
        // User routes here

    });
});




// Protected routes that require authentication
Route::group(['middleware' => 'auth:sanctum'], function () {
    // Optional logout route
    Route::post('/logout', 'Auth\LoginController@logout');
});
