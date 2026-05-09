<x-app-layout>
    <x-slot name="title">Kasir (Point of Sale)</x-slot>
    <x-slot name="header">Kasir</x-slot>

    <!-- UI Kasir Split Layout -->
    <div class="flex flex-col lg:flex-row gap-6">
        
        <!-- KIRI: Daftar Barang -->
        <div class="w-full lg:w-2/3 bg-white rounded-xl shadow-sm border border-slate-100 p-6">
            <h3 class="text-lg font-semibold text-slate-800 mb-4">Pilih Barang</h3>
            
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                @foreach($barangs as $barang)
                    <div class="flex flex-col items-center p-4 border border-slate-200 rounded-xl hover:border-blue-500 hover:shadow-sm transition-all text-center bg-white h-full relative" id="card-{{ $barang->id }}">
                        <i class="bi bi-box-seam text-3xl text-slate-400 mb-2"></i>
                        <span class="font-medium text-slate-700 text-sm line-clamp-2 leading-tight mb-1">{{ $barang->nama_barang }}</span>
                        <span class="text-xs text-slate-500 mb-1">Stok: {{ $barang->stok }}</span>
                        <span class="font-semibold text-blue-600 mb-3">Rp {{ number_format($barang->harga, 0, ',', '.') }}</span>
                        
                        <div class="mt-auto w-full pt-2">
                            <div class="flex items-center gap-2 bg-slate-50 border border-slate-200 rounded-lg p-1 w-full justify-between">
                                <button type="button" onclick="updateQty('{{ $barang->id }}', -1, '{{ addslashes($barang->nama_barang) }}', {{ $barang->harga }}, {{ $barang->stok }})" class="w-8 h-8 flex items-center justify-center rounded bg-white shadow-sm border border-slate-200 hover:bg-slate-100 hover:text-red-600 transition-colors">
                                    <i class="bi bi-dash"></i>
                                </button>
                                <span class="font-bold w-8 text-center text-slate-800" id="qty-{{ $barang->id }}">0</span>
                                <button type="button" onclick="updateQty('{{ $barang->id }}', 1, '{{ addslashes($barang->nama_barang) }}', {{ $barang->harga }}, {{ $barang->stok }})" class="w-8 h-8 flex items-center justify-center rounded bg-blue-600 text-white shadow-sm hover:bg-blue-700 transition-colors">
                                    <i class="bi bi-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            @if($barangs->isEmpty())
                <div class="text-center py-10 text-slate-500">
                    <i class="bi bi-emoji-frown text-4xl mb-3 block"></i>
                    <p>Tidak ada barang yang tersedia atau stok habis.</p>
                </div>
            @endif
        </div>

        <!-- KANAN: Keranjang Belanja -->
        <div class="w-full lg:w-1/3 bg-white rounded-xl shadow-sm border border-slate-100 flex flex-col h-[calc(100vh-12rem)] min-h-[400px]">
            <div class="p-4 border-b border-slate-100 bg-slate-50 rounded-t-xl">
                <h3 class="font-semibold text-slate-800 flex items-center">
                    <i class="bi bi-cart3 mr-2"></i> Keranjang Belanja
                </h3>
            </div>
            
            <div class="flex-1 p-4 overflow-y-auto bg-slate-50/50">
                <div id="cart-empty" class="text-center py-10 text-slate-400">
                    <i class="bi bi-cart-x text-4xl mb-2 block"></i>
                    <p class="text-sm">Keranjang masih kosong</p>
                </div>
                
                <ul id="cart-list" class="space-y-3">
                    <!-- Item keranjang dirender via JS -->
                </ul>
            </div>

            <div class="p-4 border-t border-slate-100 bg-white rounded-b-xl">
                <div class="flex justify-between items-center mb-4">
                    <span class="text-slate-600 font-medium">Total Harga</span>
                    <span id="grand-total" class="text-2xl font-bold text-slate-800">Rp 0</span>
                </div>
                
                <form id="form-kasir" action="{{ route('kasir.store') }}" method="POST">
                    @csrf
                    <div id="hidden-inputs"></div>
                    <button type="submit" id="btn-submit" disabled class="w-full py-3 px-4 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition-colors disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                        <i class="bi bi-check-circle"></i> Proses Transaksi
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Script Kasir POS -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cartList = document.getElementById('cart-list');
            const cartEmpty = document.getElementById('cart-empty');
            const grandTotalEl = document.getElementById('grand-total');
            const hiddenInputsContainer = document.getElementById('hidden-inputs');
            const btnSubmit = document.getElementById('btn-submit');
            
            let cart = []; // Array of objects {id, nama, harga, qty, maxStok}

            // Fungsi format rupiah
            const formatRupiah = (number) => {
                return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);
            };

            // Update kuantitas
            window.updateQty = function(id, delta, nama = null, harga = null, maxStok = null) {
                let item = cart.find(i => i.id === String(id));
                
                if (!item && delta > 0 && nama !== null) {
                    item = { id: String(id), nama: nama, harga: parseInt(harga), qty: 0, maxStok: parseInt(maxStok) };
                    cart.push(item);
                }

                if (item) {
                    const newQty = item.qty + delta;
                    if (newQty >= 0 && newQty <= item.maxStok) {
                        item.qty = newQty;
                    } else if (newQty > item.maxStok) {
                        alert('Maksimal stok tercapai!');
                    }

                    if (item.qty === 0) {
                        cart = cart.filter(i => i.id !== String(id));
                    }

                    const qtyEl = document.getElementById('qty-' + id);
                    if (qtyEl) {
                        qtyEl.textContent = item.qty === 0 ? 0 : item.qty;
                    }
                    
                    renderCart();
                }
            };

            // Render Keranjang
            function renderCart() {
                cartList.innerHTML = '';
                hiddenInputsContainer.innerHTML = '';
                let grandTotal = 0;

                if (cart.length === 0) {
                    cartEmpty.style.display = 'block';
                    btnSubmit.disabled = true;
                } else {
                    cartEmpty.style.display = 'none';
                    btnSubmit.disabled = false;
                    
                    cart.forEach(item => {
                        const subtotal = item.qty * item.harga;
                        grandTotal += subtotal;

                        // UI Item Keranjang
                        const li = document.createElement('li');
                        li.className = 'bg-white p-3 rounded-lg border border-slate-100 shadow-sm flex flex-col gap-2';
                        li.innerHTML = `
                            <div class="flex justify-between items-start">
                                <span class="font-medium text-slate-800 text-sm">${item.nama}</span>
                                <span class="text-blue-600 font-semibold text-sm">${formatRupiah(subtotal)}</span>
                            </div>
                            <div class="flex justify-between items-center text-xs text-slate-500">
                                <span>${formatRupiah(item.harga)} x <span class="font-bold text-slate-700">${item.qty}</span></span>
                                <button type="button" onclick="updateQty('${item.id}', -${item.qty})" class="text-red-500 hover:text-red-700 p-1 flex items-center gap-1 transition-colors">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </div>
                        `;
                        cartList.appendChild(li);

                        // Hidden Inputs untuk Form Submit
                        hiddenInputsContainer.innerHTML += `
                            <input type="hidden" name="barang_id[]" value="${item.id}">
                            <input type="hidden" name="jumlah[]" value="${item.qty}">
                        `;
                    });
                }

                grandTotalEl.textContent = formatRupiah(grandTotal);
            }
        });
    </script>
</x-app-layout>
