<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'Inventory Toko Plastik'))</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        :root { --sidebar-width: 250px; --sidebar-bg: #1a2332; --sidebar-hover: #243447; }
        body { background-color: #f0f2f5; font-family: 'Segoe UI', system-ui, sans-serif; }
        
        #sidebar { width: var(--sidebar-width); min-height: 100vh; background: var(--sidebar-bg);
                   position: fixed; top: 0; left: 0; z-index: 1000; overflow-y: auto; transition: transform 0.3s ease; }
        #sidebar .brand { padding: 1.25rem 1.5rem; border-bottom: 1px solid rgba(255,255,255,.1); }
        #sidebar .brand h5 { color: #fff; font-weight: 700; margin: 0; font-size: .95rem; }
        #sidebar .brand small { color: rgba(255,255,255,.5); font-size: .75rem; }
        #sidebar .nav-link { color: rgba(255,255,255,.75); padding: .6rem 1.5rem; font-size: .875rem;
                             display: flex; align-items: center; gap: .6rem; transition: all .2s; }
        #sidebar .nav-link:hover, #sidebar .nav-link.active { color: #fff; background: var(--sidebar-hover);
                                                              border-left: 3px solid #0d6efd; }
        #sidebar .nav-section { padding: .75rem 1.5rem .25rem; font-size: .7rem; font-weight: 600;
                                color: rgba(255,255,255,.35); text-transform: uppercase; letter-spacing: .08em; }
        
        #main-content { margin-left: var(--sidebar-width); min-height: 100vh; transition: margin-left 0.3s ease; }
        .topbar { background: #fff; border-bottom: 1px solid #e9ecef; padding: .75rem 1.5rem;
                  position: sticky; top: 0; z-index: 999; }
        .page-content { padding: 1.5rem; }
        
        .stat-card, .card { border: none; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,.06); }
        .card-header { background: transparent; border-bottom: 1px solid #f0f2f5;
                       padding: 1rem 1.25rem; font-weight: 600; }
        .table th { font-weight: 600; font-size: .8rem; text-transform: uppercase;
                    letter-spacing: .04em; color: #6c757d; }
        
        @media (max-width: 768px) {
            #sidebar { transform: translateX(-100%); }
            #sidebar.show { transform: translateX(0); }
            #main-content { margin-left: 0; }
        }
    </style>
    @stack('styles')
</head>
<body>

<nav id="sidebar">
    <div class="brand">
        <h5><i class="bi bi-box-seam-fill text-primary me-2"></i>Toko Plastik</h5>
        <small>Inventory System</small>
    </div>
    <ul class="nav flex-column mt-2">
        <li class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
        </li>
        <li class="mt-2"><span class="nav-section">Inventory</span></li>
        <li class="nav-item">
            <a href="{{ route('barang.index') }}" class="nav-link {{ request()->routeIs('barang.*') ? 'active' : '' }}">
                <i class="bi bi-box-seam"></i> Data Barang
            </a>
        </li>
        
        @if(auth()->user()->role === 'admin')
        <li class="nav-item">
            <a href="{{ route('barang-masuk.index') }}" class="nav-link {{ request()->routeIs('barang-masuk.*') ? 'active' : '' }}">
                <i class="bi bi-box-arrow-in-down"></i> Barang Masuk
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('barang-keluar.index') }}" class="nav-link {{ request()->routeIs('barang-keluar.*') ? 'active' : '' }}">
                <i class="bi bi-box-arrow-up"></i> Barang Keluar
            </a>
        </li>
        @endif

        <li class="nav-item">
            <a href="{{ route('request.index') }}" class="nav-link {{ request()->routeIs('request.*') ? 'active' : '' }}">
                <i class="bi bi-clipboard-check"></i> Request Stock
                @if(auth()->user()->role === 'admin')
                    @php 
                        $pending = class_exists('\App\Models\RequestStock') ? \App\Models\RequestStock::where('status','pending')->count() : 0; 
                    @endphp
                    @if($pending > 0)<span class="badge bg-danger ms-auto">{{ $pending }}</span>@endif
                @endif
            </a>
        </li>
        
        @if(auth()->user()->role === 'admin')
        <li class="mt-2"><span class="nav-section">Laporan</span></li>
        <li class="nav-item">
            <a href="{{ route('laporan.stok') }}" class="nav-link {{ request()->routeIs('laporan.stok') ? 'active' : '' }}">
                <i class="bi bi-bar-chart-line"></i> Laporan Stok
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('laporan.masuk') }}" class="nav-link {{ request()->routeIs('laporan.masuk') ? 'active' : '' }}">
                <i class="bi bi-graph-up-arrow"></i> Laporan Masuk
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('laporan.keluar') }}" class="nav-link {{ request()->routeIs('laporan.keluar') ? 'active' : '' }}">
                <i class="bi bi-graph-down-arrow"></i> Laporan Keluar
            </a>
        </li>
        <li class="mt-2"><span class="nav-section">Manajemen</span></li>
        <li class="nav-item">
            <a href="{{ route('user.index') }}" class="nav-link {{ request()->routeIs('user.*') ? 'active' : '' }}">
                <i class="bi bi-people"></i> Manajemen User
            </a>
        </li>
        @endif
    </ul>
    
    <div class="p-3 border-top border-secondary mt-3">
        <div class="d-flex align-items-center gap-2">
            <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center text-white"
                 style="width:32px;height:32px;font-size:.8rem;flex-shrink:0;">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div>
                <div class="text-white text-truncate" style="font-size:.8rem;font-weight:600;">{{ auth()->user()->name }}</div>
                <div class="text-secondary" style="font-size:.7rem;">{{ ucfirst(auth()->user()->role) }}</div>
            </div>
        </div>
    </div>
</nav>

<div id="main-content">
    <div class="topbar d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-2">
            <button class="btn btn-sm btn-outline-secondary d-md-none" id="sidebarToggle">
                <i class="bi bi-list"></i>
            </button>
            <nav aria-label="breadcrumb" class="mb-0">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item text-muted">Aplikasi</li>
                    <li class="breadcrumb-item active fw-bold">@yield('title', 'Dashboard')</li>
                </ol>
            </nav>
        </div>
        
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-danger">
                <i class="bi bi-box-arrow-right"></i> Logout
            </button>
        </form>
    </div>

    <div class="page-content">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{ $slot ?? '' }}
        @yield('content')
        
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Script Sidebar untuk HP
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('sidebarToggle');

    toggleBtn?.addEventListener('click', function (e) {
        e.stopPropagation();
        sidebar.classList.toggle('show');
    });

    document.addEventListener('click', function (e) {
        if (!sidebar.contains(e.target) && window.innerWidth <= 768) {
            sidebar.classList.remove('show');
        }
    });
</script>
@stack('scripts')
</body>
</html>