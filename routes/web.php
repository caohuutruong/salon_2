<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Middleware\CheckAuth;
Route::get('register', [AuthController::class, 'showRegister']);
Route::post('register', [AuthController::class, 'register'])->name('register');
Route::get('/', [AuthController::class, 'showLogin'])->name('ok');
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
// Bảo vệ route dashboard bằng middleware auth


Route::middleware([CheckAuth::class])->group(function () {
    Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
    Route::delete('/customers/{id}', [CustomerController::class, 'destroy'])->name('customers.destroy');
    Route::get('/customers/{id}', [CustomerController::class, 'show']);
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
