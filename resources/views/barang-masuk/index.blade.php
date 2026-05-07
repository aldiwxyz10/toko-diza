@extends('layouts.app')
@section('title', 'Barang Masuk')
@section('breadcrumb')
    <li class="breadcrumb-item active">Barang Masuk</li>
@endsection
@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold mb-0"><i class="bi bi-box-arrow-in-down me-2 text-success"></i>Barang Masuk</h4>
    <a href="{{ route('barang-masuk.create') }}" class="btn btn-success">
        <i class="bi bi-plus-circle me-1"></i> Tambah
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form method="GET" class="row g-2 mb-3">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control form-control-sm"
                       placeholder="Cari barang..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <input type="date" name="tanggal_dari" class="form-control form-control-sm" value="{{ request('tanggal_dari') }}">
            </div>
            <div class="col-md-3">
                <input type="date" name="tanggal_sampai" class="form-control form-control-sm" value="{{ request('tanggal_sampai') }}">
            </div>
            <div class="col-auto">
                <button class="btn btn-sm btn-outline-primary"><i class="bi bi-search"></i> Filter</button>
                <a href="{{ route('barang-masuk.index') }}" class="btn btn-sm btn-outline-secondary ms-1">Reset</a>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th><th>Tanggal</th><th>Kode</th><th>Nama Barang</th>
                        <th class="text-center">Jumlah Masuk</th><th>Keterangan</th><th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($barangMasuks as $item)
                    <tr>
                        <td class="text-muted">{{ $barangMasuks->firstItem() + $loop->index }}</td>
                        <td>{{ $item->tanggal->format('d/m/Y') }}</td>
                        <td><span class="badge bg-light text-dark">{{ $item->barang->kode_barang }}</span></td>
                        <td class="fw-semibold">{{ $item->barang->nama_barang }}</td>
                        <td class="text-center"><span class="badge bg-success rounded-pill px-3">+{{ $item->jumlah }}</span></td>
                        <td class="text-muted">{{ $item->keterangan ?? '-' }}</td>
                        <td class="text-center">
                            <form method="POST" action="{{ route('barang-masuk.destroy', $item) }}"
                                  onsubmit="return confirm('Hapus data? Stok akan dikurangi kembali.')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            <i class="bi bi-inbox fs-3"></i><p class="mb-0 mt-2">Belum ada data</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $barangMasuks->links() }}
    </div>
</div>

@endsection
