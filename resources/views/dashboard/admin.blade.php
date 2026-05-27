<x-app-layout>
    <x-slot name="title">Beranda Admin</x-slot>
    <x-slot name="header">Beranda Admin</x-slot>

    <!-- Spanduk Selamat Datang Premium -->
    <div class="relative bg-gradient-to-r from-blue-600 via-indigo-600 to-violet-700 rounded-2xl p-6 md:p-8 text-white mb-6 overflow-hidden shadow-md">
        <!-- Decorative background circles -->
        <div class="absolute -top-10 -right-10 w-40 h-40 rounded-full bg-white/10 blur-xl"></div>
        <div class="absolute -bottom-10 -left-10 w-40 h-40 rounded-full bg-white/10 blur-xl"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                @php
                    $jam = date('H');
                    if ($jam >= 5 && $jam < 11) {
                        $salam = 'Selamat Pagi';
                    } elseif ($jam >= 11 && $jam < 15) {
                        $salam = 'Selamat Siang';
                    } elseif ($jam >= 15 && $jam < 18) {
                        $salam = 'Selamat Sore';
                    } else {
                        $salam = 'Selamat Malam';
                    }
                @endphp
                <h2 class="text-2xl md:text-3xl font-bold tracking-tight mb-1">
                    {{ $salam }}, {{ auth()->user()->name }}! 👋
                </h2>
                <p class="text-blue-100/90 text-sm md:text-base leading-relaxed max-w-xl">
                    Selamat datang kembali di panel kontrol utama Toko Plastik Diza. Mari pantau stok barang dan kelola operasional hari ini secara efisien.
                </p>
            </div>
            <div class="flex items-center gap-2.5 bg-white/15 backdrop-blur-md px-4 py-2.5 rounded-xl border border-white/10 flex-shrink-0 self-start md:self-auto shadow-inner">
                <i class="bi bi-calendar3 text-xl text-blue-200"></i>
                <div class="text-left">
                    <p class="text-[10px] text-blue-200 font-semibold uppercase tracking-wider leading-none mb-0.5">Hari Ini</p>
                    @php
                        $hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                        $bulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                        $tglStr = $hari[date('w')] . ', ' . date('j') . ' ' . $bulan[date('n')] . ' ' . date('Y');
                    @endphp
                    <p class="text-xs font-bold leading-none">{{ $tglStr }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Panel Aksi Cepat -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <!-- Action 1: Tambah Barang -->
        <a href="{{ route('barang.create') }}" class="group bg-white p-4 rounded-xl border border-slate-100 shadow-sm hover:border-blue-500 hover:shadow-md transition-all flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-lg flex-shrink-0 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                <i class="bi bi-plus-lg"></i>
            </div>
            <div class="min-w-0">
                <p class="text-xs font-semibold text-slate-700 group-hover:text-blue-600 transition-colors truncate">Tambah Barang</p>
                <p class="text-[10px] text-slate-400 truncate">Master katalog</p>
            </div>
        </a>

        <!-- Action 2: Barang Masuk -->
        <a href="{{ route('barang-masuk.create') }}" class="group bg-white p-4 rounded-xl border border-slate-100 shadow-sm hover:border-green-500 hover:shadow-md transition-all flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-green-50 text-green-600 flex items-center justify-center text-lg flex-shrink-0 group-hover:bg-green-600 group-hover:text-white transition-colors">
                <i class="bi bi-box-arrow-in-down"></i>
            </div>
            <div class="min-w-0">
                <p class="text-xs font-semibold text-slate-700 group-hover:text-green-600 transition-colors truncate">Barang Masuk</p>
                <p class="text-[10px] text-slate-400 truncate">Catat stok masuk</p>
            </div>
        </a>

        <!-- Action 3: Barang Keluar -->
        <a href="{{ route('barang-keluar.create') }}" class="group bg-white p-4 rounded-xl border border-slate-100 shadow-sm hover:border-violet-500 hover:shadow-md transition-all flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-violet-50 text-violet-600 flex items-center justify-center text-lg flex-shrink-0 group-hover:bg-violet-600 group-hover:text-white transition-colors">
                <i class="bi bi-box-arrow-up"></i>
            </div>
            <div class="min-w-0">
                <p class="text-xs font-semibold text-slate-700 group-hover:text-violet-600 transition-colors truncate">Barang Keluar</p>
                <p class="text-[10px] text-slate-400 truncate">Catat pengeluaran</p>
            </div>
        </a>

        <!-- Action 4: Laporan Stok -->
        <a href="{{ route('laporan.stok') }}" class="group bg-white p-4 rounded-xl border border-slate-100 shadow-sm hover:border-amber-500 hover:shadow-md transition-all flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center text-lg flex-shrink-0 group-hover:bg-amber-600 group-hover:text-white transition-colors">
                <i class="bi bi-file-earmark-bar-graph"></i>
            </div>
            <div class="min-w-0">
                <p class="text-xs font-semibold text-slate-700 group-hover:text-amber-600 transition-colors truncate">Laporan Stok</p>
                <p class="text-[10px] text-slate-400 truncate">Cetak & ekspor data</p>
            </div>
        </a>
    </div>

    <!-- Grid Counter Utama -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <!-- Card: Total Barang -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 flex items-center gap-4 hover:shadow-md transition-shadow">
            <div class="w-12 h-12 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-2xl flex-shrink-0">
                <i class="bi bi-box"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500 mb-1">Total Barang</p>
                <h3 class="text-2xl font-bold text-slate-800">{{ number_format($totalBarang) }}</h3>
            </div>
        </div>

        <!-- Card: Total Stok -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 flex items-center gap-4 hover:shadow-md transition-shadow">
            <div class="w-12 h-12 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-2xl flex-shrink-0">
                <i class="bi bi-boxes"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500 mb-1">Total Stok Keseluruhan</p>
                <h3 class="text-2xl font-bold text-slate-800">{{ number_format($totalStok) }}</h3>
            </div>
        </div>

        <!-- Card: Barang Habis -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 flex items-center gap-4 hover:shadow-md transition-shadow">
            <div class="w-12 h-12 rounded-full bg-red-100 text-red-600 flex items-center justify-center text-2xl flex-shrink-0">
                <i class="bi bi-exclamation-triangle"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500 mb-1">Stok Habis</p>
                <h3 class="text-2xl font-bold text-slate-800">{{ number_format($barangHabis) }}</h3>
            </div>
        </div>

        <!-- Card: Request Pending -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 flex items-center gap-4 hover:shadow-md transition-shadow">
            <div class="w-12 h-12 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center text-2xl flex-shrink-0">
                <i class="bi bi-clipboard-check"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500 mb-1">Request Pending</p>
                <h3 class="text-2xl font-bold text-slate-800">{{ number_format($requestPending) }}</h3>
            </div>
        </div>
    </div>

    <!-- Layout Kolom Bawah Dashboard -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Kolom Kiri & Tengah: Grafik & Request Stok (lg:col-span-2) -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Card: Grafik Transaksi Bulan Ini -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden flex flex-col h-full">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <i class="bi bi-calendar-check text-blue-500"></i>
                        <h4 class="font-semibold text-slate-800">Aktivitas Transaksi Bulan Ini</h4>
                    </div>
                </div>
                <div class="p-6 flex-1 flex flex-col justify-between">
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div class="bg-green-50/50 border border-green-100 rounded-xl p-4 flex items-center justify-between shadow-sm">
                            <div>
                                <p class="text-[11px] font-bold text-green-700 uppercase tracking-wider mb-1">Barang Masuk</p>
                                <h4 class="text-2xl font-black text-green-600">{{ number_format($masukBulanIni) }} <span class="text-xs font-medium text-green-500">unit</span></h4>
                            </div>
                            <div class="w-9 h-9 rounded-full bg-green-500 text-white flex items-center justify-center shadow-sm">
                                <i class="bi bi-arrow-down-left"></i>
                            </div>
                        </div>
                        <div class="bg-blue-50/50 border border-blue-100 rounded-xl p-4 flex items-center justify-between shadow-sm">
                            <div>
                                <p class="text-[11px] font-bold text-blue-700 uppercase tracking-wider mb-1">Barang Keluar</p>
                                <h4 class="text-2xl font-black text-blue-600">{{ number_format($keluarBulanIni) }} <span class="text-xs font-medium text-blue-500">unit</span></h4>
                            </div>
                            <div class="w-9 h-9 rounded-full bg-blue-500 text-white flex items-center justify-center shadow-sm">
                                <i class="bi bi-arrow-up-right"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Canvas Chart -->
                    <div class="relative w-full h-[180px] mt-2 flex items-center justify-center">
                        @if($masukBulanIni > 0 || $keluarBulanIni > 0)
                            <canvas id="transaksiChart" class="max-w-full h-full"></canvas>
                        @else
                            <div class="text-center py-6 text-slate-400">
                                <i class="bi bi-bar-chart text-3xl mb-2 block text-slate-300"></i>
                                <p class="text-xs">Belum ada transaksi bulan ini.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Card: Request Stok Terbaru -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden flex flex-col">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <i class="bi bi-clipboard-check text-amber-500"></i>
                        <h4 class="font-semibold text-slate-800">Permintaan Stok Terbaru</h4>
                    </div>
                    <a href="{{ route('request.index') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-800 hover:underline flex items-center gap-1">
                        Lihat Semua <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
                <div class="p-0 overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-slate-50 text-slate-500 text-2xs tracking-wider uppercase">
                            <tr>
                                <th class="px-6 py-3 font-semibold">Kasir</th>
                                <th class="px-6 py-3 font-semibold">Barang</th>
                                <th class="px-6 py-3 font-semibold text-center">Jumlah</th>
                                <th class="px-6 py-3 font-semibold text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($requestTerbaru as $req)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-6 py-3.5">
                                        <p class="font-semibold text-slate-800 leading-none mb-1">{{ $req->user->name }}</p>
                                        <span class="text-[10px] text-slate-400 flex items-center gap-1">
                                            <i class="bi bi-clock"></i> {{ $req->created_at->diffForHumans() }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-3.5 text-slate-700 font-medium">
                                        {{ $req->barang->nama_barang }}
                                    </td>
                                    <td class="px-6 py-3.5 text-center text-slate-600 font-bold">
                                        {{ $req->jumlah }} <span class="text-2xs font-normal text-slate-400">pcs</span>
                                    </td>
                                    <td class="px-6 py-3.5 text-center">
                                        @if($req->status === 'pending')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-2xs font-semibold bg-amber-50 text-amber-700 border border-amber-100 shadow-sm animate-pulse">
                                                Pending
                                            </span>
                                        @elseif($req->status === 'disetujui')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-2xs font-semibold bg-green-50 text-green-700 border border-green-100 shadow-sm">
                                                Disetujui
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-2xs font-semibold bg-red-50 text-red-700 border border-red-100 shadow-sm">
                                                Ditolak
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-slate-500">
                                        <div class="flex flex-col items-center">
                                            <i class="bi bi-inbox text-3xl text-slate-300 mb-2"></i>
                                            <p class="text-xs">Belum ada request masuk.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Stok Kritis (lg:col-span-1) -->
        <div class="lg:col-span-1">
            <!-- Card: Stok Kritis -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden flex flex-col h-full">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <i class="bi bi-exclamation-circle text-red-500"></i>
                        <h4 class="font-semibold text-slate-800">Stok Kritis (≤ 5)</h4>
                    </div>
                    <span class="px-2 py-0.5 rounded-full bg-red-50 text-red-700 font-bold text-[10px] border border-red-100 shadow-sm">Re-stock</span>
                </div>
                <div class="p-0 overflow-x-auto flex-1">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-slate-50 text-slate-500 text-2xs tracking-wider uppercase">
                            <tr>
                                <th class="px-6 py-3 font-semibold">Nama Barang</th>
                                <th class="px-6 py-3 font-semibold text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($barangKritis as $barang)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-6 py-3.5">
                                        <p class="font-medium text-slate-800 leading-tight mb-1">{{ $barang->nama_barang }}</p>
                                        <span class="font-mono text-[9px] text-slate-400 bg-slate-100 px-1.5 py-0.5 rounded">{{ $barang->kode_barang }}</span>
                                    </td>
                                    <td class="px-6 py-3.5 text-center">
                                        @if($barang->stok === 0)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-red-100 text-red-800 border border-red-200">
                                                HABIS (0)
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800 border border-amber-200">
                                                SISA {{ $barang->stok }}
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="px-6 py-12 text-center text-slate-500">
                                        <div class="flex flex-col items-center">
                                            <i class="bi bi-check-circle text-3xl text-green-400 mb-2"></i>
                                            <p class="text-xs">Semua stok barang aman.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        @if($masukBulanIni > 0 || $keluarBulanIni > 0)
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const ctx = document.getElementById('transaksiChart').getContext('2d');
                    
                    // Create beautiful gradients
                    const greenGrad = ctx.createLinearGradient(0, 0, 0, 180);
                    greenGrad.addColorStop(0, '#10b981');
                    greenGrad.addColorStop(1, '#059669');

                    const blueGrad = ctx.createLinearGradient(0, 0, 0, 180);
                    blueGrad.addColorStop(0, '#3b82f6');
                    blueGrad.addColorStop(1, '#2563eb');

                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: ['Barang Masuk', 'Barang Keluar'],
                            datasets: [{
                                label: 'Volume Transaksi (Unit)',
                                data: [{{ $masukBulanIni }}, {{ $keluarBulanIni }}],
                                backgroundColor: [greenGrad, blueGrad],
                                borderRadius: 10,
                                barPercentage: 0.5,
                                borderSkipped: false
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    backgroundColor: '#1e293b',
                                    titleFont: { family: 'Inter', size: 12, weight: 'bold' },
                                    bodyFont: { family: 'Inter', size: 12 },
                                    padding: 10,
                                    cornerRadius: 8,
                                    displayColors: false
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    grid: {
                                        color: '#f1f5f9',
                                    },
                                    ticks: {
                                        font: { family: 'Inter', size: 10, weight: 500 },
                                        color: '#64748b'
                                    }
                                },
                                x: {
                                    grid: {
                                        display: false
                                    },
                                    ticks: {
                                        font: { family: 'Inter', size: 11, weight: 600 },
                                        color: '#475569'
                                    }
                                }
                            }
                        }
                    });
                });
            </script>
        @endif
    @endpush
</x-app-layout>
