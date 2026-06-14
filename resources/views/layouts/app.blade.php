<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Inventory') }} - {{ $title ?? '' }}</title>

    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        /* Scrollbar styling */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="font-sans antialiased bg-slate-50 text-slate-800">
    <div class="min-h-screen flex">
        
        <!-- Sidebar -->
        <aside class="w-64 bg-slate-900 text-white flex-shrink-0 fixed inset-y-0 left-0 z-50 transform -translate-x-full md:translate-x-0 transition-transform duration-300 shadow-xl flex flex-col" id="sidebar">
            <div class="h-16 flex items-center px-6 border-b border-slate-800 flex-shrink-0">
                <x-application-logo class="w-6 h-6 text-blue-500 mr-3" />
                <span class="text-lg font-bold tracking-wide">Toko Diza</span>
            </div>
            
            <div class="p-4 flex-1 overflow-y-auto pb-20">
                <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2 mt-2 px-3">Menu Utama</p>
                
                @if(auth()->user()->isAdmin())
                    <x-nav-link href="{{ route('dashboard.admin') }}" :active="request()->routeIs('dashboard.admin')">
                        <i class="bi bi-speedometer2 text-lg"></i> Beranda
                    </x-nav-link>
                @else
                    <x-nav-link href="{{ route('dashboard.user') }}" :active="request()->routeIs('dashboard.user')">
                        <i class="bi bi-speedometer2 text-lg"></i> Beranda
                    </x-nav-link>
                @endif
                
                <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2 mt-6 px-3">Inventory</p>
                <x-nav-link href="{{ route('barang.index') }}" :active="request()->routeIs('barang.*')">
                    <i class="bi bi-box-seam text-lg"></i> Data Barang
                </x-nav-link>
                
                @if(auth()->user()->isAdmin())
                <x-nav-link href="{{ route('barang-masuk.index') }}" :active="request()->routeIs('barang-masuk.*')">
                    <i class="bi bi-box-arrow-in-down text-lg"></i> Data Barang Masuk
                </x-nav-link>
                <x-nav-link href="{{ route('barang-keluar.index') }}" :active="request()->routeIs('barang-keluar.*')">
                    <i class="bi bi-box-arrow-up text-lg"></i> Data Barang Keluar
                </x-nav-link>
                @else
                <x-nav-link href="{{ route('kasir.index') }}" :active="request()->routeIs('kasir.*')">
                    <i class="bi bi-calculator text-lg"></i> Kasir
                </x-nav-link>
                @endif
                
                <x-nav-link href="{{ route('request.index') }}" :active="request()->routeIs('request.*')">
                    <i class="bi bi-clipboard-check text-lg"></i> Permintaan Stok
                    @if(auth()->user()->isAdmin())
                        @php $pending = \App\Models\RequestStock::where('status','pending')->count() @endphp
                        @if($pending > 0)
                            <span class="ml-auto bg-red-500 text-white text-[10px] px-2 py-0.5 rounded-full font-bold">{{ $pending }}</span>
                        @endif
                    @endif
                </x-nav-link>
                
                @if(auth()->user()->isAdmin())
                <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2 mt-6 px-3">Laporan</p>
                <x-nav-link href="{{ route('laporan.index') }}" :active="request()->routeIs('laporan.index')">
                    <i class="bi bi-bar-chart-line text-lg"></i> Laporan
                </x-nav-link>
                
                <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2 mt-6 px-3">Sistem</p>
                <x-nav-link href="{{ route('user.index') }}" :active="request()->routeIs('user.*')">
                    <i class="bi bi-people text-lg"></i> Manajemen User
                </x-nav-link>
                @endif
            </div>
            
            <div class="absolute bottom-0 w-full border-t border-slate-800 p-4 bg-slate-900 shadow-[0_-10px_15px_-3px_rgba(0,0,0,0.3)]">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold shadow-inner flex-shrink-0">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-white truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-slate-400 truncate">{{ ucfirst(auth()->user()->role) }}</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Sidebar overlay for mobile -->
        <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-40 hidden md:hidden" id="sidebarOverlay" onclick="toggleSidebar()"></div>

        <!-- Main Content Wrapper -->
        <div class="flex-1 md:ml-64 flex flex-col min-h-screen transition-all duration-300 w-full">
            <!-- Topbar -->
            <header class="h-16 bg-white shadow-[0_1px_2px_0_rgba(0,0,0,0.05)] border-b border-slate-100 flex items-center justify-between px-4 sm:px-6 z-30 sticky top-0">
                <div class="flex items-center gap-4">
                    <button class="md:hidden text-slate-500 hover:text-slate-800 p-1" onclick="toggleSidebar()">
                        <i class="bi bi-list text-2xl"></i>
                    </button>
                    @if(isset($header))
                        <div class="font-semibold text-xl text-slate-800 leading-tight">
                            {{ $header }}
                        </div>
                    @elseif(isset($title))
                        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
                            {{ $title }}
                        </h2>
                    @endif
                </div>
                
                <div>
                    <a href="{{ route('logout') }}" class="text-sm font-semibold text-red-600 hover:text-red-800 hover:bg-red-50 px-3 py-2 rounded-lg transition-colors flex items-center gap-2">
                        <i class="bi bi-box-arrow-right text-lg"></i> Keluar
                    </a>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-4 sm:p-6 lg:p-8 flex-1 w-full max-w-7xl mx-auto">
                <!-- Validation Errors via SweetAlert -->
                @if($errors->any())
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            let errorHtml = '<ul class="text-left text-sm mt-2 text-red-600 list-disc list-inside">';
                            @foreach($errors->all() as $error)
                                errorHtml += '<li>{{ $error }}</li>';
                            @endforeach
                            errorHtml += '</ul>';
                            
                            Swal.fire({
                                icon: 'error',
                                title: 'Kesalahan Input!',
                                html: errorHtml,
                                confirmButtonColor: '#3b82f6',
                                customClass: { popup: 'rounded-2xl' }
                            });
                        });
                    </script>
                @endif

                {{ $slot }}
            </main>
        </div>
    </div>

    <!-- SweetAlert2 Trigger for Success/Error sessions -->
    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 2500,
                    toast: true,
                    position: 'top-end',
                    customClass: { popup: 'rounded-xl shadow-lg border border-slate-100' }
                });
            });
        </script>
    @endif
    @if(session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: '{{ session('error') }}',
                    showConfirmButton: false,
                    timer: 3000,
                    toast: true,
                    position: 'top-end',
                    customClass: { popup: 'rounded-xl shadow-lg border border-slate-100' }
                });
            });
        </script>
    @endif
    
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('-translate-x-full');
            document.getElementById('sidebarOverlay').classList.toggle('hidden');
        }
    </script>
    @stack('scripts')
</body>
</html>