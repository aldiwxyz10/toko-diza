<x-app-layout>
    <x-slot name="title">Barang Masuk</x-slot>
    <x-slot name="header">Data Barang Masuk</x-slot>

    <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <h3 class="text-lg font-semibold text-slate-800">Riwayat Barang Masuk</h3>
            <a href="{{ route('barang-masuk.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-green-600 border border-transparent rounded-lg font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors text-sm">
                <i class="bi bi-plus-lg mr-2"></i> Tambah Transaksi Masuk
            </a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 text-slate-500 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Tanggal</th>
                        <th class="px-6 py-4 font-semibold">Nama Barang</th>
                        <th class="px-6 py-4 font-semibold">Jumlah</th>
                        <th class="px-6 py-4 font-semibold">Keterangan</th>
                        <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($barangMasuks as $item)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-slate-600">{{ $item->tanggal->format('d M Y') }}</td>
                            <td class="px-6 py-4">
                                <span class="font-medium text-slate-800">{{ $item->barang->nama_barang }}</span>
                                <div class="text-xs text-slate-500">{{ $item->barang->kode_barang }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded font-medium bg-green-100 text-green-800">
                                    + {{ $item->jumlah }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-slate-600">{{ $item->keterangan ?? '-' }}</td>
                            <td class="px-6 py-4 text-right">
                                <form action="{{ route('barang-masuk.destroy', $item) }}" method="POST" class="inline-block" onsubmit="return confirm('Menghapus riwayat masuk akan MENGURANGI stok barang. Lanjutkan?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 p-2 hover:bg-red-50 rounded-lg transition-colors" title="Hapus Data">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                <div class="flex flex-col items-center">
                                    <i class="bi bi-box-arrow-in-down text-4xl text-slate-300 mb-3"></i>
                                    <p class="text-lg">Belum ada transaksi barang masuk.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($barangMasuks->hasPages())
        <div class="px-6 py-4 border-t border-slate-100">
            {{ $barangMasuks->links() }}
        </div>
        @endif
    </div>
</x-app-layout>
