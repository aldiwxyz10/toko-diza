<x-app-layout>
    <x-slot name="title">Pusat Laporan</x-slot>
    <x-slot name="header">Pusat Laporan & Analisis Data</x-slot>

    <!-- Style kustom untuk media cetak (Print Layout) -->
    <style>
        @media print {
            /* Sembunyikan sidebar, topbar, navigasi tab, formulir filter, tombol, dan spanduk */
            aside, header, #sidebarOverlay, .no-print, form, .tab-nav-container, .alert-box {
                display: none !important;
            }
            /* Hilangkan margin/padding pembungkus utama */
            body {
                background: #ffffff !important;
                color: #000000 !important;
                font-size: 12px !important;
            }
            main {
                padding: 0 !important;
                margin: 0 !important;
                max-width: 100% !important;
            }
            .max-w-7xl {
                max-width: 100% !important;
                width: 100% !important;
                padding: 0 !important;
                margin: 0 !important;
            }
            .shadow-sm, .border, .rounded-xl {
                border: none !important;
                box-shadow: none !important;
                border-radius: 0 !important;
            }
            /* Kontrol visibilitas Tab saat print */
            .tab-content-pane {
                display: none !important;
            }
            .tab-content-pane.active-print {
                display: block !important;
            }
            /* Desain cetak tabel agar rapi */
            table {
                width: 100% !important;
                border-collapse: collapse !important;
                margin-top: 15px !important;
            }
            th, td {
                border: 1px solid #94a3b8 !important;
                padding: 6px 10px !important;
                text-align: left !important;
                color: #000000 !important;
            }
            th {
                background-color: #f1f5f9 !important;
                font-weight: bold !important;
            }
            .text-right {
                text-align: right !important;
            }
            .text-center {
                text-align: center !important;
            }
            /* Judul Laporan Cetak Khusus */
            .print-title {
                display: block !important;
                text-align: center !important;
                margin-bottom: 25px !important;
            }
        }
        /* Secara default sembunyikan judul cetak di layar biasa */
        .print-title {
            display: none;
        }
    </style>

    <!-- Navigasi Tab Segmented Kontrol Premium (no-print) -->
    <div class="no-print bg-white p-1.5 rounded-xl border border-slate-100 shadow-sm flex items-center justify-start gap-1.5 mb-6 overflow-x-auto tab-nav-container">
        <button onclick="switchTab('stok')" id="tab-btn-stok" 
                class="tab-trigger-btn flex items-center gap-2 px-4 py-2.5 rounded-lg text-sm font-semibold transition-all duration-200">
            <i class="bi bi-box-seam"></i> 📊 Stok Barang
        </button>
        <button onclick="switchTab('masuk')" id="tab-btn-masuk" 
                class="tab-trigger-btn flex items-center gap-2 px-4 py-2.5 rounded-lg text-sm font-semibold transition-all duration-200">
            <i class="bi bi-box-arrow-in-down"></i> 📥 Barang Masuk
        </button>
        <button onclick="switchTab('keluar')" id="tab-btn-keluar" 
                class="tab-trigger-btn flex items-center gap-2 px-4 py-2.5 rounded-lg text-sm font-semibold transition-all duration-200">
            <i class="bi bi-box-arrow-up"></i> 📤 Barang Keluar
        </button>
    </div>

    <!-- ========================================== -->
    <!-- TAB 1: LAPORAN STOK BARANG -->
    <!-- ========================================== -->
    <div id="pane-stok" class="tab-content-pane space-y-6 hidden">
        <!-- Judul Laporan saat dicetak -->
        <div class="print-title">
            <h2 class="text-xl font-bold uppercase tracking-wider">Laporan Stok Barang</h2>
            <p class="text-sm text-slate-500">Toko Plastik Diza — Dicetak tanggal: {{ date('d/m/Y H:i') }}</p>
        </div>

        <!-- Summary Cards (no-print) -->
        <div class="no-print grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 flex flex-col justify-center">
                <p class="text-sm font-medium text-slate-500 mb-1">Total Nilai Aset</p>
                <h3 class="text-2xl font-extrabold text-slate-800">Rp {{ number_format($totalNilai, 0, ',', '.') }}</h3>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 flex flex-col justify-center">
                <p class="text-sm font-medium text-slate-500 mb-1">Total Jenis Kategori</p>
                <h3 class="text-2xl font-extrabold text-slate-800">{{ $jenisList->count() }} <span class="text-sm font-normal text-slate-400">Kategori</span></h3>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500 mb-1">Unduh Laporan</p>
                    <button onclick="printReport('stok')" class="mt-2 inline-flex items-center px-4 py-2.5 bg-slate-900 text-white rounded-lg hover:bg-slate-800 transition-colors text-sm font-semibold shadow-sm">
                        <i class="bi bi-printer mr-2"></i> Cetak
                    </button>
                </div>
                <i class="bi bi-file-earmark-pdf text-4xl text-blue-100"></i>
            </div>
        </div>

        <!-- Chart.js Section (no-print) -->
        <div class="no-print bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <h4 class="font-bold text-slate-800 flex items-center text-sm uppercase tracking-wide">
                    <i class="bi bi-pie-chart text-blue-500 mr-2 text-base"></i> 
                    <span>Analisis Visual Stok & Transaksi</span>
                </h4>
                
                <div class="flex items-center">
                    <div class="block sm:hidden w-full">
                        <select id="chartSelectorMobile" onchange="switchChart(this.value)" class="w-full text-xs font-semibold border-slate-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 py-1.5 pl-3 pr-8">
                            <option value="stokBarang">📊 Stok per Barang</option>
                            <option value="masukTrend">📈 Tren Barang Masuk</option>
                            <option value="keluarTrend">📉 Tren Barang Keluar</option>
                            <option value="statusKetersediaan">🔔 Status Ketersediaan</option>
                        </select>
                    </div>

                    <div class="hidden sm:flex items-center space-x-1 bg-slate-100 p-1 rounded-lg">
                        <button onclick="switchChart('stokBarang')" id="tab-stokBarang" class="chart-tab-btn px-3 py-1.5 text-xs font-bold rounded-md bg-white text-slate-800 shadow-sm transition-all duration-200">
                            📊 Stok/Barang
                        </button>
                        <button onclick="switchChart('masukTrend')" id="tab-masukTrend" class="chart-tab-btn px-3 py-1.5 text-xs font-bold rounded-md text-slate-600 hover:text-slate-800 transition-all duration-200">
                            📈 Barang Masuk
                        </button>
                        <button onclick="switchChart('keluarTrend')" id="tab-keluarTrend" class="chart-tab-btn px-3 py-1.5 text-xs font-bold rounded-md text-slate-600 hover:text-slate-800 transition-all duration-200">
                            📉 Barang Keluar
                        </button>
                        <button onclick="switchChart('statusKetersediaan')" id="tab-statusKetersediaan" class="chart-tab-btn px-3 py-1.5 text-xs font-bold rounded-md text-slate-600 hover:text-slate-800 transition-all duration-200">
                            🔔 Status Stok
                        </button>
                    </div>
                </div>
            </div>

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
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between gap-4 no-print">
                <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wide">Rincian Stok Barang</h3>
                <!-- Filter Form -->
                <form action="{{ route('laporan.index') }}" method="GET" class="flex items-center gap-2">
                    <input type="hidden" name="tab" value="stok">
                    <select name="stok_jenis" class="text-xs rounded-lg border-slate-200 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-colors">
                        <option value="">Semua Jenis</option>
                        @foreach($jenisList as $j)
                            <option value="{{ $j }}" {{ request('stok_jenis') == $j ? 'selected' : '' }}>{{ $j }}</option>
                        @endforeach
                    </select>
                    <select name="stok_status" class="text-xs rounded-lg border-slate-200 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-colors">
                        <option value="">Semua Status</option>
                        <option value="tersedia" {{ request('stok_status') == 'tersedia' ? 'selected' : '' }}>Tersedia (> 5)</option>
                        <option value="menipis" {{ request('stok_status') == 'menipis' ? 'selected' : '' }}>Menipis (1 - 5)</option>
                        <option value="habis" {{ request('stok_status') == 'habis' ? 'selected' : '' }}>Habis (0)</option>
                    </select>
                    <button type="submit" class="px-3 py-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 font-semibold text-xs transition-colors flex items-center gap-1">
                        <i class="bi bi-filter"></i> Filter
                    </button>
                    @if(request()->filled('stok_jenis') || request()->filled('stok_status'))
                        <a href="{{ route('laporan.index', ['tab' => 'stok']) }}" class="px-3 py-2 bg-slate-100 text-slate-600 rounded-lg hover:bg-slate-200 font-semibold text-xs transition-colors">
                            Reset
                        </a>
                    @endif
                </form>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-slate-50 text-slate-500 uppercase text-2xs tracking-wider">
                        <tr>
                            <th class="px-6 py-4 font-semibold">Kode</th>
                            <th class="px-6 py-4 font-semibold">Nama Barang</th>
                            <th class="px-6 py-4 font-semibold">Jenis / Kategori</th>
                            <th class="px-6 py-4 font-semibold text-center">Stok</th>
                            <th class="px-6 py-4 font-semibold">Harga Satuan</th>
                            <th class="px-6 py-4 font-semibold text-right">Nilai Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($barangs as $barang)
                            <tr class="hover:bg-slate-50/50 transition-colors {{ $barang->stok == 0 ? 'bg-red-50/40' : '' }}">
                                <td class="px-6 py-4 font-mono text-xs text-slate-500">{{ $barang->kode_barang }}</td>
                                <td class="px-6 py-4 font-semibold text-slate-800">{{ $barang->nama_barang }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ $barang->jenis }}</td>
                                <td class="px-6 py-4 text-center">
                                    @if($barang->stok == 0)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-800 border border-red-200">
                                            Habis (0)
                                        </span>
                                    @elseif($barang->stok <= 5)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800 border border-amber-200">
                                            Menipis ({{ $barang->stok }})
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-800 border border-green-200">
                                            {{ $barang->stok }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-slate-600">Rp {{ number_format($barang->harga, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-right font-bold text-slate-800">Rp {{ number_format($barang->stok * $barang->harga, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                                    <div class="flex flex-col items-center">
                                        <i class="bi bi-inbox text-3xl text-slate-300 mb-2"></i>
                                        <p class="text-xs">Tidak ada data untuk filter yang dipilih.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!-- ========================================== -->
    <!-- TAB 2: LAPORAN BARANG MASUK -->
    <!-- ========================================== -->
    <div id="pane-masuk" class="tab-content-pane space-y-6 hidden">
        <!-- Judul Laporan saat dicetak -->
        <div class="print-title">
            <h2 class="text-xl font-bold uppercase tracking-wider">Laporan Riwayat Barang Masuk</h2>
            @if(request('tanggal_dari') || request('tanggal_sampai'))
                <p class="text-xs text-slate-500">Periode: {{ request('tanggal_dari') ? date('d/m/Y', strtotime(request('tanggal_dari'))) : 'Awal' }} s/d {{ request('tanggal_sampai') ? date('d/m/Y', strtotime(request('tanggal_sampai'))) : 'Akhir' }}</p>
            @endif
            <p class="text-sm text-slate-500">Toko Plastik Diza — Dicetak tanggal: {{ date('d/m/Y H:i') }}</p>
        </div>

        <!-- Summary Cards & Filter (no-print) -->
        <div class="no-print bg-white rounded-xl shadow-sm border border-slate-100 p-6">
            <form action="{{ route('laporan.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                <input type="hidden" name="tab" value="masuk">
                
                <div class="md:col-span-2">
                    <label for="tanggal_dari_masuk" class="block text-xs font-semibold text-slate-500 uppercase mb-1">Dari Tanggal</label>
                    <input type="date" name="tanggal_dari" id="tanggal_dari_masuk" value="{{ request('tanggal_dari') }}" 
                           class="w-full text-xs rounded-lg border-slate-200 focus:border-blue-500 focus:ring focus:ring-blue-200">
                </div>
                <div class="md:col-span-2">
                    <label for="tanggal_sampai_masuk" class="block text-xs font-semibold text-slate-500 uppercase mb-1">Sampai Tanggal</label>
                    <input type="date" name="tanggal_sampai" id="tanggal_sampai_masuk" value="{{ request('tanggal_sampai') }}" 
                           class="w-full text-xs rounded-lg border-slate-200 focus:border-blue-500 focus:ring focus:ring-blue-200">
                </div>
                <div class="md:col-span-6 flex gap-2 items-end">
                    <div class="flex-1">
                        <label for="masuk_barang_id" class="block text-xs font-semibold text-slate-500 uppercase mb-1">Pilih Barang</label>
                        <select name="masuk_barang_id" id="masuk_barang_id" 
                                class="w-full text-xs rounded-lg border-slate-200 focus:border-blue-500 focus:ring focus:ring-blue-200">
                            <option value="">Semua Barang</option>
                            @foreach($allBarangsList as $b)
                                <option value="{{ $b->id }}" {{ request('masuk_barang_id') == $b->id ? 'selected' : '' }}>{{ $b->kode_barang }} - {{ $b->nama_barang }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold text-xs transition-colors flex items-center gap-1 shadow-sm h-[36px]">
                        <i class="bi bi-filter"></i> Filter
                    </button>
                    @if(request()->filled('tanggal_dari') || request()->filled('tanggal_sampai') || request()->filled('masuk_barang_id'))
                        <a href="{{ route('laporan.index', ['tab' => 'masuk']) }}" class="px-4 py-2 bg-slate-100 text-slate-600 rounded-lg hover:bg-slate-200 font-semibold text-xs transition-colors flex items-center h-[36px]">
                            Reset
                        </a>
                    @endif
                </div>
                
                <div class="md:col-span-2 flex justify-end">
                    <button type="button" onclick="printReport('masuk')" class="px-4 py-2 bg-slate-900 text-white rounded-lg hover:bg-slate-800 font-semibold text-xs transition-colors flex items-center gap-1 shadow-sm h-[36px]">
                        <i class="bi bi-printer"></i> Cetak
                    </button>
                </div>
            </form>
        </div>

        <!-- Main Table Section -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between no-print">
                <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wide">Rincian Barang Masuk</h3>
                <span class="text-xs font-semibold text-slate-500">Volume Masuk: <span class="text-green-600 font-bold">{{ number_format($totalJumlahMasuk) }}</span> unit</span>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-slate-50 text-slate-500 uppercase text-2xs tracking-wider">
                        <tr>
                            <th class="px-6 py-4 font-semibold">Tanggal</th>
                            <th class="px-6 py-4 font-semibold">Kode</th>
                            <th class="px-6 py-4 font-semibold">Nama Barang</th>
                            <th class="px-6 py-4 font-semibold text-center">Jumlah</th>
                            <th class="px-6 py-4 font-semibold">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($barangMasuks as $item)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-slate-600">{{ $item->tanggal->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 font-mono text-xs text-slate-500">{{ $item->barang->kode_barang }}</td>
                                <td class="px-6 py-4 font-semibold text-slate-800">{{ $item->barang->nama_barang }}</td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-bold bg-green-50 text-green-700 border border-green-200">
                                        + {{ $item->jumlah }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-slate-600">{{ $item->keterangan ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                    <div class="flex flex-col items-center">
                                        <i class="bi bi-inbox text-3xl text-slate-300 mb-2"></i>
                                        <p class="text-xs">Tidak ada data transaksi masuk pada periode ini.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!-- ========================================== -->
    <!-- TAB 3: LAPORAN BARANG KELUAR -->
    <!-- ========================================== -->
    <div id="pane-keluar" class="tab-content-pane space-y-6 hidden">
        <!-- Judul Laporan saat dicetak -->
        <div class="print-title">
            <h2 class="text-xl font-bold uppercase tracking-wider">Laporan Riwayat Barang Keluar</h2>
            @if(request('tanggal_dari') || request('tanggal_sampai'))
                <p class="text-xs text-slate-500">Periode: {{ request('tanggal_dari') ? date('d/m/Y', strtotime(request('tanggal_dari'))) : 'Awal' }} s/d {{ request('tanggal_sampai') ? date('d/m/Y', strtotime(request('tanggal_sampai'))) : 'Akhir' }}</p>
            @endif
            <p class="text-sm text-slate-500">Toko Plastik Diza — Dicetak tanggal: {{ date('d/m/Y H:i') }}</p>
        </div>

        <!-- Summary Cards & Filter (no-print) -->
        <div class="no-print bg-white rounded-xl shadow-sm border border-slate-100 p-6">
            <form action="{{ route('laporan.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                <input type="hidden" name="tab" value="keluar">
                
                <div class="md:col-span-2">
                    <label for="tanggal_dari_keluar" class="block text-xs font-semibold text-slate-500 uppercase mb-1">Dari Tanggal</label>
                    <input type="date" name="tanggal_dari" id="tanggal_dari_keluar" value="{{ request('tanggal_dari') }}" 
                           class="w-full text-xs rounded-lg border-slate-200 focus:border-blue-500 focus:ring focus:ring-blue-200">
                </div>
                <div class="md:col-span-2">
                    <label for="tanggal_sampai_keluar" class="block text-xs font-semibold text-slate-500 uppercase mb-1">Sampai Tanggal</label>
                    <input type="date" name="tanggal_sampai" id="tanggal_sampai_keluar" value="{{ request('tanggal_sampai') }}" 
                           class="w-full text-xs rounded-lg border-slate-200 focus:border-blue-500 focus:ring focus:ring-blue-200">
                </div>
                <div class="md:col-span-6 flex gap-2 items-end">
                    <div class="flex-1">
                        <label for="keluar_barang_id" class="block text-xs font-semibold text-slate-500 uppercase mb-1">Pilih Barang</label>
                        <select name="keluar_barang_id" id="keluar_barang_id" 
                                class="w-full text-xs rounded-lg border-slate-200 focus:border-blue-500 focus:ring focus:ring-blue-200">
                            <option value="">Semua Barang</option>
                            @foreach($allBarangsList as $b)
                                <option value="{{ $b->id }}" {{ request('keluar_barang_id') == $b->id ? 'selected' : '' }}>{{ $b->kode_barang }} - {{ $b->nama_barang }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold text-xs transition-colors flex items-center gap-1 shadow-sm h-[36px]">
                        <i class="bi bi-filter"></i> Filter
                    </button>
                    @if(request()->filled('tanggal_dari') || request()->filled('tanggal_sampai') || request()->filled('keluar_barang_id'))
                        <a href="{{ route('laporan.index', ['tab' => 'keluar']) }}" class="px-4 py-2 bg-slate-100 text-slate-600 rounded-lg hover:bg-slate-200 font-semibold text-xs transition-colors flex items-center h-[36px]">
                            Reset
                        </a>
                    @endif
                </div>
                
                <div class="md:col-span-2 flex justify-end">
                    <button type="button" onclick="printReport('keluar')" class="px-4 py-2 bg-slate-900 text-white rounded-lg hover:bg-slate-800 font-semibold text-xs transition-colors flex items-center gap-1 shadow-sm h-[36px]">
                        <i class="bi bi-printer"></i> Cetak
                    </button>
                </div>
            </form>
        </div>

        <!-- Main Table Section -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between no-print">
                <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wide">Rincian Barang Keluar</h3>
                <span class="text-xs font-semibold text-slate-500">Volume Keluar: <span class="text-rose-600 font-bold">{{ number_format($totalJumlahKeluar) }}</span> unit</span>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-slate-50 text-slate-500 uppercase text-2xs tracking-wider">
                        <tr>
                            <th class="px-6 py-4 font-semibold">Tanggal</th>
                            <th class="px-6 py-4 font-semibold">Kode</th>
                            <th class="px-6 py-4 font-semibold">Nama Barang</th>
                            <th class="px-6 py-4 font-semibold text-center">Jumlah</th>
                            <th class="px-6 py-4 font-semibold">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($barangKeluars as $item)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-slate-600">{{ $item->tanggal->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 font-mono text-xs text-slate-500">{{ $item->barang->kode_barang }}</td>
                                <td class="px-6 py-4 font-semibold text-slate-800">{{ $item->barang->nama_barang }}</td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                        - {{ $item->jumlah }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-slate-600">{{ $item->keterangan ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                    <div class="flex flex-col items-center">
                                        <i class="bi bi-inbox text-3xl text-slate-300 mb-2"></i>
                                        <p class="text-xs">Tidak ada data transaksi keluar pada periode ini.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!-- ========================================== -->
    <!-- JAVASCRIPT CONTROLLER TABS & CHART -->
    <!-- ========================================== -->
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Set tab aktif bawaan dari controller (stok/masuk/keluar)
            let defaultTab = "{{ $activeTab }}";
            switchTab(defaultTab);

            // Inisialisasi Data Visualisasi Grafik
            const paletteBg = [
                'rgba(59, 130, 246, 0.75)',  // Blue
                'rgba(16, 185, 129, 0.75)',  // Emerald
                'rgba(245, 158, 11, 0.75)',  // Amber
                'rgba(239, 68, 68, 0.75)',   // Rose
                'rgba(6, 182, 212, 0.75)',   // Cyan
                'rgba(139, 92, 246, 0.75)'   // Violet
            ];
            const paletteBorder = [
                'rgb(59, 130, 246)',
                'rgb(16, 185, 129)',
                'rgb(245, 158, 11)',
                'rgb(239, 68, 68)',
                'rgb(6, 182, 212)',
                'rgb(139, 92, 246)'
            ];

            // 1. Chart: Stok per Barang
            const ctxStok = document.getElementById('stokChart').getContext('2d');
            const dataStokVal = {!! $chartData !!};
            const labelsStok = {!! $chartLabels !!};
            const bgStokColors = dataStokVal.map(val => val <= 5 ? 'rgba(239, 68, 68, 0.75)' : 'rgba(59, 130, 246, 0.75)');
            const borderStokColors = dataStokVal.map(val => val <= 5 ? 'rgb(239, 68, 68)' : 'rgb(59, 130, 246)');

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
                        borderRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { precision: 0, font: { family: 'Inter', size: 10 } }
                        },
                        x: {
                            ticks: { font: { family: 'Inter', size: 10 } }
                        }
                    },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#0f172a',
                            padding: 10,
                            cornerRadius: 8,
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
                        borderColor: 'rgb(16, 185, 129)', // Emerald
                        backgroundColor: 'rgba(16, 185, 129, 0.08)',
                        borderWidth: 2.5,
                        tension: 0.35,
                        fill: true,
                        pointBackgroundColor: 'rgb(16, 185, 129)',
                        pointRadius: 3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { precision: 0, font: { family: 'Inter', size: 10 } }
                        },
                        x: {
                            ticks: { font: { family: 'Inter', size: 10 } }
                        }
                    },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#0f172a',
                            padding: 10,
                            cornerRadius: 8,
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
                        borderColor: 'rgb(239, 68, 68)', // Rose
                        backgroundColor: 'rgba(239, 68, 68, 0.08)',
                        borderWidth: 2.5,
                        tension: 0.35,
                        fill: true,
                        pointBackgroundColor: 'rgb(239, 68, 68)',
                        pointRadius: 3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { precision: 0, font: { family: 'Inter', size: 10 } }
                        },
                        x: {
                            ticks: { font: { family: 'Inter', size: 10 } }
                        }
                    },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#0f172a',
                            padding: 10,
                            cornerRadius: 8,
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
                                padding: 15,
                                font: { family: 'Inter', size: 11, weight: 600 }
                            }
                        },
                        tooltip: {
                            backgroundColor: '#0f172a',
                            padding: 10,
                            cornerRadius: 8,
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

        // FUNGSI GANTI TAB LAPORAN REAKTIF
        window.switchTab = function(tabId) {
            // Sembunyikan semua pane konten tab
            document.querySelectorAll('.tab-content-pane').forEach(pane => {
                pane.classList.add('hidden');
            });

            // Tampilkan pane konten tab aktif
            const activePane = document.getElementById('pane-' + tabId);
            if (activePane) {
                activePane.classList.remove('hidden');
            }

            // Atur gaya kelas button tab (Aktif vs Tidak Aktif)
            document.querySelectorAll('.tab-trigger-btn').forEach(btn => {
                if (btn.id === 'tab-btn-' + tabId) {
                    btn.classList.add('bg-blue-600', 'text-white', 'shadow-sm');
                    btn.classList.remove('bg-white', 'text-slate-600', 'hover:bg-slate-50');
                } else {
                    btn.classList.remove('bg-blue-600', 'text-white', 'shadow-sm');
                    btn.classList.add('bg-white', 'text-slate-600', 'hover:bg-slate-50');
                }
            });

            // Update parameter URL secara silent (tanpa reload halaman) agar user dapat mengklik share link/refresh dengan tab yang pas
            const url = new URL(window.location);
            url.searchParams.set('tab', tabId);
            window.history.pushState({}, '', url);
        };

        // FUNGSI PENGONTROL GRAFIK (TABS CHART)
        window.switchChart = function(chartId) {
            // Sync Kontrol Mobile Selector
            const mobileSelect = document.getElementById('chartSelectorMobile');
            if (mobileSelect && mobileSelect.value !== chartId) {
                mobileSelect.value = chartId;
            }

            // Sync Kontrol Desktop Button
            document.querySelectorAll('.chart-tab-btn').forEach(btn => {
                if (btn.id === 'tab-' + chartId) {
                    btn.classList.add('bg-white', 'text-slate-800', 'shadow-sm');
                    btn.classList.remove('text-slate-600', 'hover:text-slate-800');
                } else {
                    btn.classList.remove('bg-white', 'text-slate-800', 'shadow-sm');
                    btn.classList.add('text-slate-600', 'hover:text-slate-800');
                }
            });

            // Sembunyikan semua grafik
            document.querySelectorAll('.chart-container').forEach(container => {
                container.classList.add('hidden', 'opacity-0', 'scale-95');
                container.classList.remove('opacity-100', 'scale-100');
            });

            // Tampilkan grafik terpilih
            const activeContainer = document.getElementById('container-' + chartId);
            if (activeContainer) {
                activeContainer.classList.remove('hidden');
                setTimeout(() => {
                    activeContainer.classList.remove('opacity-0', 'scale-95');
                    activeContainer.classList.add('opacity-100', 'scale-100');
                }, 20);
            }
        };

        // FUNGSI CETAK LAPORAN BERSIH MEDIA PRINT
        window.printReport = function(tabId) {
            // Pasang class active-print ke pane tab yang dicetak agar terbaca di @media print
            document.querySelectorAll('.tab-content-pane').forEach(pane => {
                pane.classList.remove('active-print');
            });
            const activePane = document.getElementById('pane-' + tabId);
            if (activePane) {
                activePane.classList.add('active-print');
            }
            // Panggil dialog print browser
            window.print();
        };
    </script>
    @endpush
</x-app-layout>
