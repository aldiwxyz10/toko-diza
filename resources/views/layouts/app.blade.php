<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Toko Plastik Diza')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            position: sticky;
            top: 20px;
        }
        .main-content {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">
            🏪 Toko Plastik Diza
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <span class="navbar-text text-light ms-auto me-4">
                <strong>ADMIN PANEL</strong> - Sistem Pengelolaan Stok
            </span>
            <a href="{{ route('pelanggan.katalog') }}" class="btn btn-outline-light btn-sm me-2" target="_blank">
                👥 Lihat Katalog Pelanggan
            </a>
            @auth
                <div class="dropdown">
                    <button class="btn btn-outline-light dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown">
                        👤 {{ auth()->user()->name }} ({{ ucfirst(auth()->user()->role) }})
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li><span class="dropdown-header">{{ auth()->user()->email }}</span></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="dropdown-item">🚪 Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            @endauth
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-lg-2 mb-4">
            <div class="list-group sidebar">
                <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action {{ request()->is('/') ? 'active bg-primary' : '' }}">
                    📊 Dashboard
                </a>
                <a href="{{ route('barang.index') }}" class="list-group-item list-group-item-action {{ request()->is('barang*') ? 'active bg-primary' : '' }}">
                    📦 Data Barang
                </a>
                <a href="{{ route('stok-masuk.index') }}" class="list-group-item list-group-item-action {{ request()->is('stok-masuk*') ? 'active bg-primary' : '' }}">
                    📥 Stok Masuk
                </a>
                <a href="{{ route('stok-keluar.index') }}" class="list-group-item list-group-item-action {{ request()->is('stok-keluar*') ? 'active bg-primary' : '' }}">
                    📤 Stok Keluar
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-lg-10">
            <div class="main-content">
                @yield('content')
            </div>
        </div>
    </div>
</div>

<footer class="mt-5 py-3 bg-light text-center border-top">
    <p class="text-muted mb-0">&copy; 2024 Toko Plastik Diza - Sistem Pengelolaan Stok</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>