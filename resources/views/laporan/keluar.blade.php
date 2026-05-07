<x-app-layout>
    <x-slot name="title">Laporan Keluar</x-slot>
    <x-slot name="header">Laporan Transaksi Barang Keluar</x-slot>

    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 mb-6">
        <form action="{{ route('laporan.keluar') }}" method="GET" class="flex flex-col sm:flex-row gap-4 items-end">
            <div>
                <label for="start_date" class="block text-sm font-medium text-slate-700 mb-1">Dari Tanggal</label>
                <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}" class="w-full sm:w-auto rounded-lg border-slate-200 focus:border-blue-500 focus:ring focus:ring-blue-200 text-sm">
            </div>
            <div>
                <label for="end_date" class="block text-sm font-medium text-slate-700 mb-1">Sampai Tanggal</label>
                <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}" class="w-full sm:w-auto rounded-lg border-slate-200 focus:border-blue-500 focus:ring focus:ring-blue-200 text-sm">
            </div>
            <div class="flex gap-2">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium text-sm">
                    <i class="bi bi-filter mr-1"></i> Filter
                </button>
                <a href="{{ route('laporan.keluar') }}" class="px-4 py-2 bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200 transition-colors font-medium text-sm">
                    <i class="bi bi-arrow-clockwise"></i> Reset
                </a>
            </div>
            <div class="ml-auto">
                <button type="button" onclick="window.print()" class="px-4 py-2 bg-slate-800 text-white rounded-lg hover:bg-slate-700 transition-colors font-medium text-sm">
                    <i class="bi bi-printer mr-1"></i> Cetak
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 text-slate-500 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Tanggal</th>
                        <th class="px-6 py-4 font-semibold">Kode</th>
                        <th class="px-6 py-4 font-semibold">Nama Barang</th>
                        <th class="px-6 py-4 font-semibold">Jumlah Keluar</th>
                        <th class="px-6 py-4 font-semibold">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($barangKeluars as $item)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-slate-600">{{ $item->tanggal->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 font-mono text-xs text-slate-500">{{ $item->barang->kode_barang }}</td>
                            <td class="px-6 py-4 font-medium text-slate-800">{{ $item->barang->nama_barang }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                    - {{ $item->jumlah }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-slate-600">{{ $item->keterangan ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-slate-500">Tidak ada data transaksi keluar pada periode ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
