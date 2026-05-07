<x-app-layout>
    <x-slot name="title">Edit Barang</x-slot>
    <x-slot name="header">Edit Barang: {{ $barang->nama_barang }}</x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-3">
                <i class="bi bi-pencil-square text-blue-500 text-xl"></i>
                <h3 class="text-lg font-semibold text-slate-800">Form Edit Barang</h3>
            </div>
            
            <form action="{{ route('barang.update', $barang) }}" method="POST" class="p-6">
                @csrf
                @method('PUT')
                
                <div class="space-y-5">
                    <div>
                        <label for="kode_barang" class="block text-sm font-medium text-slate-700 mb-1">Kode Barang</label>
                        <input type="text" name="kode_barang" id="kode_barang" value="{{ old('kode_barang', $barang->kode_barang) }}" required
                               class="w-full rounded-lg border-slate-200 bg-slate-50 text-slate-500 cursor-not-allowed" readonly>
                        <p class="mt-1 text-xs text-slate-500">Kode barang tidak dapat diubah.</p>
                    </div>
                    
                    <div>
                        <label for="nama_barang" class="block text-sm font-medium text-slate-700 mb-1">Nama Barang</label>
                        <input type="text" name="nama_barang" id="nama_barang" value="{{ old('nama_barang', $barang->nama_barang) }}" required
                               class="w-full rounded-lg border-slate-200 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-colors @error('nama_barang') border-red-500 @enderror">
                        @error('nama_barang') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label for="jenis" class="block text-sm font-medium text-slate-700 mb-1">Jenis / Kategori</label>
                        <input type="text" name="jenis" id="jenis" value="{{ old('jenis', $barang->jenis) }}" required
                               class="w-full rounded-lg border-slate-200 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-colors">
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label for="stok" class="block text-sm font-medium text-slate-700 mb-1">Stok Saat Ini</label>
                            <input type="number" name="stok" id="stok" value="{{ old('stok', $barang->stok) }}" min="0" required
                                   class="w-full rounded-lg border-slate-200 bg-slate-50 text-slate-500 cursor-not-allowed" readonly>
                            <p class="mt-1 text-xs text-slate-500">Stok dikelola otomatis via Transaksi Masuk/Keluar.</p>
                        </div>
                        
                        <div>
                            <label for="harga" class="block text-sm font-medium text-slate-700 mb-1">Harga Satuan (Rp)</label>
                            <input type="number" name="harga" id="harga" value="{{ old('harga', $barang->harga) }}" min="0" required
                                   class="w-full rounded-lg border-slate-200 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-colors">
                        </div>
                    </div>
                </div>
                
                <div class="mt-8 flex items-center justify-end gap-3 pt-5 border-t border-slate-100">
                    <a href="{{ route('barang.index') }}" class="px-4 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 transition-colors">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>