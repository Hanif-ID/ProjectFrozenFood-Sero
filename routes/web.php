<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\VendorRegisterController;
use App\Http\Controllers\Admin\UserController;

// Route untuk Frontend Register Vendor (Bisa diakses siapa saja)
Route::middleware('guest')->group(function () {
    Route::get('/register', [VendorRegisterController::class, 'showRegistrationForm'])->name('vendor.register');
    Route::post('/register', [VendorRegisterController::class, 'register'])->name('vendor.register.post');
});

// Route CRUD Khusus Admin (Harus login dan role = admin)
// Catatan: Pastikan Anda membuat middleware 'role' terlebih dahulu untuk mengecek apakah user adalah admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard'); // File dashboard Anda sebelumnya
    })->name('dashboard');
    
    // Ini akan otomatis membuat route CRUD (index, create, store, edit, update, destroy)
    Route::resource('users', UserController::class); 
});
Route::get('/', function () {
    return view('Sero.dashboard');
});
