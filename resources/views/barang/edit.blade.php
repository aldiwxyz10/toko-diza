@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h2>Edit Barang</h2>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('barang.update', $barang->id_barang) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Nama Barang -->
            <div class="mb-3">
                <label for="nama_barang" class="form-label">Nama Barang <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('nama_barang') is-invalid @enderror" 
                       id="nama_barang" name="nama_barang" value="{{ old('nama_barang', $barang->nama_barang) }}" required>
                @error('nama_barang')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Kategori -->
            <div class="mb-3">
                <label for="id_kategori" class="form-label">Kategori <span class="text-danger">*</span></label>
                <select class="form-select @error('id_kategori') is-invalid @enderror" 
                        id="id_kategori" name="id_kategori" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($kategoris as $kategori)
                        <option value="{{ $kategori->id_kategori }}" 
                                @selected(old('id_kategori', $barang->id_kategori) == $kategori->id_kategori)>
                            {{ $kategori->nama_kategori }}
                        </option>
                    @endforeach
                </select>
                @error('id_kategori')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Harga -->
            <div class="mb-3">
                <label for="harga" class="form-label">Harga <span class="text-danger">*</span></label>
                <input type="number" step="0.01" class="form-control @error('harga') is-invalid @enderror" 
                       id="harga" name="harga" value="{{ old('harga', $barang->harga) }}" required>
                @error('harga')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Stok -->
            <div class="mb-3">
                <label for="stok" class="form-label">Stok <span class="text-danger">*</span></label>
                <input type="number" class="form-control @error('stok') is-invalid @enderror" 
                       id="stok" name="stok" value="{{ old('stok', $barang->stok) }}" required>
                @error('stok')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Perbarui</button>
                <a href="{{ route('barang.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
