@extends('layouts.app')
@section('title', 'Laporan Barang Masuk')
@section('breadcrumb')
    <li class="breadcrumb-item active">Laporan Barang Masuk</li>
@endsection
@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold mb-0"><i class="bi bi-graph-up-arrow me-2 text-success"></i>Laporan Barang Masuk</h4>
    <button class="btn btn-outline-secondary btn-sm" onclick="window.print()">
        <i class="bi bi-printer me-1"></i> Cetak
    </button>
</div>

<div class="card mb-3">
    <div class="card-body">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-3">
                <select name="barang_id" class="form-select form-select-sm">
                    <option value="">-- Semua Barang --</option>
                    @foreach($barangs as $b)
                        <option value="{{ $b->id }}" {{ request('barang_id') == $b->id ? 'selected' : '' }}>{{ $b->nama_barang }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <input type="date" name="tanggal_dari" class="form-control form-control-sm" value="{{ request('tanggal_dari') }}">
            </div>
            <div class="col-md-3">
                <input type="date" name="tanggal_sampai" class="form-control form-control-sm" value="{{ request('tanggal_sampai') }}">
            </div>
            <div class="col-auto">
                <button class="btn btn-sm btn-primary"><i class="bi bi-filter"></i> Filter</button>
                <a href="{{ route('laporan.masuk') }}" class="btn btn-sm btn-outline-secondary ms-1">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-md-6">
        <div class="card text-center">
            <div class="card-body py-3">
                <h4 class="fw-bold mb-0 text-success">{{ number_format($totalJumlah) }}</h4>
                <small class="text-muted">Total Unit Masuk</small>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card text-center">
            <div class="card-body py-3">
                <h4 class="fw-bold mb-0">{{ $barangMasuks->count() }}</h4>
                <small class="text-muted">Total Transaksi</small>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr><th>#</th><th>Tanggal</th><th>Kode</th><th>Nama Barang</th><th>Jenis</th><th class="text-center">Jumlah Masuk</th><th>Keterangan</th></tr>
                </thead>
                <tbody>
                    @forelse($barangMasuks as $i => $item)
                    <tr>
                        <td class="text-muted">{{ $i + 1 }}</td>
                        <td>{{ $item->tanggal->format('d/m/Y') }}</td>
                        <td><span class="badge bg-light text-dark">{{ $item->barang->kode_barang }}</span></td>
                        <td class="fw-semibold">{{ $item->barang->nama_barang }}</td>
                        <td>{{ $item->barang->jenis }}</td>
                        <td class="text-center"><span class="badge bg-success rounded-pill px-3">+{{ $item->jumlah }}</span></td>
                        <td class="text-muted">{{ $item->keterangan ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">Tidak ada data</td></tr>
                    @endforelse
                </tbody>
                @if($barangMasuks->count())
                <tfoot class="table-light fw-bold">
                    <tr>
                        <td colspan="5" class="text-end">Total:</td>
                        <td class="text-center text-success">+{{ number_format($totalJumlah) }}</td>
                        <td></td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>
</div>

@endsection
