<x-app-layout>
    <x-slot name="title">Data Barang</x-slot>
    <x-slot name="header">Data Barang</x-slot>

    <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <h3 class="text-lg font-semibold text-slate-800">Daftar Inventory</h3>
            @if(auth()->user()->isAdmin())
                <a href="{{ route('barang.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors text-sm">
                    <i class="bi bi-plus-lg mr-2"></i> Tambah Barang
                </a>
            @endif
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 text-slate-500 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Kode</th>
                        <th class="px-6 py-4 font-semibold">Nama Barang</th>
                        <th class="px-6 py-4 font-semibold">Jenis</th>
                        <th class="px-6 py-4 font-semibold">Stok</th>
                        <th class="px-6 py-4 font-semibold">Harga (Rp)</th>
                        @if(auth()->user()->isAdmin())
                        <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($barangs as $barang)
                        <tr class="hover:bg-slate-50 transition-colors {{ $barang->stok == 0 ? 'bg-red-50' : '' }}">
                            <td class="px-6 py-4">
                                <span class="font-mono text-xs text-slate-500 bg-slate-100 px-2 py-1 rounded">{{ $barang->kode_barang }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('barang.show', $barang) }}" class="font-medium text-slate-800 hover:text-blue-600 transition-colors">
                                    {{ $barang->nama_barang }}
                                </a>
                            </td>
                            <td class="px-6 py-4 text-slate-600">{{ $barang->jenis }}</td>
                            <td class="px-6 py-4">
                                @if($barang->stok > 10)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        {{ $barang->stok }}
                                    </span>
                                @elseif($barang->stok > 0)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        {{ $barang->stok }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Habis (0)
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-slate-600">Rp {{ number_format($barang->harga, 0, ',', '.') }}</td>
                            @if(auth()->user()->isAdmin())
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('barang.edit', $barang) }}" class="text-blue-600 hover:text-blue-800 p-2 hover:bg-blue-50 rounded-lg transition-colors" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('barang.destroy', $barang) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus barang ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 p-2 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ auth()->user()->isAdmin() ? '6' : '5' }}" class="px-6 py-12 text-center text-slate-500">
                                <div class="flex flex-col items-center">
                                    <i class="bi bi-box-seam text-4xl text-slate-300 mb-3"></i>
                                    <p class="text-lg">Belum ada data barang.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>