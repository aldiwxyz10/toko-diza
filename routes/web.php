<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\RequestStockController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect()->route('dashboard'));

require __DIR__.'/auth.php';

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ── ADMIN ONLY ──────────────────────────────────────────────────────
    Route::middleware(['role:admin'])->group(function () {

        Route::resource('barang', BarangController::class)->except(['index', 'show']);
        Route::resource('barang-masuk', BarangMasukController::class)->except(['edit', 'update']);
        Route::resource('barang-keluar', BarangKeluarController::class)->except(['edit', 'update']);
        Route::resource('user', UserController::class)->except(['show']);

        Route::patch('/request/{requestStock}/status', [RequestStockController::class, 'updateStatus'])
             ->name('request.updateStatus');

        Route::prefix('laporan')->name('laporan.')->group(function () {
            Route::get('/stok',   [LaporanController::class, 'stok'])->name('stok');
            Route::get('/masuk',  [LaporanController::class, 'masuk'])->name('masuk');
            Route::get('/keluar', [LaporanController::class, 'keluar'])->name('keluar');
        });
    });

    // ── USER ONLY ────────────────────────────────────────────────────────
    Route::middleware(['role:user'])->group(function () {
        Route::get('/request/create', [RequestStockController::class, 'create'])->name('request.create');
        Route::post('/request',        [RequestStockController::class, 'store'])->name('request.store');
        Route::delete('/request/{request}', [RequestStockController::class, 'destroy'])->name('request.destroy');
    });

    // ── ADMIN & USER ─────────────────────────────────────────────────────
    Route::get('/barang',            [BarangController::class, 'index'])->name('barang.index');
    Route::get('/barang/{barang}',   [BarangController::class, 'show'])->name('barang.show');
    
    Route::get('/request',           [RequestStockController::class, 'index'])->name('request.index');
    Route::get('/request/{request}', [RequestStockController::class, 'show'])->name('request.show');
});
