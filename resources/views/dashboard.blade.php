@extends('layouts.app')

@section('title', 'Dashboard - Toko Plastik Diza')

@section('content')
<div class="mb-4">
    <h1 class="h2">Dashboard</h1>
    <p class="text-muted">Selamat datang di Sistem Pengelolaan Stok Barang Toko Plastik Diza</p>
</div>

<!-- Statistics Cards -->
<div class="row mb-5">
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="card-title text-muted mb-0">Total Barang</h6>
                        <h2 class="text-primary mb-0">{{ $totalBarang ?? 0 }}</h2>
                    </div>
                    <div class="fs-1 text-primary opacity-50">📦</div>
                </div>
            </div>
            <div class="card-footer bg-light border-0">
                <small class="text-muted">
                    <a href="{{ route('barang.index') }}" class="text-decoration-none">
                        Lihat daftar →
                    </a>
                </small>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="card-title text-muted mb-0">Total Kategori</h6>
                        <h2 class="text-success mb-0">{{ $totalKategori ?? 0 }}</h2>
                    </div>
                    <div class="fs-1 text-success opacity-50">📂</div>
                </div>
            </div>
            <div class="card-footer bg-light border-0">
                <small class="text-muted">Kategori barang tersedia</small>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="card-title text-muted mb-0">Total Stok</h6>
                        <h2 class="text-info mb-0">{{ $totalStok ?? 0 }}</h2>
                    </div>
                    <div class="fs-1 text-info opacity-50">📊</div>
                </div>
            </div>
            <div class="card-footer bg-light border-0">
                <small class="text-muted">Seluruh stok barang</small>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="card-title text-muted mb-0">Transaksi Hari Ini</h6>
                        <h2 class="text-warning mb-0">{{ $transaksiHariIni ?? 0 }}</h2>
                    </div>
                    <div class="fs-1 text-warning opacity-50">📝</div>
                </div>
            </div>
            <div class="card-footer bg-light border-0">
                <small class="text-muted">Stok masuk + keluar</small>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row">
    <div class="col-12 mb-4">
        <h5 class="mb-3">Menu Cepat</h5>
        <div class="d-grid gap-2 d-sm-flex">
            <a href="{{ route('barang.create') }}" class="btn btn-primary btn-lg">+ Tambah Barang Baru</a>
            <a href="{{ route('barang.index') }}" class="btn btn-outline-primary btn-lg">📦 Kelola Barang</a>
            <a href="{{ route('stok-masuk.index') }}" class="btn btn-outline-success btn-lg">📥 Stok Masuk</a>
            <a href="{{ route('stok-keluar.index') }}" class="btn btn-outline-danger btn-lg">📤 Stok Keluar</a>
        </div>
    </div>
</div>

<!-- Info Section -->
<div class="row mt-5">
    <div class="col-12">
        <div class="alert alert-info" role="alert">
            <strong>ℹ️ Informasi:</strong> Sistem ini membantu Anda mengelola stok barang toko dengan efisien. 
            Kelola kategori barang, pantau stok masuk dan keluar, serta lihat laporan real-time.
        </div>
    </div>
</div>
@endsection