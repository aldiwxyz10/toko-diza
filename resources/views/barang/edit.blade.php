@extends('layouts.app')
@section('title', 'Edit Barang')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('barang.index') }}">Data Barang</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection
@section('content')

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header"><i class="bi bi-pencil me-2 text-warning"></i>Edit: {{ $barang->nama_barang }}</div>
            <div class="card-body">
                <form method="POST" action="{{ route('barang.update', $barang) }}">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kode Barang</label>
                        <input type="text" name="kode_barang" class="form-control @error('kode_barang') is-invalid @enderror"
                               value="{{ old('kode_barang', $barang->kode_barang) }}">
                        @error('kode_barang')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Barang</label>
                        <input type="text" name="nama_barang" class="form-control @error('nama_barang') is-invalid @enderror"
                               value="{{ old('nama_barang', $barang->nama_barang) }}">
                        @error('nama_barang')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Jenis</label>
                        <input type="text" name="jenis" class="form-control @error('jenis') is-invalid @enderror"
                               value="{{ old('jenis', $barang->jenis) }}">
                        @error('jenis')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Stok</label>
                            <input type="number" name="stok" class="form-control" value="{{ old('stok', $barang->stok) }}" min="0">
                            <small class="text-muted">Gunakan Barang Masuk/Keluar untuk pencatatan riwayat.</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Harga (Rp)</label>
                            <input type="number" name="harga" class="form-control" value="{{ old('harga', $barang->harga) }}" min="0">
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-check-circle me-1"></i> Update
                        </button>
                        <a href="{{ route('barang.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection