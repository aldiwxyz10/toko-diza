<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\Auth\AuthController;

/**
 * Authentication Routes (tanpa middleware auth)
 */
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

/**
 * Pelanggan Routes (Katalog Produk) - TANPA LOGIN
 */
Route::get('/katalog', [PelangganController::class, 'katalog'])->name('pelanggan.katalog');
Route::get('/produk/{barang}', [PelangganController::class, 'detail'])->name('pelanggan.detail');

/**
 * Admin Routes (memerlukan login)
 */
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    /**
     * Dashboard Route
     */
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    /**
     * Barang Routes (CRUD)
     */
    Route::resource('barang', BarangController::class);

    /**
     * Stok Masuk Routes
     */
    Route::get('/stok-masuk', function () {
        return view('stok-masuk.index');
    })->name('stok-masuk.index');

    /**
     * Stok Keluar Routes
     */
    Route::get('/stok-keluar', function () {
        return view('stok-keluar.index');
    })->name('stok-keluar.index');
});