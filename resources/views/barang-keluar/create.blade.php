@extends('layouts.app')
@section('title', 'Tambah Barang Keluar')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('barang-keluar.index') }}">Barang Keluar</a></li>
    <li class="breadcrumb-item active">Tambah</li>
@endsection
@section('content')

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-box-arrow-up me-2 text-danger"></i>Form Barang Keluar
                <small class="text-muted ms-1">— Stok otomatis berkurang</small>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('barang-keluar.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Pilih Barang <span class="text-danger">*</span></label>
                        <select name="barang_id" class="form-select @error('barang_id') is-invalid @enderror" id="barangSelect">
                            <option value="">-- Pilih Barang (yang ada stok) --</option>
                            @foreach($barangs as $barang)
                                <option value="{{ $barang->id }}" data-stok="{{ $barang->stok }}"
                                        {{ old('barang_id') == $barang->id ? 'selected' : '' }}>
                                    {{ $barang->kode_barang }} - {{ $barang->nama_barang }} (Stok: {{ $barang->stok }})
                                </option>
                            @endforeach
                        </select>
                        @error('barang_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div id="stokInfo" class="alert alert-warning d-none py-2 mb-3">
                        <i class="bi bi-exclamation-triangle me-1"></i> Stok tersedia: <strong id="stokSaatIni">-</strong>
                        <span class="text-danger ms-2" id="stokWarning"></span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Jumlah Keluar <span class="text-danger">*</span></label>
                        <input type="number" name="jumlah" id="jumlahInput"
                               class="form-control @error('jumlah') is-invalid @enderror"
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
                        <textarea name="keterangan" class="form-control" rows="2">{{ old('keterangan') }}</textarea>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-danger" id="submitBtn">
                            <i class="bi bi-check-circle me-1"></i> Simpan & Update Stok
                        </button>
                        <a href="{{ route('barang-keluar.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
let currentStok = 0;
document.getElementById('barangSelect').addEventListener('change', function () {
    currentStok = parseInt(this.options[this.selectedIndex].dataset.stok || 0);
    const info = document.getElementById('stokInfo');
    if (this.value !== '') {
        document.getElementById('stokSaatIni').textContent = currentStok;
        info.classList.remove('d-none');
        validateJumlah();
    } else {
        info.classList.add('d-none');
    }
});
document.getElementById('jumlahInput').addEventListener('input', validateJumlah);
function validateJumlah() {
    const jumlah = parseInt(document.getElementById('jumlahInput').value || 0);
    const warning = document.getElementById('stokWarning');
    const submitBtn = document.getElementById('submitBtn');
    if (jumlah > currentStok && currentStok > 0) {
        warning.textContent = '⚠ Jumlah melebihi stok!';
        submitBtn.disabled = true;
    } else {
        warning.textContent = '';
        submitBtn.disabled = false;
    }
}
</script>
@endpush
