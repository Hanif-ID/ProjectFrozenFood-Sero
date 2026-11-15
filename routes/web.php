<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\VendorRegisterController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Halaman awal: arahkan sesuai status login
Route::get('/', function () {
    return Auth::check()
        ? redirect()->route(Auth::user()->homeRoute())
        : redirect()->route('login');
});

// Login & Register (hanya untuk tamu / belum login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->middleware('throttle:10,1')->name('login.post');

    Route::get('/register', [VendorRegisterController::class, 'showRegistrationForm'])->name('vendor.register');
    Route::post('/register', [VendorRegisterController::class, 'register'])->name('vendor.register.post');
});

// Logout
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

// Area Admin (harus login dan role = admin)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', fn () => view('Sero.dashboard'))->name('dashboard');

    // CRUD user: index, create, store, edit, update, destroy
    Route::resource('users', UserController::class)->except('show');
});

// Area Vendor (harus login dan role = vendor)
Route::middleware(['auth', 'role:vendor'])->prefix('vendor')->name('vendor.')->group(function () {
    Route::get('/dashboard', fn () => view('Sero.vendor-dashboard'))->name('dashboard');
});
