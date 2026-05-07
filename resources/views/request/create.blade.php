@extends('layouts.app')
@section('title', 'Ajukan Request Stok')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('request.index') }}">Request Stok</a></li>
    <li class="breadcrumb-item active">Ajukan</li>
@endsection
@section('content')

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header"><i class="bi bi-clipboard-plus me-2 text-primary"></i>Form Pengajuan Request Stok</div>
            <div class="card-body">
                <form method="POST" action="{{ route('request.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Pilih Barang <span class="text-danger">*</span></label>
                        <select name="barang_id" class="form-select @error('barang_id') is-invalid @enderror" id="barangSelect">
                            <option value="">-- Pilih Barang --</option>
                            @foreach($barangs as $barang)
                                <option value="{{ $barang->id }}" data-stok="{{ $barang->stok }}"
                                        data-status="{{ $barang->status_stok }}"
                                        {{ old('barang_id') == $barang->id ? 'selected' : '' }}>
                                    {{ $barang->kode_barang }} - {{ $barang->nama_barang }} (Stok: {{ $barang->stok }})
                                </option>
                            @endforeach
                        </select>
                        @error('barang_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div id="barangInfo" class="alert d-none py-2 mb-3">
                        <i class="bi bi-info-circle me-1"></i>
                        Stok saat ini: <strong id="stokSaatIni">-</strong>
                        | Status: <span id="statusStok" class="badge rounded-pill"></span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Jumlah Diminta <span class="text-danger">*</span></label>
                        <input type="number" name="jumlah" class="form-control @error('jumlah') is-invalid @enderror"
                               value="{{ old('jumlah', 1) }}" min="1">
                        @error('jumlah')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Alasan / Catatan</label>
                        <textarea name="catatan" class="form-control @error('catatan') is-invalid @enderror"
                                  rows="3" placeholder="Jelaskan alasan request stok ini...">{{ old('catatan') }}</textarea>
                        @error('catatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-send me-1"></i> Ajukan Request
                        </button>
                        <a href="{{ route('request.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
const statusColors = { habis: 'danger', menipis: 'warning', tersedia: 'success' };
document.getElementById('barangSelect').addEventListener('change', function () {
    const opt    = this.options[this.selectedIndex];
    const stok   = opt.dataset.stok;
    const status = opt.dataset.status;
    const info   = document.getElementById('barangInfo');
    if (this.value !== '') {
        document.getElementById('stokSaatIni').textContent = stok;
        const el = document.getElementById('statusStok');
        el.textContent = status.charAt(0).toUpperCase() + status.slice(1);
        el.className = `badge rounded-pill bg-${statusColors[status] || 'secondary'}`;
        info.className = `alert alert-${statusColors[status] === 'success' ? 'info' : statusColors[status]} py-2 mb-3`;
        info.classList.remove('d-none');
    } else {
        info.classList.add('d-none');
    }
});
</script>
@endpush
