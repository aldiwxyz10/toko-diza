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
        <span class="navbar-text text-light ms-auto">
            Sistem Pengelolaan Stok Barang
        </span>
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