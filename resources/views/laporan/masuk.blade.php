<x-app-layout>
    <x-slot name="title">Laporan Masuk</x-slot>
    <x-slot name="header">Laporan Transaksi Barang Masuk</x-slot>

    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 mb-6">
        <form action="{{ route('laporan.masuk') }}" method="GET" class="flex flex-col sm:flex-row gap-4 items-end">
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
                        <th class="px-6 py-4 font-semibold">Jumlah Masuk</th>
                        <th class="px-6 py-4 font-semibold">Keterangan</th>
                        <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($barangMasuks as $item)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-slate-600">{{ $item->tanggal->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 font-mono text-xs text-slate-500">{{ $item->barang->kode_barang }}</td>
                            <td class="px-6 py-4 font-medium text-slate-800">{{ $item->barang->nama_barang }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                    + {{ $item->jumlah }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-slate-600">{{ $item->keterangan ?? '-' }}</td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('barang-masuk.edit', $item) }}" class="text-blue-500 hover:text-blue-700 p-1 hover:bg-blue-50 rounded transition-colors" title="Edit">
                                        <i class="bi bi-pencil-square text-lg"></i>
                                    </a>
                                    <form action="{{ route('barang-masuk.destroy', $item) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus riwayat masuk ini? Stok utama barang juga akan dikurangi otomatis.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-slate-500 hover:text-red-600 p-1 hover:bg-slate-100 rounded transition-colors" title="Hapus">
                                            <i class="bi bi-trash3 text-lg"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-slate-500">Tidak ada data transaksi masuk pada periode ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
