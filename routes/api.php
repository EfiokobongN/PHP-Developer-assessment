<?php

use App\Http\Controllers\Apis\AuthController;
use App\Http\Controllers\Apis\CustomerController;
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
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum' , 'identifier')->group(function () {
    Route::post('/customer/store', [CustomerController::class, 'apiStoreCustomer']);
    Route::post('/customer/edit/{id}', [CustomerController::class, 'apiEditCustomer']);
    Route::get('/customer/get/{id}', [CustomerController::class, 'getCustomer']);
});

