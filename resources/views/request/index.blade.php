@extends('layouts.app')
@section('title', 'Request Stok')
@section('breadcrumb')
    <li class="breadcrumb-item active">Request Stok</li>
@endsection
@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold mb-0"><i class="bi bi-clipboard-check me-2 text-primary"></i>Request Stok</h4>
    @if(auth()->user()->isUser())
    <a href="{{ route('request.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i> Ajukan Request
    </a>
    @endif
</div>

<div class="card">
    <div class="card-body">
        <form method="GET" class="row g-2 mb-3">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control form-control-sm"
                       placeholder="Cari nama barang..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select form-select-sm">
                    <option value="">-- Semua Status --</option>
                    <option value="pending"   {{ request('status') == 'pending'   ? 'selected' : '' }}>Pending</option>
                    <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                    <option value="ditolak"   {{ request('status') == 'ditolak'   ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>
            <div class="col-auto">
                <button class="btn btn-sm btn-outline-primary"><i class="bi bi-search"></i> Filter</button>
                <a href="{{ route('request.index') }}" class="btn btn-sm btn-outline-secondary ms-1">Reset</a>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        @if(auth()->user()->isAdmin())<th>Pemohon</th>@endif
                        <th>Barang</th><th class="text-center">Jumlah</th>
                        <th>Catatan</th><th>Tanggal</th>
                        <th class="text-center">Status</th><th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($requests as $req)
                    <tr>
                        <td class="text-muted">{{ $requests->firstItem() + $loop->index }}</td>
                        @if(auth()->user()->isAdmin())
                        <td>
                            <div class="fw-semibold" style="font-size:.875rem;">{{ $req->user->name }}</div>
                            <small class="text-muted">{{ $req->user->email }}</small>
                        </td>
                        @endif
                        <td>
                            <div class="fw-semibold">{{ $req->barang->nama_barang }}</div>
                            <small class="text-muted">{{ $req->barang->kode_barang }}</small>
                        </td>
                        <td class="text-center fw-bold">{{ $req->jumlah }}</td>
                        <td class="text-muted" style="max-width:160px;">{{ Str::limit($req->catatan, 50) ?? '-' }}</td>
                        <td>{{ $req->created_at->format('d/m/Y') }}</td>
                        <td class="text-center">
                            <span class="badge rounded-pill bg-{{ $req->status_badge }} px-3">
                                {{ ucfirst($req->status) }}
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="d-flex gap-1 justify-content-center">
                                @if(auth()->user()->isAdmin() && $req->status === 'pending')
                                <form method="POST" action="{{ route('request.updateStatus', $req) }}">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="disetujui">
                                    <button class="btn btn-sm btn-success" title="Setujui"><i class="bi bi-check-lg"></i></button>
                                </form>
                                <form method="POST" action="{{ route('request.updateStatus', $req) }}"
                                      onsubmit="return confirm('Tolak request ini?')">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="ditolak">
                                    <button class="btn btn-sm btn-danger" title="Tolak"><i class="bi bi-x-lg"></i></button>
                                </form>
                                @endif
                                @if(auth()->user()->isUser() && $req->status === 'pending')
                                <form method="POST" action="{{ route('request.destroy', $req) }}"
                                      onsubmit="return confirm('Batalkan request?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ auth()->user()->isAdmin() ? 8 : 7 }}" class="text-center text-muted py-4">
                            <i class="bi bi-inbox fs-3"></i><p class="mb-0 mt-2">Belum ada request stok</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $requests->links() }}
    </div>
</div>

@endsection
