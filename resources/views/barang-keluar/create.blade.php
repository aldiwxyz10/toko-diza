<x-app-layout>
    <x-slot name="title">Tambah Barang Keluar</x-slot>
    <x-slot name="header">Input Barang Keluar</x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-3">
                <i class="bi bi-box-arrow-up text-blue-500 text-xl"></i>
                <h3 class="text-lg font-semibold text-slate-800">Form Barang Keluar</h3>
            </div>
            
            <form action="{{ route('barang-keluar.store') }}" method="POST" class="p-6">
                @csrf
                
                <div class="space-y-5">
                    <div>
                        <label for="tanggal" class="block text-sm font-medium text-slate-700 mb-1">Tanggal Keluar</label>
                        <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required
                               class="w-full rounded-lg border-slate-200 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-colors">
                    </div>

                    <div>
                        <label for="barang_id" class="block text-sm font-medium text-slate-700 mb-1">Pilih Barang</label>
                        <select name="barang_id" id="barang_id" required
                                class="w-full rounded-lg border-slate-200 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-colors">
                            <option value="">-- Pilih Barang --</option>
                            @foreach($barangs as $b)
                                <option value="{{ $b->id }}" {{ old('barang_id') == $b->id ? 'selected' : '' }} {{ $b->stok == 0 ? 'disabled' : '' }}>
                                    {{ $b->kode_barang }} - {{ $b->nama_barang }} (Stok: {{ $b->stok }}) {{ $b->stok == 0 ? '[HABIS]' : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label for="jumlah" class="block text-sm font-medium text-slate-700 mb-1">Jumlah Keluar</label>
                        <input type="number" name="jumlah" id="jumlah" value="{{ old('jumlah') }}" min="1" required placeholder="10"
                               class="w-full rounded-lg border-slate-200 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-colors">
                    </div>
                    
                    <div>
                        <label for="keterangan" class="block text-sm font-medium text-slate-700 mb-1">Tujuan / Keterangan (Opsional)</label>
                        <input type="text" name="keterangan" id="keterangan" value="{{ old('keterangan') }}" placeholder="Contoh: Divisi Pemasaran"
                               class="w-full rounded-lg border-slate-200 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-colors">
                    </div>
                </div>
                
                <div class="mt-8 flex items-center justify-end gap-3 pt-5 border-t border-slate-100">
                    <a href="{{ route('barang-keluar.index') }}" class="px-4 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 transition-colors shadow-sm">
                        Simpan Transaksi Keluar
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
