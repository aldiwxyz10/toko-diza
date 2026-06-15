<x-app-layout>
    <x-slot name="title">Buat Request Stok</x-slot>
    <x-slot name="header">Ajukan Request Stok Barang</x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-3">
                <i class="bi bi-clipboard-plus text-blue-500 text-xl"></i>
                <h3 class="text-lg font-semibold text-slate-800">Form Request Stok</h3>
            </div>
            
            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mx-6 mt-6 rounded-r-lg">
                <div class="flex items-start">
                    <i class="bi bi-info-circle text-blue-500 mt-0.5 mr-3"></i>
                    <p class="text-sm text-blue-800">Request stok akan dikirimkan ke Admin. Stok baru akan masuk ke inventory Anda setelah Admin memproses pesanan ke Supplier secara fisik.</p>
                </div>
            </div>

            <form action="{{ route('request.store') }}" method="POST" class="p-6">
                @csrf
                
                <div class="space-y-5">
                    <div>
                        <label for="barang_id" class="block text-sm font-medium text-slate-700 mb-1">Pilih Barang yang Habis/Menipis</label>
                        <select name="barang_id" id="barang_id" required
                                class="w-full rounded-lg border-slate-200 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-colors">
                            <option value="">-- Pilih Barang --</option>
                            @foreach($barangs as $b)
                                <option value="{{ $b->id }}" {{ old('barang_id', request('barang_id')) == $b->id ? 'selected' : '' }}>
                                    {{ $b->kode_barang }} - {{ $b->nama_barang }} (Sisa Stok: {{ $b->stok }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label for="jumlah" class="block text-sm font-medium text-slate-700 mb-1">Jumlah yang Direquest</label>
                        <input type="number" name="jumlah" id="jumlah" value="{{ old('jumlah') }}" min="1" required disabled placeholder="Pilih barang terlebih dahulu..."
                               class="w-full rounded-lg border-slate-200 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-colors disabled:bg-slate-50 disabled:text-slate-400 disabled:cursor-not-allowed">
                    </div>
                    
                    <div>
                        <label for="catatan" class="block text-sm font-medium text-slate-700 mb-1">Keterangan / Alasan (Opsional)</label>
                        <textarea name="catatan" id="catatan" rows="3" disabled placeholder="Pilih barang terlebih dahulu..."
                                  class="w-full rounded-lg border-slate-200 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-colors disabled:bg-slate-50 disabled:text-slate-400 disabled:cursor-not-allowed">{{ old('catatan') }}</textarea>
                    </div>
                </div>
                
                <div class="mt-8 flex items-center justify-end gap-3 pt-5 border-t border-slate-100">
                    <a href="{{ route('request.index') }}" class="px-4 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 transition-colors shadow-sm flex items-center gap-2">
                        <i class="bi bi-send"></i> Kirim Request
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <!-- Tom Select CSS & JS -->
        <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
        
        <style>
            /* Custom premium styling for Tom Select matching the Toko Diza theme (Blue Accent) */
            .ts-wrapper .ts-control {
                border-color: #cbd5e1 !important; /* border-slate-300 */
                border-radius: 0.5rem !important; /* rounded-lg */
                padding: 0.55rem 0.75rem !important;
                font-size: 0.875rem !important;
                background-color: #ffffff !important;
                transition: border-color 0.2s, box-shadow 0.2s;
                min-height: 42px;
                display: flex;
                align-items: center;
            }
            .ts-wrapper.focus .ts-control {
                border-color: #3b82f6 !important; /* focus-blue-500 */
                box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2) !important; /* focus-blue-200 */
            }
            .ts-dropdown {
                border-radius: 0.5rem !important;
                border-color: #f1f5f9 !important;
                box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1) !important;
                font-size: 0.875rem !important;
                margin-top: 4px;
            }
            .ts-dropdown .active {
                background-color: #eff6ff !important; /* bg-blue-50 */
                color: #1e40af !important; /* text-blue-800 */
            }
            .ts-control input {
                font-size: 0.875rem !important;
            }
        </style>
        
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const barangSelect = new TomSelect('#barang_id', {
                    create: false,
                    placeholder: "-- Cari & Pilih Barang --",
                    sortField: {
                        field: "text",
                        direction: "asc"
                    }
                });

                const jumlahInput = document.getElementById('jumlah');
                const keteranganInput = document.getElementById('catatan');

                // Buka/kunci input secara dinamis saat barang dipilih
                barangSelect.on('change', function(value) {
                    if (value) {
                        jumlahInput.removeAttribute('disabled');
                        keteranganInput.removeAttribute('disabled');
                        jumlahInput.placeholder = "Contoh: 50";
                        keteranganInput.placeholder = "Contoh: Ada pelanggan besar butuh banyak minggu depan...";
                    } else {
                        jumlahInput.setAttribute('disabled', 'true');
                        keteranganInput.setAttribute('disabled', 'true');
                        jumlahInput.value = '';
                        keteranganInput.value = '';
                        jumlahInput.placeholder = "Pilih barang terlebih dahulu...";
                        keteranganInput.placeholder = "Pilih barang terlebih dahulu...";
                    }
                });

                // Jika ada old input (validation error), buka kunci form otomatis
                if (barangSelect.getValue()) {
                    jumlahInput.removeAttribute('disabled');
                    keteranganInput.removeAttribute('disabled');
                    jumlahInput.placeholder = "Contoh: 50";
                    keteranganInput.placeholder = "Contoh: Ada pelanggan besar butuh banyak minggu depan...";
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
                            btn.innerHTML = '<i class="bi bi-arrow-repeat animate-spin mr-2 text-sm"></i> Mengirim...';
                            btn.style.pointerEvents = 'none';
                            btn.style.opacity = '0.7';
                        }
                    });
                }
            });
        </script>
    @endpush
</x-app-layout>
