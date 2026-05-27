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
                        <input type="number" name="jumlah" id="jumlah" value="{{ old('jumlah') }}" min="1" required placeholder="10" disabled
                               class="w-full rounded-lg border-slate-200 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-colors disabled:bg-slate-50 disabled:text-slate-400 disabled:cursor-not-allowed">
                    </div>
                    
                    <div>
                        <label for="keterangan" class="block text-sm font-medium text-slate-700 mb-1">Tujuan / Keterangan (Opsional)</label>
                        <input type="text" name="keterangan" id="keterangan" value="{{ old('keterangan') }}" placeholder="Contoh: Divisi Pemasaran" disabled
                               class="w-full rounded-lg border-slate-200 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-colors disabled:bg-slate-50 disabled:text-slate-400 disabled:cursor-not-allowed">
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
                const ts = new TomSelect('#barang_id', {
                    create: false,
                    placeholder: "-- Cari & Pilih Barang --",
                    sortField: {
                        field: "text",
                        direction: "asc"
                    }
                });

                // Toggle dynamic input enabling
                const inputJumlah = document.getElementById('jumlah');
                const inputKeterangan = document.getElementById('keterangan');

                function updateFields(value) {
                    const hasValue = value !== '';
                    inputJumlah.disabled = !hasValue;
                    inputKeterangan.disabled = !hasValue;
                }

                // Run once on load
                updateFields(ts.getValue());

                // On Tom Select change
                ts.on('change', function(value) {
                    updateFields(value);
                });

                // Prevent duplicate submit
                const form = document.querySelector('form');
                if (form) {
                    form.addEventListener('submit', function() {
                        const btn = form.querySelector('button[type="submit"]');
                        if (btn) {
                            btn.disabled = true;
                            btn.innerHTML = '<i class="bi bi-arrow-repeat animate-spin mr-2 text-sm"></i> Memproses...';
                        }
                    });
                }
            });
        </script>
    @endpush
</x-app-layout>
