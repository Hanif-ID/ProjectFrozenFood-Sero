<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\VendorRegisterController;
use Illuminate\Support\Facades\Route;

// Halaman utama
Route::view('/', 'welcome')->name('home');

// Autentikasi (Guest)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');

    Route::get('/register', [VendorRegisterController::class, 'showRegistrationForm'])->name('vendor.register');
    Route::post('/register', [VendorRegisterController::class, 'register'])->name('vendor.register.post');
});

// Logout
Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

// Rute Admin / Pemilik Toko
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', UserController::class);
});

// Rute Vendor
Route::middleware(['auth', 'role:vendor'])->prefix('vendor')->name('vendor.')->group(function () {
    Route::view('/dashboard', 'Sero.vendor-dashboard')->name('dashboard');
});