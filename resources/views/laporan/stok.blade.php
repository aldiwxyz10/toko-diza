<x-app-layout>
    <x-slot name="title">Laporan Stok</x-slot>
    <x-slot name="header">Laporan Stok Barang</x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- Summary Cards -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 flex flex-col justify-center">
            <p class="text-sm font-medium text-slate-500 mb-1">Total Nilai Aset</p>
            <h3 class="text-3xl font-bold text-slate-800">Rp {{ number_format($totalNilai, 0, ',', '.') }}</h3>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 flex flex-col justify-center">
            <p class="text-sm font-medium text-slate-500 mb-1">Total Jenis Barang</p>
            <h3 class="text-3xl font-bold text-slate-800">{{ $jenis->count() }} <span class="text-sm font-normal text-slate-400">Kategori</span></h3>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-slate-500 mb-1">Ekspor Laporan</p>
                <button onclick="window.print()" class="mt-2 inline-flex items-center px-4 py-2 bg-slate-800 text-white rounded-lg hover:bg-slate-700 transition-colors text-sm font-medium">
                    <i class="bi bi-printer mr-2"></i> Cetak PDF
                </button>
            </div>
            <i class="bi bi-file-earmark-pdf text-4xl text-red-100"></i>
        </div>
    </div>

    <!-- Chart.js Section -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-slate-100">
            <h4 class="font-semibold text-slate-800"><i class="bi bi-bar-chart-fill text-blue-500 mr-2"></i> Grafik Stok Barang</h4>
        </div>
        <div class="p-6">
            <canvas id="stokChart" height="100"></canvas>
        </div>
    </div>

    <!-- Table Section -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between gap-4">
            <h3 class="text-lg font-semibold text-slate-800">Rincian Stok Barang</h3>
            <!-- Filter Form -->
            <form action="{{ route('laporan.stok') }}" method="GET" class="flex items-center gap-2">
                <select name="jenis" class="text-sm border-slate-200 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Semua Jenis</option>
                    @foreach($jenis as $j)
                        <option value="{{ $j }}" {{ request('jenis') == $j ? 'selected' : '' }}>{{ $j }}</option>
                    @endforeach
                </select>
                <button type="submit" class="px-3 py-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors">
                    <i class="bi bi-filter"></i> Filter
                </button>
            </form>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 text-slate-500 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Kode</th>
                        <th class="px-6 py-4 font-semibold">Nama Barang</th>
                        <th class="px-6 py-4 font-semibold">Jenis</th>
                        <th class="px-6 py-4 font-semibold">Stok Saat Ini</th>
                        <th class="px-6 py-4 font-semibold">Harga Satuan</th>
                        <th class="px-6 py-4 font-semibold text-right">Nilai Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($barangs as $barang)
                        <tr class="hover:bg-slate-50 transition-colors {{ $barang->stok == 0 ? 'bg-red-50' : '' }}">
                            <td class="px-6 py-4 font-mono text-xs text-slate-500">{{ $barang->kode_barang }}</td>
                            <td class="px-6 py-4 font-medium text-slate-800">{{ $barang->nama_barang }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $barang->jenis }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $barang->stok == 0 ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                    {{ $barang->stok }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-slate-600">Rp {{ number_format($barang->harga, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-right font-medium text-slate-800">Rp {{ number_format($barang->stok * $barang->harga, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-slate-500">Tidak ada data untuk filter yang dipilih.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('stokChart').getContext('2d');
            
            // Prepare the dynamic data passed from controller
            const labels = {!! $chartLabels !!};
            const data = {!! $chartData !!};
            
            // Background colors (generates an array of colors)
            const bgColors = data.map(val => val < 5 ? 'rgba(239, 68, 68, 0.7)' : 'rgba(59, 130, 246, 0.7)');
            const borderColors = data.map(val => val < 5 ? 'rgb(220, 38, 38)' : 'rgb(37, 99, 235)');

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Jumlah Stok',
                        data: data,
                        backgroundColor: bgColors,
                        borderColor: borderColors,
                        borderWidth: 1,
                        borderRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { precision: 0 }
                        }
                    },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return 'Stok: ' + context.parsed.y + ' Unit';
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
    @endpush
</x-app-layout>
