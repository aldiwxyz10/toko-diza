<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\Auth\AuthController;

/**
 * Root Route - Redirect ke dashboard atau login
 */
Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('login');
});

/**
 * Authentication Routes (tanpa middleware auth)
 */
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

/**
 * Admin Routes (memerlukan login)
 */
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    /**
     * Dashboard Route
     */
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /**
     * Barang Routes (CRUD) - Kelola Produk
     */
    Route::resource('barang', BarangController::class);

    /**
     * Stok Routes - Kelola Stok Masuk dan Keluar
     */
    Route::get('/stok-masuk', function () {
        return view('stok-masuk.index');
    })->name('stok-masuk.index');

    Route::get('/stok-keluar', function () {
        return view('stok-keluar.index');
    })->name('stok-keluar.index');

    /**
     * Pembayaran Routes (untuk tracking pembayaran)
     */
    Route::get('/pembayaran', function () {
        return view('pembayaran.index');
    })->name('pembayaran.index');
});