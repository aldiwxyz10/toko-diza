@extends('layouts.app')
@section('title', 'Detail Barang')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('barang.index') }}">Data Barang</a></li>
    <li class="breadcrumb-item active">Detail</li>
@endsection
@section('content')

<div class="row g-3">
    <div class="col-lg-5">
        <div class="card">
            <div class="card-header"><i class="bi bi-info-circle me-2"></i>Informasi Barang</div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tr><td class="text-muted" width="40%">Kode Barang</td><td><strong>{{ $barang->kode_barang }}</strong></td></tr>
                    <tr><td class="text-muted">Nama Barang</td><td><strong>{{ $barang->nama_barang }}</strong></td></tr>
                    <tr><td class="text-muted">Jenis</td><td>{{ $barang->jenis }}</td></tr>
                    <tr><td class="text-muted">Harga</td><td>Rp {{ number_format($barang->harga, 0, ',', '.') }}</td></tr>
                    <tr>
                        <td class="text-muted">Stok</td>
                        <td>
                            <span class="fw-bold fs-5">{{ $barang->stok }}</span>
                            <span class="badge bg-{{ $barang->status_badge }} ms-2">{{ ucfirst($barang->status_stok) }}</span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="card mb-3">
            <div class="card-header"><i class="bi bi-box-arrow-in-down text-success me-2"></i>5 Terakhir Masuk</div>
            <div class="card-body p-0">
                @forelse($barang->barangMasuks as $m)
                <div class="d-flex justify-content-between px-4 py-2 border-bottom">
                    <span class="text-muted">{{ $m->tanggal->format('d/m/Y') }}</span>
                    <span class="badge bg-success">+{{ $m->jumlah }}</span>
                </div>
                @empty
                <p class="text-center text-muted py-3 mb-0">Belum ada data</p>
                @endforelse
            </div>
        </div>
        <div class="card">
            <div class="card-header"><i class="bi bi-box-arrow-up text-danger me-2"></i>5 Terakhir Keluar</div>
            <div class="card-body p-0">
                @forelse($barang->barangKeluars as $k)
                <div class="d-flex justify-content-between px-4 py-2 border-bottom">
                    <span class="text-muted">{{ $k->tanggal->format('d/m/Y') }}</span>
                    <span class="badge bg-danger">-{{ $k->jumlah }}</span>
                </div>
                @empty
                <p class="text-center text-muted py-3 mb-0">Belum ada data</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection
