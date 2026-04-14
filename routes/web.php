<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BarangController;

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