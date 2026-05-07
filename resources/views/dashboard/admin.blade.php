@extends('layouts.app')
@section('title', 'Dashboard Admin')
@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0 fw-bold">Dashboard Admin</h4>
        <small class="text-muted">Selamat datang, {{ auth()->user()->name }}</small>
    </div>
    <span class="badge bg-primary">{{ now()->isoFormat('dddd, D MMMM Y') }}</span>
</div>

<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <p class="text-muted mb-1" style="font-size:.8rem;">Total Barang</p>
                        <h3 class="fw-bold mb-0">{{ $totalBarang }}</h3>
                        <small class="text-muted">jenis produk</small>
                    </div>
                    <div class="p-2 bg-primary bg-opacity-10 rounded-3">
                        <i class="bi bi-box-seam text-primary fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <p class="text-muted mb-1" style="font-size:.8rem;">Total Stok</p>
                        <h3 class="fw-bold mb-0">{{ number_format($totalStok) }}</h3>
                        <small class="text-success">+{{ number_format($masukBulanIni) }} masuk bulan ini</small>
                    </div>
                    <div class="p-2 bg-success bg-opacity-10 rounded-3">
                        <i class="bi bi-stack text-success fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <p class="text-muted mb-1" style="font-size:.8rem;">Stok Kritis</p>
                        <h3 class="fw-bold mb-0 text-danger">{{ $barangHabis + $barangMenipis }}</h3>
                        <small class="text-muted">{{ $barangHabis }} habis · {{ $barangMenipis }} menipis</small>
                    </div>
                    <div class="p-2 bg-danger bg-opacity-10 rounded-3">
                        <i class="bi bi-exclamation-triangle text-danger fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <p class="text-muted mb-1" style="font-size:.8rem;">Request Pending</p>
                        <h3 class="fw-bold mb-0 text-warning">{{ $requestPending }}</h3>
                        <small class="text-muted">menunggu persetujuan</small>
                    </div>
                    <div class="p-2 bg-warning bg-opacity-10 rounded-3">
                        <i class="bi bi-clipboard-check text-warning fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <span><i class="bi bi-exclamation-circle text-danger me-2"></i>Barang Stok Kritis</span>
                <a href="{{ route('laporan.stok') }}" class="btn btn-sm btn-outline-danger">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                @forelse($barangKritis as $barang)
                <div class="d-flex justify-content-between align-items-center px-4 py-3 border-bottom">
                    <div>
                        <div class="fw-semibold" style="font-size:.875rem;">{{ $barang->nama_barang }}</div>
                        <small class="text-muted">{{ $barang->kode_barang }}</small>
                    </div>
                    <span class="badge bg-{{ $barang->status_badge }} rounded-pill px-3">Stok: {{ $barang->stok }}</span>
                </div>
                @empty
                <div class="text-center text-muted py-4">
                    <i class="bi bi-check-circle fs-3"></i><p class="mb-0 mt-2">Semua stok aman</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <span><i class="bi bi-clock-history text-primary me-2"></i>Request Terbaru</span>
                <a href="{{ route('request.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                @forelse($requestTerbaru as $req)
                <div class="d-flex justify-content-between align-items-center px-4 py-3 border-bottom">
                    <div>
                        <div class="fw-semibold" style="font-size:.875rem;">{{ $req->barang->nama_barang }}</div>
                        <small class="text-muted"><i class="bi bi-person"></i> {{ $req->user->name }} · {{ $req->jumlah }} pcs</small>
                    </div>
                    <span class="badge bg-{{ $req->status_badge }} rounded-pill px-3">{{ ucfirst($req->status) }}</span>
                </div>
                @empty
                <div class="text-center text-muted py-4">
                    <i class="bi bi-inbox fs-3"></i><p class="mb-0 mt-2">Belum ada request</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection
