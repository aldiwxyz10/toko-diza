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
        <div class="px-6 py-4 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <h4 class="font-semibold text-slate-800 flex items-center">
                <i class="bi bi-pie-chart-fill text-blue-500 mr-2"></i> 
                <span>Analisis Visual Stok & Transaksi</span>
            </h4>
            
            <!-- Controls Group -->
            <div class="flex items-center">
                <!-- Dropdown Selector (Mobile Only) -->
                <div class="block sm:hidden w-full">
                    <select id="chartSelectorMobile" onchange="switchChart(this.value)" class="w-full text-xs font-medium border-slate-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 py-1.5 pl-3 pr-8">
                        <option value="stokBarang">📊 Stok per Barang</option>
                        <option value="masukTrend">📈 Tren Barang Masuk</option>
                        <option value="keluarTrend">📉 Tren Barang Keluar</option>
                        <option value="statusKetersediaan">🔔 Status Ketersediaan</option>
                    </select>
                </div>

                <!-- Segmented Control / Tabs (Desktop Only) -->
                <div class="hidden sm:flex items-center space-x-1 bg-slate-100 p-1 rounded-lg">
                    <button onclick="switchChart('stokBarang')" id="tab-stokBarang" class="chart-tab-btn px-3 py-1.5 text-xs font-medium rounded-md bg-white text-slate-800 shadow-sm transition-all duration-200">
                        📊 Stok/Barang
                    </button>
                    <button onclick="switchChart('masukTrend')" id="tab-masukTrend" class="chart-tab-btn px-3 py-1.5 text-xs font-medium rounded-md text-slate-600 hover:text-slate-800 transition-all duration-200">
                        📈 Barang Masuk
                    </button>
                    <button onclick="switchChart('keluarTrend')" id="tab-keluarTrend" class="chart-tab-btn px-3 py-1.5 text-xs font-medium rounded-md text-slate-600 hover:text-slate-800 transition-all duration-200">
                        📉 Barang Keluar
                    </button>
                    <button onclick="switchChart('statusKetersediaan')" id="tab-statusKetersediaan" class="chart-tab-btn px-3 py-1.5 text-xs font-medium rounded-md text-slate-600 hover:text-slate-800 transition-all duration-200">
                        🔔 Status Stok
                    </button>
                </div>
            </div>
        </div>

        <!-- Chart Container with dynamic height & smooth transitions -->
        <div class="p-6">
            <!-- 1. Stok per Barang (Bar Chart) -->
            <div id="container-stokBarang" class="chart-container opacity-100 transition-all duration-300 transform scale-100">
                <div class="w-full relative" style="height: 320px;">
                    <canvas id="stokChart"></canvas>
                </div>
            </div>

            <!-- 2. Tren Barang Masuk (Line Chart) -->
            <div id="container-masukTrend" class="chart-container hidden opacity-0 transition-all duration-300 transform scale-95">
                <div class="w-full relative" style="height: 320px;">
                    <canvas id="masukTrendChart"></canvas>
                </div>
            </div>

            <!-- 3. Tren Barang Keluar (Line Chart) -->
            <div id="container-keluarTrend" class="chart-container hidden opacity-0 transition-all duration-300 transform scale-95">
                <div class="w-full relative" style="height: 320px;">
                    <canvas id="keluarTrendChart"></canvas>
                </div>
            </div>

            <!-- 4. Status Ketersediaan (Pie Chart) -->
            <div id="container-statusKetersediaan" class="chart-container hidden opacity-0 transition-all duration-300 transform scale-95">
                <div class="w-full relative flex justify-center items-center" style="height: 300px;">
                    <canvas id="statusKetersediaanChart"></canvas>
                </div>
            </div>
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
            // Common styles and colors
            const paletteBg = [
                'rgba(99, 102, 241, 0.75)',  // Indigo
                'rgba(16, 185, 129, 0.75)',  // Emerald
                'rgba(245, 158, 11, 0.75)',  // Amber
                'rgba(239, 68, 68, 0.75)',   // Rose
                'rgba(6, 182, 212, 0.75)',   // Cyan
                'rgba(139, 92, 246, 0.75)',  // Violet
                'rgba(236, 72, 153, 0.75)'   // Pink
            ];
            const paletteBorder = [
                'rgb(99, 102, 241)',
                'rgb(16, 185, 129)',
                'rgb(245, 158, 11)',
                'rgb(239, 68, 68)',
                'rgb(6, 182, 212)',
                'rgb(139, 92, 246)',
                'rgb(236, 72, 153)'
            ];

            // 1. Chart: Stok per Barang
            const ctxStok = document.getElementById('stokChart').getContext('2d');
            const dataStokVal = {!! $chartData !!};
            const labelsStok = {!! $chartLabels !!};
            const bgStokColors = dataStokVal.map(val => val < 5 ? 'rgba(239, 68, 68, 0.75)' : 'rgba(59, 130, 246, 0.75)');
            const borderStokColors = dataStokVal.map(val => val < 5 ? 'rgb(239, 68, 68)' : 'rgb(59, 130, 246)');

            new Chart(ctxStok, {
                type: 'bar',
                data: {
                    labels: labelsStok,
                    datasets: [{
                        label: 'Jumlah Stok',
                        data: dataStokVal,
                        backgroundColor: bgStokColors,
                        borderColor: borderStokColors,
                        borderWidth: 1,
                        borderRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
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

            // 2. Chart: Tren Barang Masuk (Line Chart)
            const ctxMasuk = document.getElementById('masukTrendChart').getContext('2d');
            const labelsMasuk = {!! json_encode($masukLabels) !!};
            const dataMasukVal = {!! json_encode($masukData) !!};

            new Chart(ctxMasuk, {
                type: 'line',
                data: {
                    labels: labelsMasuk,
                    datasets: [{
                        label: 'Total Masuk',
                        data: dataMasukVal,
                        borderColor: 'rgb(99, 102, 241)', // Indigo
                        backgroundColor: 'rgba(99, 102, 241, 0.1)',
                        borderWidth: 2,
                        tension: 0.35,
                        fill: true,
                        pointBackgroundColor: 'rgb(99, 102, 241)',
                        pointRadius: 3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
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
                                    return ' Masuk: ' + context.parsed.y + ' Unit';
                                }
                            }
                        }
                    }
                }
            });

            // 3. Chart: Tren Barang Keluar (Line Chart)
            const ctxKeluar = document.getElementById('keluarTrendChart').getContext('2d');
            const labelsKeluar = {!! json_encode($keluarLabels) !!};
            const dataKeluarVal = {!! json_encode($keluarData) !!};

            new Chart(ctxKeluar, {
                type: 'line',
                data: {
                    labels: labelsKeluar,
                    datasets: [{
                        label: 'Total Keluar',
                        data: dataKeluarVal,
                        borderColor: 'rgb(244, 63, 94)', // Rose
                        backgroundColor: 'rgba(244, 63, 94, 0.1)',
                        borderWidth: 2,
                        tension: 0.35,
                        fill: true,
                        pointBackgroundColor: 'rgb(244, 63, 94)',
                        pointRadius: 3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
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
                                    return ' Keluar: ' + context.parsed.y + ' Unit';
                                }
                            }
                        }
                    }
                }
            });

            // 4. Chart: Status Ketersediaan Barang
            const ctxStatus = document.getElementById('statusKetersediaanChart').getContext('2d');
            const labelsStatus = {!! json_encode($statusKetersediaanLabels) !!};
            const dataStatusVal = {!! json_encode($statusKetersediaanData) !!};
            const semanticBg = [
                'rgba(16, 185, 129, 0.75)', // Tersedia (Emerald)
                'rgba(245, 158, 11, 0.75)', // Menipis (Amber)
                'rgba(239, 68, 68, 0.75)'   // Habis (Rose)
            ];
            const semanticBorder = [
                'rgb(16, 185, 129)',
                'rgb(245, 158, 11)',
                'rgb(239, 68, 68)'
            ];

            new Chart(ctxStatus, {
                type: 'pie',
                data: {
                    labels: labelsStatus,
                    datasets: [{
                        data: dataStatusVal,
                        backgroundColor: semanticBg,
                        borderColor: semanticBorder,
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                boxWidth: 6,
                                padding: 15
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return ' ' + context.label + ': ' + context.parsed + ' Item';
                                }
                            }
                        }
                    }
                }
            });
        });

        // Switch Chart Function
        window.switchChart = function(chartId) {
            // Sync Mobile Select Control
            const mobileSelect = document.getElementById('chartSelectorMobile');
            if (mobileSelect && mobileSelect.value !== chartId) {
                mobileSelect.value = chartId;
            }

            // Sync Desktop Segmented Control
            document.querySelectorAll('.chart-tab-btn').forEach(btn => {
                if (btn.id === 'tab-' + chartId) {
                    btn.classList.add('bg-white', 'text-slate-800', 'shadow-sm');
                    btn.classList.remove('text-slate-600', 'hover:text-slate-800');
                } else {
                    btn.classList.remove('bg-white', 'text-slate-800', 'shadow-sm');
                    btn.classList.add('text-slate-600', 'hover:text-slate-800');
                }
            });

            // Switch display with elegant micro-animations
            document.querySelectorAll('.chart-container').forEach(container => {
                container.classList.add('hidden', 'opacity-0', 'scale-95');
                container.classList.remove('opacity-100', 'scale-100');
            });

            const activeContainer = document.getElementById('container-' + chartId);
            if (activeContainer) {
                activeContainer.classList.remove('hidden');
                setTimeout(() => {
                    activeContainer.classList.remove('opacity-0', 'scale-95');
                    activeContainer.classList.add('opacity-100', 'scale-100');
                }, 20);
            }
        };
    </script>
    @endpush
</x-app-layout>
