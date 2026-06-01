<x-app-layout>
    <x-slot name="title">Tambah Barang</x-slot>
    <x-slot name="header">Tambah Barang Baru</x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-3">
                <i class="bi bi-plus-circle text-blue-500 text-xl"></i>
                <h3 class="text-lg font-semibold text-slate-800">Form Tambah Barang</h3>
            </div>
            
            <form action="{{ route('barang.store') }}" method="POST" class="p-6">
                @csrf
                
                <div class="space-y-5">
                    <div>
                        <label for="kode_barang" class="block text-sm font-medium text-slate-700 mb-1">Kode Barang <span class="text-red-500">*</span></label>
                        <input type="text" name="kode_barang" id="kode_barang" value="{{ old('kode_barang') }}" required readonly
                               class="w-full rounded-lg border-slate-200 bg-slate-50 text-slate-500 cursor-not-allowed @error('kode_barang') border-red-500 @enderror"
                               placeholder="Pilih Kategori Terlebih Dahulu">
                        <p class="mt-1 text-xs text-slate-500" id="kode_barang_helper">Kode barang otomatis terisi setelah kategori dipilih.</p>
                        @error('kode_barang') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label for="nama_barang" class="block text-sm font-medium text-slate-700 mb-1">Nama Barang <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_barang" id="nama_barang" value="{{ old('nama_barang') }}" required
                               class="w-full rounded-lg border-slate-200 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-colors @error('nama_barang') border-red-500 @enderror">
                        @error('nama_barang') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label for="jenis" class="block text-sm font-medium text-slate-700 mb-1">Jenis / Kategori <span class="text-red-500">*</span></label>
                        <select name="jenis" id="jenis" required
                                class="w-full rounded-lg border-slate-200 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-colors @error('jenis') border-red-500 @enderror">
                            <option value="" disabled {{ old('jenis') ? '' : 'selected' }}>-- Pilih Jenis/Kategori --</option>
                            @foreach([
                                'Plastik',
                                'Bahan Kue & Makanan',
                                'Wadah Makanan',
                                'Peralatan Konsumsi',
                                'Tali & Packing',
                                'Kebutuhan Harian'
                            ] as $cat)
                                <option value="{{ $cat }}" {{ old('jenis') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                        @error('jenis') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label for="stok" class="block text-sm font-medium text-slate-700 mb-1">Stok Awal <span class="text-red-500">*</span></label>
                            <input type="number" name="stok" id="stok" value="{{ old('stok', 0) }}" min="0" required
                                   class="w-full rounded-lg border-slate-200 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-colors">
                        </div>
                        
                        <div>
                            <label for="harga" class="block text-sm font-medium text-slate-700 mb-1">Harga Satuan (Rp) <span class="text-red-500">*</span></label>
                            <input type="number" name="harga" id="harga" value="{{ old('harga') }}" min="0" required
                                   class="w-full rounded-lg border-slate-200 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-colors">
                        </div>
                    </div>

                    <div>
                        <label for="deskripsi" class="block text-sm font-medium text-slate-700 mb-1">Deskripsi / Spesifikasi (Opsional)</label>
                        <textarea name="deskripsi" id="deskripsi" rows="3"
                                  class="w-full rounded-lg border-slate-200 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-colors text-slate-600 placeholder-slate-400 text-sm"
                                  placeholder="Contoh: Ukuran 10x15 cm, ketebalan 0.5mm, isi 100 pcs per pack...">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>
                
                <div class="mt-8 flex items-center justify-end gap-3 pt-5 border-t border-slate-100">
                    <a href="{{ route('barang.index') }}" class="px-4 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        Simpan Barang
                    </button>
                </div>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const jenisSelect = document.getElementById('jenis');
            const kodeInput = document.getElementById('kode_barang');

            function fetchNextCode() {
                const selectedValue = jenisSelect.value;
                if (!selectedValue) {
                    kodeInput.value = '';
                    kodeInput.placeholder = 'Pilih Kategori Terlebih Dahulu';
                    return;
                }

                // Show loading state
                kodeInput.value = 'Memuat kode...';
                
                fetch(`/barang/next-code?jenis=${encodeURIComponent(selectedValue)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.next_code) {
                            kodeInput.value = data.next_code;
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching code:', error);
                        kodeInput.value = '';
                        kodeInput.placeholder = 'Gagal memuat kode';
                    });
            }

            // Listen to select changes
            jenisSelect.addEventListener('change', fetchNextCode);

            // Run once on page load (if category was old-selected)
            if (jenisSelect.value) {
                fetchNextCode();
            }

            // Prevent duplicate submit
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    if (form.classList.contains('form-submitting')) {
                        e.preventDefault();
                        return false;
                    }
                    form.classList.add('form-submitting');
                    
                    const btn = form.querySelector('button[type="submit"]');
                    if (btn) {
                        btn.innerHTML = '<i class="bi bi-arrow-repeat animate-spin mr-2 text-sm"></i> Menyimpan...';
                        btn.style.pointerEvents = 'none';
                        btn.style.opacity = '0.7';
                    }
                });
            }
        });
    </script>
</x-app-layout>