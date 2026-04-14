@extends('layouts.app')

@section('title', 'Dashboard - Toko Plastik Diza')

@section('content')
<div class="mb-4">
    <h1 class="h2">Dashboard Toko Plastik Diza</h1>
    <p class="text-muted">Sistem Monitoring Stok & Pembayaran</p>
</div>

<!-- Statistik Utama -->
<div class="row mb-5">
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="card-title text-muted mb-0">Total Produk</h6>
                        <h2 class="text-primary mb-0">{{ $totalBarang ?? 0 }}</h2>
                    </div>
                    <div class="fs-1 text-primary opacity-50">📦</div>
                </div>
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
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card border-0 shadow-sm bg-warning bg-opacity-10">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="card-title text-muted mb-0">Stok Menipis ⚠️</h6>
                        <h2 class="text-warning mb-0">{{ $stokMenipis ?? 0 }}</h2>
                    </div>
                    <div class="fs-1 text-warning opacity-50">⚠️</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card border-0 shadow-sm bg-danger bg-opacity-10">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="card-title text-muted mb-0">Stok Habis 🚫</h6>
                        <h2 class="text-danger mb-0">{{ $stokHabis ?? 0 }}</h2>
                    </div>
                    <div class="fs-1 text-danger opacity-50">🚫</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Menu Cepat -->
<div class="row mb-5">
    <div class="col-12">
        <h5 class="mb-3">Menu Cepat</h5>
        <div class="d-grid gap-2 d-sm-flex flex-wrap">
            <a href="{{ route('barang.index') }}" class="btn btn-primary">
                <i class="fas fa-boxes"></i> Kelola Produk
            </a>
            <a href="{{ route('stok-masuk.index') }}" class="btn btn-success">
                <i class="fas fa-arrow-down"></i> Stok Masuk
            </a>
            <a href="{{ route('stok-keluar.index') }}" class="btn btn-danger">
                <i class="fas fa-arrow-up"></i> Stok Keluar
            </a>
            <a href="{{ route('pembayaran.index') }}" class="btn btn-info">
                <i class="fas fa-money-bill"></i> Pembayaran Pelanggan
            </a>
        </div>
    </div>
</div>

<!-- Barang dengan Stok Menipis -->
@if($barangStokRendah->count() > 0)
<div class="row mb-5">
    <div class="col-12">
        <div class="card border-0 shadow-sm border-top border-warning border-3">
            <div class="card-header bg-light">
                <h5 class="mb-0">⚠️ Produk dengan Stok Rendah (< 10)</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Produk</th>
                                <th>Kategori</th>
                                <th>Stok Saat Ini</th>
                                <th>Satuan</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($barangStokRendah as $barang)
                                <tr>
                                    <td><strong>{{ $barang->nama_barang }}</strong></td>
                                    <td>{{ $barang->kategori->nama_kategori ?? '-' }}</td>
                                    <td>
                                        <span class="badge bg-warning text-dark">{{ $barang->stok }}</span>
                                    </td>
                                    <td>{{ $barang->satuan }}</td>
                                    <td>
                                        @if($barang->stok == 0)
                                            <span class="badge bg-danger">Habis</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Segera Pesan</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Monitoring Stok Semua Barang -->
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light">
                <h5 class="mb-0">📋 Monitoring Stok Semua Produk</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0" id="tabelStok">
                        <thead class="table-light">
                            <tr>
                                <th>Produk</th>
                                <th>Kategori</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Satuan</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($semuaBarang as $barang)
                                <tr class="@if($barang->stok == 0) table-danger @elseif($barang->stok < 10) table-warning @endif">
                                    <td><strong>{{ $barang->nama_barang }}</strong></td>
                                    <td>{{ $barang->kategori->nama_kategori ?? '-' }}</td>
                                    <td>Rp {{ number_format($barang->harga, 0, ',', '.') }}</td>
                                    <td>
                                        @if($barang->stok == 0)
                                            <span class="badge bg-danger">0</span>
                                        @elseif($barang->stok < 10)
                                            <span class="badge bg-warning text-dark">{{ $barang->stok }}</span>
                                        @else
                                            <span class="badge bg-success">{{ $barang->stok }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $barang->satuan }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('barang.edit', $barang->id_barang) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">Belum ada produk</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script>
// Tambahkan pencarian real-time jika diperlukan
document.addEventListener('DOMContentLoaded', function() {
    // Refresh data setiap 30 detik
    setInterval(function() {
        // location.reload();
    }, 30000);
});
</script>
@endpush

@endsection