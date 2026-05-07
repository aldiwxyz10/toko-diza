@extends('layouts.app')
@section('title', 'Tambah Barang')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('barang.index') }}">Data Barang</a></li>
    <li class="breadcrumb-item active">Tambah</li>
@endsection
@section('content')

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header"><i class="bi bi-plus-circle me-2 text-primary"></i>Tambah Barang Baru</div>
            <div class="card-body">
                <form method="POST" action="{{ route('barang.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kode Barang <span class="text-danger">*</span></label>
                        <input type="text" name="kode_barang" class="form-control @error('kode_barang') is-invalid @enderror"
                               value="{{ old('kode_barang') }}" placeholder="Contoh: BRG-001">
                        @error('kode_barang')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Barang <span class="text-danger">*</span></label>
                        <input type="text" name="nama_barang" class="form-control @error('nama_barang') is-invalid @enderror"
                               value="{{ old('nama_barang') }}">
                        @error('nama_barang')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Jenis <span class="text-danger">*</span></label>
                        <input type="text" name="jenis" class="form-control @error('jenis') is-invalid @enderror"
                               value="{{ old('jenis') }}">
                        @error('jenis')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Stok Awal <span class="text-danger">*</span></label>
                            <input type="number" name="stok" class="form-control @error('stok') is-invalid @enderror"
                                   value="{{ old('stok', 0) }}" min="0">
                            @error('stok')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Harga (Rp) <span class="text-danger">*</span></label>
                            <input type="number" name="harga" class="form-control @error('harga') is-invalid @enderror"
                                   value="{{ old('harga', 0) }}" min="0">
                            @error('harga')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-1"></i> Simpan
                        </button>
                        <a href="{{ route('barang.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection