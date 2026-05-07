@extends('layouts.app')
@section('title', 'Manajemen User')
@section('breadcrumb')
    <li class="breadcrumb-item active">Manajemen User</li>
@endsection
@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold mb-0"><i class="bi bi-people me-2 text-primary"></i>Manajemen User</h4>
    <a href="{{ route('user.create') }}" class="btn btn-primary">
        <i class="bi bi-person-plus me-1"></i> Tambah User
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form method="GET" class="row g-2 mb-3">
            <div class="col-md-5">
                <input type="text" name="search" class="form-control form-control-sm"
                       placeholder="Cari nama atau email..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <select name="role" class="form-select form-select-sm">
                    <option value="">-- Semua Role --</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="user"  {{ request('role') == 'user'  ? 'selected' : '' }}>User</option>
                </select>
            </div>
            <div class="col-auto">
                <button class="btn btn-sm btn-outline-primary"><i class="bi bi-search"></i> Cari</button>
                <a href="{{ route('user.index') }}" class="btn btn-sm btn-outline-secondary ms-1">Reset</a>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr><th>#</th><th>Nama</th><th>Email</th><th class="text-center">Role</th><th>Dibuat</th><th class="text-center">Aksi</th></tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td class="text-muted">{{ $users->firstItem() + $loop->index }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center text-white"
                                     style="width:32px;height:32px;font-size:.75rem;flex-shrink:0;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <span class="fw-semibold">{{ $user->name }}</span>
                                @if($user->id === auth()->id())
                                <span class="badge bg-secondary" style="font-size:.7rem;">Anda</span>
                                @endif
                            </div>
                        </td>
                        <td class="text-muted">{{ $user->email }}</td>
                        <td class="text-center">
                            <span class="badge rounded-pill {{ $user->isAdmin() ? 'bg-primary' : 'bg-info text-dark' }} px-3">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="text-muted">{{ $user->created_at->format('d/m/Y') }}</td>
                        <td class="text-center">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('user.edit', $user) }}" class="btn btn-outline-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                @if($user->id !== auth()->id())
                                <form method="POST" action="{{ route('user.destroy', $user) }}"
                                      onsubmit="return confirm('Hapus user ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            <i class="bi bi-people fs-3"></i><p class="mb-0 mt-2">Tidak ada data user</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $users->links() }}
    </div>
</div>

@endsection
