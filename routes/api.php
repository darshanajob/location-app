<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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
Route::get('/customers', 'CustomersController@getAllCustomers');
Route::get('/customers/{id}', 'customersController@getCustomer');
Route::put('/users/{id}', 'AuthController@update');
Route::delete('/users/{id}', 'AuthController@deleteUser');





Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
