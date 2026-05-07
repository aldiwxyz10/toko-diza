@extends('layouts.app')
@section('title', 'Dashboard')
@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0 fw-bold">Dashboard</h4>
        <small class="text-muted">Selamat datang, {{ auth()->user()->name }}</small>
    </div>
    <a href="{{ route('request.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i> Request Stok
    </a>
</div>

<div class="row g-3 mb-4">
    <div class="col-sm-4">
        <div class="card text-center h-100">
            <div class="card-body">
                <i class="bi bi-box-seam fs-2 text-primary mb-2"></i>
                <h3 class="fw-bold mb-0">{{ $totalBarang }}</h3>
                <small class="text-muted">Total Barang</small>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card text-center h-100">
            <div class="card-body">
                <i class="bi bi-exclamation-triangle fs-2 text-warning mb-2"></i>
                <h3 class="fw-bold mb-0 text-warning">{{ $barangMenipis }}</h3>
                <small class="text-muted">Stok Menipis</small>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card text-center h-100">
            <div class="card-body">
                <i class="bi bi-x-circle fs-2 text-danger mb-2"></i>
                <h3 class="fw-bold mb-0 text-danger">{{ $barangHabis }}</h3>
                <small class="text-muted">Stok Habis</small>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <span><i class="bi bi-clipboard-check text-primary me-2"></i>Request Stok Saya</span>
                <div>
                    <span class="badge bg-warning">{{ $myPending }} Pending</span>
                    <span class="badge bg-success ms-1">{{ $myDisetujui }} Disetujui</span>
                </div>
            </div>
            <div class="card-body p-0">
                @forelse($myRequests as $req)
                <div class="d-flex justify-content-between align-items-center px-4 py-3 border-bottom">
                    <div>
                        <div class="fw-semibold" style="font-size:.875rem;">{{ $req->barang->nama_barang }}</div>
                        <small class="text-muted">Jumlah: {{ $req->jumlah }} · {{ $req->created_at->diffForHumans() }}</small>
                    </div>
                    <span class="badge bg-{{ $req->status_badge }} rounded-pill px-3">{{ ucfirst($req->status) }}</span>
                </div>
                @empty
                <div class="text-center text-muted py-4">
                    <i class="bi bi-inbox fs-3"></i><p class="mb-0 mt-2">Belum ada request</p>
                </div>
                @endforelse
            </div>
            @if($myRequests->count())
            <div class="card-footer">
                <a href="{{ route('request.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua Request</a>
            </div>
            @endif
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card">
            <div class="card-header"><i class="bi bi-exclamation-triangle text-danger me-2"></i>Barang Perlu Perhatian</div>
            <div class="card-body p-0" style="max-height:350px;overflow-y:auto;">
                @forelse($barangKritis as $barang)
                <div class="d-flex justify-content-between align-items-center px-4 py-2 border-bottom">
                    <div>
                        <div style="font-size:.875rem;font-weight:500;">{{ $barang->nama_barang }}</div>
                        <small class="text-muted">{{ $barang->kode_barang }}</small>
                    </div>
                    <span class="badge bg-{{ $barang->status_badge }} rounded-pill">
                        {{ $barang->stok === 0 ? 'Habis' : 'Sisa '.$barang->stok }}
                    </span>
                </div>
                @empty
                <div class="text-center text-muted py-4">
                    <i class="bi bi-check-circle fs-3 text-success"></i>
                    <p class="mb-0 mt-2">Semua stok aman</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection
