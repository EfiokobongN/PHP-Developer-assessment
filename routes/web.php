<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name("user.signIn");
//
Route::get('freedom/registration', function () {
    return view('users.register');
})->name("user.account");


Route::post('freedom/register' , [AuthController::class, "register"])->name("user.register");
Route::post('freedom/login' , [AuthController::class, "login"])->name("user.login");


Route::middleware(['auth'])->group(function () {
Route::get('dashboard' , [UsersController::class, "index"])->name("user.index");
Route::post('dashboard/store-customer' , [UsersController::class, "storeCustomer"])->name("user.storeCustomer");
});
