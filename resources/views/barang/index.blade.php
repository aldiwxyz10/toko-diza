@extends('layouts.app')
@section('title', 'Data Barang')
@section('breadcrumb')
    <li class="breadcrumb-item active">Data Barang</li>
@endsection
@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold mb-0"><i class="bi bi-box-seam me-2 text-primary"></i>Data Barang</h4>
    @if(auth()->user()->isAdmin())
    <a href="{{ route('barang.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i> Tambah Barang
    </a>
    @endif
</div>

<div class="card">
    <div class="card-body">
        <form method="GET" class="row g-2 mb-3">
            <div class="col-md-5">
                <input type="text" name="search" class="form-control form-control-sm"
                       placeholder="Cari nama/kode barang..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="jenis" class="form-select form-select-sm">
                    <option value="">-- Semua Jenis --</option>
                    @foreach($jenis as $j)
                        <option value="{{ $j }}" {{ request('jenis') == $j ? 'selected' : '' }}>{{ $j }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-auto">
                <button class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-search"></i> Cari
                </button>
                <a href="{{ route('barang.index') }}" class="btn btn-sm btn-outline-secondary ms-1">Reset</a>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th><th>Kode</th><th>Nama Barang</th><th>Jenis</th>
                        <th class="text-center">Stok</th><th class="text-center">Status</th>
                        <th class="text-end">Harga</th><th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($barangs as $barang)
                    <tr>
                        <td class="text-muted">{{ $barangs->firstItem() + $loop->index }}</td>
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
                        <td class="text-center">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('barang.show', $barang) }}" class="btn btn-outline-info">
                                    <i class="bi bi-eye"></i>
                                </a>
                                @if(auth()->user()->isAdmin())
                                <a href="{{ route('barang.edit', $barang) }}" class="btn btn-outline-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="{{ route('barang.destroy', $barang) }}"
                                      onsubmit="return confirm('Hapus barang ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            <i class="bi bi-inbox fs-3"></i><p class="mb-0 mt-2">Tidak ada data barang</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $barangs->links() }}
    </div>
</div>

@endsection