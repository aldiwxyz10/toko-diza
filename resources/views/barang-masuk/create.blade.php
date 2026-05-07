@extends('layouts.app')
@section('title', 'Tambah Barang Masuk')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('barang-masuk.index') }}">Barang Masuk</a></li>
    <li class="breadcrumb-item active">Tambah</li>
@endsection
@section('content')

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-box-arrow-in-down me-2 text-success"></i>Form Barang Masuk
                <small class="text-muted ms-1">— Stok otomatis bertambah</small>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('barang-masuk.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Pilih Barang <span class="text-danger">*</span></label>
                        <select name="barang_id" class="form-select @error('barang_id') is-invalid @enderror" id="barangSelect">
                            <option value="">-- Pilih Barang --</option>
                            @foreach($barangs as $barang)
                                <option value="{{ $barang->id }}" data-stok="{{ $barang->stok }}"
                                        {{ old('barang_id') == $barang->id ? 'selected' : '' }}>
                                    {{ $barang->kode_barang }} - {{ $barang->nama_barang }} (Stok: {{ $barang->stok }})
                                </option>
                            @endforeach
                        </select>
                        @error('barang_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div id="stokInfo" class="alert alert-info d-none py-2 mb-3">
                        <i class="bi bi-info-circle me-1"></i> Stok saat ini: <strong id="stokSaatIni">-</strong>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Jumlah Masuk <span class="text-danger">*</span></label>
                        <input type="number" name="jumlah" class="form-control @error('jumlah') is-invalid @enderror"
                               value="{{ old('jumlah', 1) }}" min="1">
                        @error('jumlah')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tanggal <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror"
                               value="{{ old('tanggal', date('Y-m-d')) }}">
                        @error('tanggal')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="2" placeholder="Opsional">{{ old('keterangan') }}</textarea>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle me-1"></i> Simpan & Update Stok
                        </button>
                        <a href="{{ route('barang-masuk.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.getElementById('barangSelect').addEventListener('change', function () {
    const stok = this.options[this.selectedIndex].dataset.stok;
    const info = document.getElementById('stokInfo');
    if (this.value !== '') {
        document.getElementById('stokSaatIni').textContent = stok;
        info.classList.remove('d-none');
    } else {
        info.classList.add('d-none');
    }
});
</script>
@endpush
