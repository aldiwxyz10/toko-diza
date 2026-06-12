<x-app-layout>
    <x-slot name="title">Pusat Laporan</x-slot>
    <x-slot name="header">Pusat Laporan & Analisis Data</x-slot>

    <!-- Style kustom untuk media cetak (Print Layout) -->
    <style>
        @media print {
            aside, header, #sidebarOverlay, .no-print, form, .alert-box, .accordion-toggle {
                display: none !important;
            }
            body {
                background: #ffffff !important;
                color: #000000 !important;
                font-size: 12px !important;
            }
            main {
                padding: 0 !important; margin: 0 !important; max-width: 100% !important;
            }
            .max-w-7xl {
                max-width: 100% !important; width: 100% !important; padding: 0 !important; margin: 0 !important;
            }
            .shadow-sm, .shadow-md, .border, .rounded-xl {
                border: none !important; box-shadow: none !important; border-radius: 0 !important;
            }
            /* Saat print, paksa buka semua accordion */
            .accordion-content {
                display: block !important;
            }
            table {
                width: 100% !important; border-collapse: collapse !important; margin-top: 15px !important;
            }
            th, td {
                border: 1px solid #94a3b8 !important; padding: 6px 10px !important; text-align: left !important; color: #000000 !important;
            }
            th { background-color: #f1f5f9 !important; font-weight: bold !important; }
            .print-title {
                display: block !important; text-align: center !important; margin-bottom: 25px !important;
            }
            /* Jika mau cetak bagian tertentu, section lain bisa disembunyikan pakai JS */
            .print-hidden {
                display: none !important;
            }
        }
        .print-title { display: none; }
        
        /* Animasi Transisi Accordion */
        .accordion-content {
            transition: max-height 0.3s ease-in-out, opacity 0.3s ease-in-out;
            max-height: 0;
            opacity: 0;
            overflow: hidden;
        }
        .accordion-content.open {
            max-height: 2000px; /* Nilai besar agar cukup untuk tabel */
            opacity: 1;
        }
    </style>

    <div id="report-container" class="space-y-12">
        <!-- ========================================== -->
        <!-- BAGIAN 1: LAPORAN STOK BARANG -->
        <!-- ========================================== -->
        <section id="section-stok" class="print-section">
            <div class="print-title">
                <h2 class="text-xl font-bold uppercase tracking-wider">Laporan Stok Inventaris</h2>
                <p class="text-sm text-slate-500">Toko Plastik Diza — Dicetak tanggal: {{ date('d/m/Y H:i') }}</p>
            </div>

            <!-- Header Section -->
            <div class="mb-4 flex items-center justify-between no-print">
                <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2"><i class="bi bi-box-seam text-blue-600"></i> Laporan Stok Barang</h3>
                <button onclick="printSection('section-stok')" class="px-4 py-2 bg-slate-900 text-white rounded-lg hover:bg-slate-800 transition-colors text-xs font-semibold shadow-sm flex items-center">
                    <i class="bi bi-printer mr-2"></i> Cetak Laporan Stok
                </button>
            </div>

            <!-- Summary Cards & Charts (Overview) -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 mb-6">
                <!-- Cards -->
                <div class="md:col-span-4 flex flex-col gap-6">
                    <div class="bg-gradient-to-br from-blue-600 to-blue-800 rounded-xl shadow-md border border-blue-500 p-6 flex flex-col justify-center text-white relative overflow-hidden h-full">
                        <div class="absolute -right-6 -top-6 opacity-20"><i class="bi bi-cash-stack text-9xl"></i></div>
                        <p class="text-blue-100 text-sm font-medium mb-1 relative z-10">Total Nilai Aset</p>
                        <h3 class="text-3xl font-extrabold relative z-10">Rp {{ number_format($totalNilai, 0, ',', '.') }}</h3>
                    </div>
                    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 flex items-center justify-between h-full">
                        <div>
                            <p class="text-sm font-medium text-slate-500 mb-1">Total Kategori</p>
                            <h3 class="text-3xl font-extrabold text-slate-800">{{ $jenisList->count() }} <span class="text-sm font-normal text-slate-400">Jenis</span></h3>
                        </div>
                        <div class="w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center"><i class="bi bi-tags text-2xl text-blue-500"></i></div>
                    </div>
                </div>

                <!-- Charts -->
                <div class="md:col-span-8 bg-white rounded-xl shadow-sm border border-slate-100 p-6">
                    <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wide mb-4">Distribusi Stok & Ketersediaan</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="relative w-full" style="height: 220px;"><canvas id="stokChart"></canvas></div>
                        <div class="relative w-full flex justify-center" style="height: 220px;"><canvas id="statusKetersediaanChart"></canvas></div>
                    </div>
                </div>
            </div>

            <!-- Accordion Toggle -->
            <button onclick="toggleAccordion('acc-stok')" class="accordion-toggle w-full no-print bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold py-3 px-6 rounded-xl flex items-center justify-between transition-colors mb-2">
                <span><i class="bi bi-table mr-2"></i> Lihat Rincian Tabel Stok</span>
                <i id="icon-acc-stok" class="bi bi-chevron-down transition-transform duration-300"></i>
            </button>

            <!-- Accordion Content (Table) -->
            <div id="acc-stok" class="accordion-content {{ request()->has('stok_jenis') || request()->has('stok_status') ? 'open' : '' }}">
                <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden mt-4">
                    <div class="px-6 py-4 border-b border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-4 bg-slate-50 no-print">
                        <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wide">Tabel Stok Inventaris</h3>
                        
                        <form action="{{ route('laporan.index') }}#section-stok" method="GET" class="flex flex-wrap items-center gap-2">
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
                            <button type="submit" class="px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold text-xs transition-colors flex items-center gap-1 shadow-sm h-[34px]">
                                <i class="bi bi-filter"></i> Filter
                            </button>
                            @if(request()->filled('stok_jenis') || request()->filled('stok_status'))
                                <a href="{{ route('laporan.index') }}#section-stok" class="px-3 py-2 bg-slate-200 text-slate-700 rounded-lg hover:bg-slate-300 font-semibold text-xs transition-colors h-[34px] flex items-center">Reset</a>
                            @endif
                        </form>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-white text-slate-500 uppercase text-2xs tracking-wider border-b border-slate-200">
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
                                    <tr class="hover:bg-slate-50 transition-colors {{ $barang->stok == 0 ? 'bg-red-50/20' : '' }}">
                                        <td class="px-6 py-4 font-mono text-xs text-slate-500">{{ $barang->kode_barang }}</td>
                                        <td class="px-6 py-4 font-semibold text-slate-800">{{ $barang->nama_barang }}</td>
                                        <td class="px-6 py-4 text-slate-600">{{ $barang->jenis }}</td>
                                        <td class="px-6 py-4 text-center">
                                            @if($barang->stok == 0)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-800 border border-red-200">Habis (0)</span>
                                            @elseif($barang->stok <= 5)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800 border border-amber-200">Menipis ({{ $barang->stok }})</span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-800 border border-green-200">{{ $barang->stok }}</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-slate-600">Rp {{ number_format($barang->harga, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4 text-right font-bold text-slate-800">Rp {{ number_format($barang->stok * $barang->harga, 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="6" class="px-6 py-12 text-center text-slate-400">Tidak ada data stok yang ditemukan.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>

        <!-- Garis Pemisah (Tidak Terlihat saat Print jika section lain di print) -->
        <hr class="border-slate-200 no-print">

        <!-- ========================================== -->
        <!-- BAGIAN 2: LAPORAN BARANG MASUK -->
        <!-- ========================================== -->
        <section id="section-masuk" class="print-section">
            <div class="print-title">
                <h2 class="text-xl font-bold uppercase tracking-wider">Laporan Riwayat Barang Masuk</h2>
                @if(request('tanggal_dari') || request('tanggal_sampai'))
                    <p class="text-xs text-slate-500">Periode: {{ request('tanggal_dari') ? date('d/m/Y', strtotime(request('tanggal_dari'))) : 'Awal' }} s/d {{ request('tanggal_sampai') ? date('d/m/Y', strtotime(request('tanggal_sampai'))) : 'Akhir' }}</p>
                @endif
                <p class="text-sm text-slate-500">Toko Plastik Diza — Dicetak tanggal: {{ date('d/m/Y H:i') }}</p>
            </div>

            <!-- Header Section -->
            <div class="mb-4 flex items-center justify-between no-print">
                <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2"><i class="bi bi-box-arrow-in-down text-emerald-600"></i> Riwayat Barang Masuk</h3>
                <button onclick="printSection('section-masuk')" class="px-4 py-2 bg-slate-900 text-white rounded-lg hover:bg-slate-800 transition-colors text-xs font-semibold shadow-sm flex items-center">
                    <i class="bi bi-printer mr-2"></i> Cetak Laporan Masuk
                </button>
            </div>

            <!-- Summary Card & Chart -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 mb-6">
                <div class="md:col-span-4 bg-white rounded-xl shadow-sm border border-slate-100 p-6 flex items-center h-full">
                    <div class="flex-1">
                        <p class="text-sm font-medium text-slate-500 mb-1">Volume Masuk 30 Hari Terakhir</p>
                        <h3 class="text-3xl font-extrabold text-slate-800">{{ number_format($totalJumlahMasuk) }} <span class="text-sm font-bold text-emerald-500">Unit</span></h3>
                    </div>
                    <div class="w-14 h-14 rounded-full bg-emerald-50 flex items-center justify-center flex-shrink-0"><i class="bi bi-graph-up-arrow text-2xl text-emerald-500"></i></div>
                </div>
                <div class="md:col-span-8 bg-white rounded-xl shadow-sm border border-slate-100 p-6">
                    <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wide mb-4">Tren Barang Masuk (30 Hari)</h4>
                    <div class="relative w-full" style="height: 180px;"><canvas id="masukTrendChart"></canvas></div>
                </div>
            </div>

            <!-- Accordion Toggle -->
            <button onclick="toggleAccordion('acc-masuk')" class="accordion-toggle w-full no-print bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold py-3 px-6 rounded-xl flex items-center justify-between transition-colors mb-2">
                <span><i class="bi bi-table mr-2"></i> Lihat Tabel Riwayat Masuk</span>
                <i id="icon-acc-masuk" class="bi bi-chevron-down transition-transform duration-300"></i>
            </button>

            <!-- Accordion Content (Table) -->
            <div id="acc-masuk" class="accordion-content {{ request()->has('masuk_barang_id') || request()->has('tanggal_dari') ? 'open' : '' }}">
                <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden mt-4">
                    <div class="p-6 border-b border-slate-100 bg-slate-50 no-print">
                        <form action="{{ route('laporan.index') }}#section-masuk" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                            <div class="md:col-span-3">
                                <label class="block text-xs font-semibold text-slate-500 uppercase mb-1">Dari Tanggal</label>
                                <input type="date" name="tanggal_dari" value="{{ request('tanggal_dari') }}" class="w-full text-xs rounded-lg border-slate-200 focus:border-blue-500 focus:ring focus:ring-blue-200">
                            </div>
                            <div class="md:col-span-3">
                                <label class="block text-xs font-semibold text-slate-500 uppercase mb-1">Sampai Tanggal</label>
                                <input type="date" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}" class="w-full text-xs rounded-lg border-slate-200 focus:border-blue-500 focus:ring focus:ring-blue-200">
                            </div>
                            <div class="md:col-span-4">
                                <label class="block text-xs font-semibold text-slate-500 uppercase mb-1">Pilih Barang</label>
                                <select name="masuk_barang_id" class="w-full text-xs rounded-lg border-slate-200 focus:border-blue-500 focus:ring focus:ring-blue-200">
                                    <option value="">Semua Barang</option>
                                    @foreach($allBarangsList as $b)
                                        <option value="{{ $b->id }}" {{ request('masuk_barang_id') == $b->id ? 'selected' : '' }}>{{ $b->kode_barang }} - {{ $b->nama_barang }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="md:col-span-2 flex justify-end gap-2 h-[34px]">
                                <button type="submit" class="px-4 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold text-xs transition-colors flex items-center shadow-sm">
                                    <i class="bi bi-filter mr-1"></i> Filter
                                </button>
                                @if(request()->filled('tanggal_dari') || request()->filled('tanggal_sampai') || request()->filled('masuk_barang_id'))
                                    <a href="{{ route('laporan.index') }}#section-masuk" class="px-4 bg-slate-200 text-slate-700 rounded-lg hover:bg-slate-300 font-semibold text-xs transition-colors flex items-center">Reset</a>
                                @endif
                            </div>
                        </form>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-white text-slate-500 uppercase text-2xs tracking-wider border-b border-slate-200">
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
                                    <tr class="hover:bg-slate-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap text-slate-600">{{ $item->tanggal->format('d/m/Y') }}</td>
                                        <td class="px-6 py-4 font-mono text-xs text-slate-500">{{ $item->barang->kode_barang }}</td>
                                        <td class="px-6 py-4 font-semibold text-slate-800">{{ $item->barang->nama_barang }}</td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">+ {{ $item->jumlah }}</span>
                                        </td>
                                        <td class="px-6 py-4 text-slate-600">{{ $item->keterangan ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="px-6 py-12 text-center text-slate-400">Tidak ada data transaksi masuk pada filter ini.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>

        <!-- Garis Pemisah (Tidak Terlihat saat Print jika section lain di print) -->
        <hr class="border-slate-200 no-print">

        <!-- ========================================== -->
        <!-- BAGIAN 3: LAPORAN BARANG KELUAR -->
        <!-- ========================================== -->
        <section id="section-keluar" class="print-section">
            <div class="print-title">
                <h2 class="text-xl font-bold uppercase tracking-wider">Laporan Riwayat Barang Keluar</h2>
                @if(request('tanggal_dari') || request('tanggal_sampai'))
                    <p class="text-xs text-slate-500">Periode: {{ request('tanggal_dari') ? date('d/m/Y', strtotime(request('tanggal_dari'))) : 'Awal' }} s/d {{ request('tanggal_sampai') ? date('d/m/Y', strtotime(request('tanggal_sampai'))) : 'Akhir' }}</p>
                @endif
                <p class="text-sm text-slate-500">Toko Plastik Diza — Dicetak tanggal: {{ date('d/m/Y H:i') }}</p>
            </div>

            <!-- Header Section -->
            <div class="mb-4 flex items-center justify-between no-print">
                <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2"><i class="bi bi-box-arrow-up text-rose-600"></i> Riwayat Barang Keluar</h3>
                <button onclick="printSection('section-keluar')" class="px-4 py-2 bg-slate-900 text-white rounded-lg hover:bg-slate-800 transition-colors text-xs font-semibold shadow-sm flex items-center">
                    <i class="bi bi-printer mr-2"></i> Cetak Laporan Keluar
                </button>
            </div>

            <!-- Summary Card & Chart -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 mb-6">
                <div class="md:col-span-4 bg-white rounded-xl shadow-sm border border-slate-100 p-6 flex items-center h-full">
                    <div class="flex-1">
                        <p class="text-sm font-medium text-slate-500 mb-1">Volume Keluar 30 Hari Terakhir</p>
                        <h3 class="text-3xl font-extrabold text-slate-800">{{ number_format($totalJumlahKeluar) }} <span class="text-sm font-bold text-rose-500">Unit</span></h3>
                    </div>
                    <div class="w-14 h-14 rounded-full bg-rose-50 flex items-center justify-center flex-shrink-0"><i class="bi bi-graph-down-arrow text-2xl text-rose-500"></i></div>
                </div>
                <div class="md:col-span-8 bg-white rounded-xl shadow-sm border border-slate-100 p-6">
                    <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wide mb-4">Tren Barang Keluar (30 Hari)</h4>
                    <div class="relative w-full" style="height: 180px;"><canvas id="keluarTrendChart"></canvas></div>
                </div>
            </div>

            <!-- Accordion Toggle -->
            <button onclick="toggleAccordion('acc-keluar')" class="accordion-toggle w-full no-print bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold py-3 px-6 rounded-xl flex items-center justify-between transition-colors mb-2">
                <span><i class="bi bi-table mr-2"></i> Lihat Tabel Riwayat Keluar</span>
                <i id="icon-acc-keluar" class="bi bi-chevron-down transition-transform duration-300"></i>
            </button>

            <!-- Accordion Content (Table) -->
            <div id="acc-keluar" class="accordion-content {{ request()->has('keluar_barang_id') || request()->has('tanggal_dari') ? 'open' : '' }}">
                <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden mt-4">
                    <div class="p-6 border-b border-slate-100 bg-slate-50 no-print">
                        <form action="{{ route('laporan.index') }}#section-keluar" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                            <div class="md:col-span-3">
                                <label class="block text-xs font-semibold text-slate-500 uppercase mb-1">Dari Tanggal</label>
                                <input type="date" name="tanggal_dari" value="{{ request('tanggal_dari') }}" class="w-full text-xs rounded-lg border-slate-200 focus:border-blue-500 focus:ring focus:ring-blue-200">
                            </div>
                            <div class="md:col-span-3">
                                <label class="block text-xs font-semibold text-slate-500 uppercase mb-1">Sampai Tanggal</label>
                                <input type="date" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}" class="w-full text-xs rounded-lg border-slate-200 focus:border-blue-500 focus:ring focus:ring-blue-200">
                            </div>
                            <div class="md:col-span-4">
                                <label class="block text-xs font-semibold text-slate-500 uppercase mb-1">Pilih Barang</label>
                                <select name="keluar_barang_id" class="w-full text-xs rounded-lg border-slate-200 focus:border-blue-500 focus:ring focus:ring-blue-200">
                                    <option value="">Semua Barang</option>
                                    @foreach($allBarangsList as $b)
                                        <option value="{{ $b->id }}" {{ request('keluar_barang_id') == $b->id ? 'selected' : '' }}>{{ $b->kode_barang }} - {{ $b->nama_barang }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="md:col-span-2 flex justify-end gap-2 h-[34px]">
                                <button type="submit" class="px-4 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold text-xs transition-colors flex items-center shadow-sm">
                                    <i class="bi bi-filter mr-1"></i> Filter
                                </button>
                                @if(request()->filled('tanggal_dari') || request()->filled('tanggal_sampai') || request()->filled('keluar_barang_id'))
                                    <a href="{{ route('laporan.index') }}#section-keluar" class="px-4 bg-slate-200 text-slate-700 rounded-lg hover:bg-slate-300 font-semibold text-xs transition-colors flex items-center">Reset</a>
                                @endif
                            </div>
                        </form>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-white text-slate-500 uppercase text-2xs tracking-wider border-b border-slate-200">
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
                                    <tr class="hover:bg-slate-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap text-slate-600">{{ $item->tanggal->format('d/m/Y') }}</td>
                                        <td class="px-6 py-4 font-mono text-xs text-slate-500">{{ $item->barang->kode_barang }}</td>
                                        <td class="px-6 py-4 font-semibold text-slate-800">{{ $item->barang->nama_barang }}</td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-bold bg-rose-50 text-rose-700 border border-rose-200">- {{ $item->jumlah }}</span>
                                        </td>
                                        <td class="px-6 py-4 text-slate-600">{{ $item->keterangan ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="px-6 py-12 text-center text-slate-400">Tidak ada data transaksi keluar pada filter ini.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- ========================================== -->
    <!-- JAVASCRIPT CONTROLLER ACCORDION & CHART -->
    <!-- ========================================== -->
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Periksa jika ada hash (misal #section-stok) setelah filter/reset
            // Buka accordion secara otomatis jika URL mengandung hash tersebut
            if (window.location.hash) {
                const section = window.location.hash.replace('#section-', '');
                const accordion = document.getElementById('acc-' + section);
                const icon = document.getElementById('icon-acc-' + section);
                if (accordion) {
                    accordion.classList.add('open');
                    if (icon) icon.classList.add('rotate-180');
                    // Scroll smooth ke area
                    setTimeout(() => {
                        document.querySelector(window.location.hash).scrollIntoView({ behavior: 'smooth' });
                    }, 100);
                }
            }

            // Inisialisasi Data Visualisasi Grafik
            const paletteBg = ['rgba(59, 130, 246, 0.75)', 'rgba(16, 185, 129, 0.75)', 'rgba(245, 158, 11, 0.75)', 'rgba(239, 68, 68, 0.75)', 'rgba(6, 182, 212, 0.75)', 'rgba(139, 92, 246, 0.75)'];
            const paletteBorder = ['rgb(59, 130, 246)', 'rgb(16, 185, 129)', 'rgb(245, 158, 11)', 'rgb(239, 68, 68)', 'rgb(6, 182, 212)', 'rgb(139, 92, 246)'];

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
                    datasets: [{ label: 'Jumlah Stok', data: dataStokVal, backgroundColor: bgStokColors, borderColor: borderStokColors, borderWidth: 1, borderRadius: 6 }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    scales: { y: { beginAtZero: true, ticks: { precision: 0, font: { family: 'Inter', size: 10 } } }, x: { ticks: { font: { family: 'Inter', size: 10 } } } },
                    plugins: { legend: { display: false }, tooltip: { backgroundColor: '#0f172a', padding: 10, cornerRadius: 8, callbacks: { label: function(context) { return 'Stok: ' + context.parsed.y + ' Unit'; } } } }
                }
            });

            // 2. Chart: Status Ketersediaan Barang
            const ctxStatus = document.getElementById('statusKetersediaanChart').getContext('2d');
            const labelsStatus = {!! json_encode($statusKetersediaanLabels) !!};
            const dataStatusVal = {!! json_encode($statusKetersediaanData) !!};
            const semanticBg = ['rgb(0, 255, 156)', 'rgb(255, 231, 0)', 'rgb(237, 63, 39)'];
            const semanticBorder = ['rgb(0, 255, 156)', 'rgb(254, 255, 167)', 'rgb(239, 68, 68)'];

            new Chart(ctxStatus, {
                type: 'pie',
                data: {
                    labels: labelsStatus,
                    datasets: [{ data: dataStatusVal, backgroundColor: semanticBg, borderColor: semanticBorder, borderWidth: 1 }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom', labels: { usePointStyle: true, boxWidth: 6, padding: 15, font: { family: 'Inter', size: 11, weight: 600 } } },
                        tooltip: { backgroundColor: '#0f172a', padding: 10, cornerRadius: 8, callbacks: { label: function(context) { return ' ' + context.label + ': ' + context.parsed + ' Item'; } } }
                    }
                }
            });

            // 3. Chart: Tren Barang Masuk (Line Chart)
            const ctxMasuk = document.getElementById('masukTrendChart').getContext('2d');
            const labelsMasuk = {!! json_encode($masukLabels) !!};
            const dataMasukVal = {!! json_encode($masukData) !!};

            new Chart(ctxMasuk, {
                type: 'line',
                data: {
                    labels: labelsMasuk,
                    datasets: [{ label: 'Total Masuk', data: dataMasukVal, borderColor: 'rgb(16, 185, 129)', backgroundColor: 'rgba(16, 185, 129, 0.08)', borderWidth: 2.5, tension: 0.35, fill: true, pointBackgroundColor: 'rgb(16, 185, 129)', pointRadius: 3 }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    scales: { y: { beginAtZero: true, ticks: { precision: 0, font: { family: 'Inter', size: 10 } } }, x: { ticks: { font: { family: 'Inter', size: 10 } } } },
                    plugins: { legend: { display: false }, tooltip: { backgroundColor: '#0f172a', padding: 10, cornerRadius: 8, callbacks: { label: function(context) { return ' Masuk: ' + context.parsed.y + ' Unit'; } } } }
                }
            });

            // 4. Chart: Tren Barang Keluar (Line Chart)
            const ctxKeluar = document.getElementById('keluarTrendChart').getContext('2d');
            const labelsKeluar = {!! json_encode($keluarLabels) !!};
            const dataKeluarVal = {!! json_encode($keluarData) !!};

            new Chart(ctxKeluar, {
                type: 'line',
                data: {
                    labels: labelsKeluar,
                    datasets: [{ label: 'Total Keluar', data: dataKeluarVal, borderColor: 'rgb(239, 68, 68)', backgroundColor: 'rgba(239, 68, 68, 0.08)', borderWidth: 2.5, tension: 0.35, fill: true, pointBackgroundColor: 'rgb(239, 68, 68)', pointRadius: 3 }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    scales: { y: { beginAtZero: true, ticks: { precision: 0, font: { family: 'Inter', size: 10 } } }, x: { ticks: { font: { family: 'Inter', size: 10 } } } },
                    plugins: { legend: { display: false }, tooltip: { backgroundColor: '#0f172a', padding: 10, cornerRadius: 8, callbacks: { label: function(context) { return ' Keluar: ' + context.parsed.y + ' Unit'; } } } }
                }
            });
        });

        // FUNGSI ACCORDION TOGGLE
        window.toggleAccordion = function(id) {
            const el = document.getElementById(id);
            const icon = document.getElementById('icon-' + id);
            
            if (el.classList.contains('open')) {
                el.classList.remove('open');
                icon.classList.remove('rotate-180');
            } else {
                el.classList.add('open');
                icon.classList.add('rotate-180');
            }
        };

        // FUNGSI CETAK LAPORAN SELEKTIF
        window.printSection = function(sectionId) {
            // Sembunyikan section lain
            document.querySelectorAll('.print-section').forEach(section => {
                if (section.id !== sectionId) {
                    section.classList.add('print-hidden');
                }
            });
            
            // Panggil dialog print browser
            window.print();
            
            // Kembalikan visibilitas semua section setelah dialog print ditutup
            setTimeout(() => {
                document.querySelectorAll('.print-section').forEach(section => {
                    section.classList.remove('print-hidden');
                });
            }, 500);
        };
    </script>
    @endpush
</x-app-layout>
