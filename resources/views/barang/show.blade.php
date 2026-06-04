<x-app-layout>
    <x-slot name="title">Detail Barang</x-slot>
    <x-slot name="header">Detail Barang: {{ $barang->nama_barang }}</x-slot>

    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <i class="bi bi-info-circle text-blue-500 text-xl"></i>
                    <h3 class="text-lg font-semibold text-slate-800">Informasi Barang</h3>
                </div>
                @if(auth()->user()->isAdmin())
                <a href="{{ route('barang.edit', $barang) }}" class="inline-flex items-center justify-center px-3 py-1.5 bg-yellow-100 text-yellow-700 hover:bg-yellow-200 border border-transparent rounded-md font-medium transition-colors text-sm">
                    <i class="bi bi-pencil-square mr-1.5"></i> Edit
                </a>
                @endif
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-8">
                    <div>
                        <p class="text-sm font-medium text-slate-500 mb-1">Kode Barang</p>
                        <p class="text-base font-semibold text-slate-800 font-mono">{{ $barang->kode_barang }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-500 mb-1">Nama Barang</p>
                        <p class="text-base font-semibold text-slate-800">{{ $barang->nama_barang }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-500 mb-1">Jenis / Kategori</p>
                        <p class="text-base font-medium text-slate-800">{{ $barang->jenis }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-500 mb-1">Harga Satuan</p>
                        <p class="text-base font-medium text-slate-800">Rp {{ number_format($barang->harga, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-500 mb-1">Stok Saat Ini</p>
                        @if($barang->stok > 10)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-green-100 text-green-800">
                                {{ $barang->stok }} Unit
                            </span>
                        @elseif($barang->stok > 0)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-yellow-100 text-yellow-800">
                                {{ $barang->stok }} Unit
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-red-100 text-red-800">
                                Habis (0 Unit)
                            </span>
                        @endif
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-500 mb-1">Ditambahkan Pada</p>
                        <p class="text-base text-slate-700">{{ $barang->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    
                    <div class="md:col-span-2 pt-4 border-t border-slate-100">
                        <p class="text-sm font-medium text-slate-500 mb-1">Deskripsi / Spesifikasi</p>
                        @if($barang->deskripsi)
                            <p class="text-base text-slate-700 bg-slate-50 rounded-lg p-3 border border-slate-100 whitespace-pre-line">{{ $barang->deskripsi }}</p>
                        @else
                            <p class="text-sm text-slate-400 italic bg-slate-50/50 rounded-lg p-3 border border-slate-100/55">Tidak ada deskripsi atau spesifikasi tambahan.</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="bg-slate-50 px-6 py-3 border-t border-slate-100 flex justify-end">
                <a href="{{ route('barang.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-800 transition-colors">
                    <i class="bi bi-arrow-left mr-1"></i> Kembali ke Daftar
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Riwayat Barang Masuk -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100">
                    <h4 class="font-semibold text-slate-800 flex items-center gap-2">
                        <i class="bi bi-box-arrow-in-down text-green-500"></i> Riwayat Masuk Terakhir
                    </h4>
                </div>
                <div class="p-0">
                    <ul class="divide-y divide-slate-100">
                        @forelse($barang->barangMasuks()->latest()->take(5)->get() as $masuk)
                            <li class="px-6 py-3 hover:bg-slate-50 transition-colors">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="text-sm font-medium text-slate-800">+ {{ $masuk->jumlah }} Unit</p>
                                        <p class="text-xs text-slate-500">Ket: {{ $masuk->keterangan }}</p>
                                    </div>
                                    <span class="text-xs text-slate-400">{{ $masuk->created_at->format('d/m/Y') }}</span>
                                </div>
                            </li>
                        @empty
                            <li class="px-6 py-4 text-center text-sm text-slate-500">Belum ada riwayat masuk.</li>
                        @endforelse
                    </ul>
                </div>
            </div>

            <!-- Riwayat Barang Keluar -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100">
                    <h4 class="font-semibold text-slate-800 flex items-center gap-2">
                        <i class="bi bi-box-arrow-up text-blue-500"></i> Riwayat Keluar Terakhir
                    </h4>
                </div>
                <div class="p-0">
                    <ul class="divide-y divide-slate-100">
                        @forelse($barang->barangKeluars()->latest()->take(5)->get() as $keluar)
                            <li class="px-6 py-3 hover:bg-slate-50 transition-colors">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="text-sm font-medium text-slate-800">- {{ $keluar->jumlah }} Unit</p>
                                        <p class="text-xs text-slate-500">Ket: {{ $keluar->keterangan }}</p>
                                    </div>
                                    <span class="text-xs text-slate-400">{{ $keluar->created_at->format('d/m/Y') }}</span>
                                </div>
                            </li>
                        @empty
                            <li class="px-6 py-4 text-center text-sm text-slate-500">Belum ada riwayat keluar.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
