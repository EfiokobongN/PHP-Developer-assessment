<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Artisan;
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
Route::get('/create-symlink', function(){
    if (!file_exists(public_path('storage'))) {
        symlink(storage_path('app/public'), public_path('storage'));
        return "Symlink created successfully!";
    }
    return "Symlink already exists!";
});


Route::get('/clear-cache', function () {
    // Clear cache
    $exitCode = Artisan::call('cache:clear');
    
    // Re-cache configuration
    $exitCode = Artisan::call('config:cache');
    
    // Run migrations
    $exitCode = Artisan::call('migrate', ['--force' => true]);

    return 'Cache cleared, config cached, and migrations run successfully.';
});
Route::get('/', function () {
    return view('welcome');
})->name("user.signIn");
//
Route::get('freedom/registration', function () {
    return view('users.register');
})->name("user.account");


Route::post('freedom/register', [AuthController::class, "register"])->name("user.register");
Route::post('freedom/login', [AuthController::class, "login"])->name("user.login");


Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', [UsersController::class, "index"])->name("user.index");
    Route::post('dashboard/store-customer', [UsersController::class, "storeCustomer"])->name("user.storeCustomer");
    Route::delete('dashboard/delete-customer', [UsersController::class, "deleteCustomer"])->name("user.deleteCustomer");
    Route::PUT('dashboard/edit-customer', [UsersController::class, "editCustomer"])->name("user.editCustomer");
});
