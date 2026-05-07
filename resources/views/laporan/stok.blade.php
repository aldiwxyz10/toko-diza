@extends('layouts.app')
@section('title', 'Laporan Stok')
@section('breadcrumb')
    <li class="breadcrumb-item active">Laporan Stok</li>
@endsection
@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold mb-0"><i class="bi bi-bar-chart-line me-2 text-primary"></i>Laporan Stok Barang</h4>
    <button class="btn btn-outline-secondary btn-sm" onclick="window.print()">
        <i class="bi bi-printer me-1"></i> Cetak
    </button>
</div>

<div class="card mb-3">
    <div class="card-body">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-3">
                <select name="jenis" class="form-select form-select-sm">
                    <option value="">-- Semua Jenis --</option>
                    @foreach($jenis as $j)
                        <option value="{{ $j }}" {{ request('jenis') == $j ? 'selected' : '' }}>{{ $j }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select form-select-sm">
                    <option value="">-- Semua Status --</option>
                    <option value="tersedia" {{ request('status') == 'tersedia' ? 'selected' : '' }}>Tersedia (>5)</option>
                    <option value="menipis"  {{ request('status') == 'menipis'  ? 'selected' : '' }}>Menipis (1-5)</option>
                    <option value="habis"    {{ request('status') == 'habis'    ? 'selected' : '' }}>Habis (0)</option>
                </select>
            </div>
            <div class="col-auto">
                <button class="btn btn-sm btn-primary"><i class="bi bi-filter"></i> Filter</button>
                <a href="{{ route('laporan.stok') }}" class="btn btn-sm btn-outline-secondary ms-1">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body py-3">
                <h4 class="fw-bold mb-0">{{ $barangs->count() }}</h4>
                <small class="text-muted">Total Item</small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body py-3">
                <h4 class="fw-bold mb-0">{{ number_format($barangs->sum('stok')) }}</h4>
                <small class="text-muted">Total Unit Stok</small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body py-3">
                <h4 class="fw-bold mb-0">Rp {{ number_format($totalNilai, 0, ',', '.') }}</h4>
                <small class="text-muted">Total Nilai Stok</small>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th><th>Kode</th><th>Nama Barang</th><th>Jenis</th>
                        <th class="text-center">Stok</th><th class="text-center">Status</th>
                        <th class="text-end">Harga</th><th class="text-end">Nilai Stok</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($barangs as $i => $barang)
                    <tr>
                        <td class="text-muted">{{ $i + 1 }}</td>
                        <td><span class="badge bg-light text-dark">{{ $barang->kode_barang }}</span></td>
                        <td class="fw-semibold">{{ $barang->nama_barang }}</td>
                        <td>{{ $barang->jenis }}</td>
                        <td class="text-center fw-bold">{{ number_format($barang->stok) }}</td>
                        <td class="text-center">
                            <span class="badge rounded-pill bg-{{ $barang->status_badge }}">
                                {{ ucfirst($barang->status_stok) }}
                            </span>
                        </td>
                        <td class="text-end">Rp {{ number_format($barang->harga, 0, ',', '.') }}</td>
                        <td class="text-end fw-semibold">Rp {{ number_format($barang->stok * $barang->harga, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="text-center text-muted py-4">Tidak ada data</td></tr>
                    @endforelse
                </tbody>
                @if($barangs->count())
                <tfoot class="table-light fw-bold">
                    <tr>
                        <td colspan="7" class="text-end">Total Nilai Stok:</td>
                        <td class="text-end text-primary">Rp {{ number_format($totalNilai, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>
</div>

@endsection
