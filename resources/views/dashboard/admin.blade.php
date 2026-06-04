<x-app-layout>
    <x-slot name="title">Beranda Admin</x-slot>
    <x-slot name="header">Beranda Admin</x-slot>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <!-- Card: Total Barang -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-2xl flex-shrink-0">
                <i class="bi bi-box"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500 mb-1">Total Barang</p>
                <h3 class="text-2xl font-bold text-slate-800">{{ number_format($totalBarang) }}</h3>
            </div>
        </div>

        <!-- Card: Total Stok -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-2xl flex-shrink-0">
                <i class="bi bi-boxes"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500 mb-1">Total Stok Keseluruhan</p>
                <h3 class="text-2xl font-bold text-slate-800">{{ number_format($totalStok) }}</h3>
            </div>
        </div>

        <!-- Card: Barang Habis -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-red-100 text-red-600 flex items-center justify-center text-2xl flex-shrink-0">
                <i class="bi bi-exclamation-triangle"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500 mb-1">Stok Habis</p>
                <h3 class="text-2xl font-bold text-slate-800">{{ number_format($barangHabis) }}</h3>
            </div>
        </div>

        <!-- Card: Request Pending -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center text-2xl flex-shrink-0">
                <i class="bi bi-clipboard-check"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500 mb-1">Request Pending</p>
                <h3 class="text-2xl font-bold text-slate-800">{{ number_format($requestPending) }}</h3>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Transaksi Bulan Ini -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-2">
                <i class="bi bi-calendar-check text-blue-500"></i>
                <h4 class="font-semibold text-slate-800">Transaksi Bulan Ini</h4>
            </div>
            <div class="p-6">
                <div class="flex items-center justify-between mb-4 pb-4 border-b border-slate-50">
                    <div>
                        <p class="text-sm text-slate-500 mb-1">Barang Masuk</p>
                        <h4 class="text-xl font-bold text-green-600">{{ number_format($masukBulanIni) }} <span class="text-sm font-normal text-slate-400">Unit</span></h4>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-green-50 flex items-center justify-center text-green-500">
                        <i class="bi bi-arrow-down-left text-lg"></i>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500 mb-1">Barang Keluar</p>
                        <h4 class="text-xl font-bold text-blue-600">{{ number_format($keluarBulanIni) }} <span class="text-sm font-normal text-slate-400">Unit</span></h4>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-500">
                        <i class="bi bi-arrow-up-right text-lg"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stok Kritis -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-2">
                <i class="bi bi-exclamation-circle text-red-500"></i>
                <h4 class="font-semibold text-slate-800">Stok Kritis (≤ 5)</h4>
            </div>
            <div class="p-0 overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-slate-50 text-slate-500">
                        <tr>
                            <th class="px-6 py-3 font-medium">Barang</th>
                            <th class="px-6 py-3 font-medium">Stok</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($barangKritis as $barang)
                            <tr class="hover:bg-slate-50">
                                <td class="px-6 py-3 text-slate-800">{{ $barang->nama_barang }}</td>
                                <td class="px-6 py-3">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                        {{ $barang->stok }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="px-6 py-4 text-center text-slate-500">Tidak ada stok kritis.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
