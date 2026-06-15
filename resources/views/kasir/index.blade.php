<x-app-layout>
    <x-slot name="title">Kasir (Point of Sale)</x-slot>
    <x-slot name="header">Kasir</x-slot>

    <!-- UI Kasir Split Layout -->
    <div class="flex flex-col lg:flex-row gap-6">
        
        <!-- KIRI: Daftar Barang -->
        <div class="w-full lg:w-2/3 bg-white rounded-xl shadow-sm border border-slate-100 p-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 border-b border-slate-100 pb-4">
                <h2 class="text-xl font-semibold text-slate-800 whitespace-nowrap flex-shrink-0">Pilih Barang</h2>
                <!-- Search Product Input -->
                <div class="flex items-center border pl-3 gap-2 bg-white border-slate-200 focus-within:border-blue-500 focus-within:ring-2 focus-within:ring-blue-100 h-[38px] rounded-lg overflow-hidden w-full sm:flex-grow sm:max-w-[590px] transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 30 30" fill="#94A3B8">
                        <path d="M13 3C7.489 3 3 7.489 3 13s4.489 10 10 10a9.95 9.95 0 0 0 6.322-2.264l5.971 5.971a1 1 0 1 0 1.414-1.414l-5.97-5.97A9.95 9.95 0 0 0 23 13c0-5.511-4.489-10-10-10m0 2c4.43 0 8 3.57 8 8s-3.57 8-8 8-8-3.57-8-8 3.57-8 8-8"/>
                    </svg>
                    <input type="text" id="search-kasir" placeholder="Cari nama atau deskripsi..." 
                           class="w-full h-full bg-transparent border-0 p-0 focus:ring-0 text-slate-600 placeholder-slate-400 text-sm">
                </div>
            </div>
            
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                @foreach($barangs as $barang)
                    <div class="flex flex-col items-center p-4 border rounded-xl transition-all text-center h-full relative 
                        {{ $barang->stok == 0 ? 'bg-red-50/30 border-red-400' : 'bg-white border-slate-200 hover:border-blue-500 hover:shadow-sm' }}" 
                        id="card-{{ $barang->id }}">

                        <i class="bi bi-box-seam text-3xl {{ $barang->stok == 0 ? 'text-red-300' : 'text-slate-400' }} mb-2"></i>
                        <span class="font-medium text-slate-700 text-sm line-clamp-2 leading-tight mb-0.5">{{ $barang->nama_barang }}</span>
                        @if($barang->deskripsi)
                            <span class="text-[10px] text-slate-400 line-clamp-1 mb-1 max-w-full px-1" title="{{ $barang->deskripsi }}">
                                {{ $barang->deskripsi }}
                            </span>
                        @else
                            <span class="text-[10px] text-slate-300 italic mb-1">Tanpa spesifikasi</span>
                        @endif
                        
                        @if($barang->stok == 0)
                            <span class="text-xs text-red-600 font-bold mb-1">Stok Habis</span>
                        @else
                            <span class="text-xs text-slate-500 mb-1">Stok: {{ $barang->stok }}</span>
                        @endif
                        
                        <span class="font-semibold {{ $barang->stok == 0 ? 'text-red-500' : 'text-blue-600' }} mb-3">Rp {{ number_format($barang->harga, 0, ',', '.') }}</span>
                        
                        <div class="mt-auto w-full pt-2">
                            @if($barang->stok == 0)
                                <a href="{{ route('request.create', ['barang_id' => $barang->id]) }}" class="w-full py-1.5 flex items-center justify-center rounded-lg bg-red-100 text-red-700 hover:bg-red-200 transition-colors text-xs font-bold gap-1 border border-red-200 shadow-sm relative z-20">
                                    <i class="bi bi-box-arrow-in-right"></i> Ajukan Restock
                                </a>
                            @else
                                <div class="flex items-center gap-2 bg-slate-50 border border-slate-200 rounded-lg p-1 w-full justify-between relative z-20">
                                    <button type="button" 
                                        onclick="updateQty('{{ $barang->id }}', -1, '{{ addslashes($barang->nama_barang) }}', {{ $barang->harga }}, {{ $barang->stok }})" 
                                        class="w-8 h-8 flex items-center justify-center rounded bg-white shadow-sm border border-slate-200 transition-colors hover:bg-slate-100 hover:text-red-600">
                                        <i class="bi bi-dash"></i>
                                    </button>
                                    <span class="font-bold w-8 text-center text-slate-800" id="qty-{{ $barang->id }}">0</span>
                                    <button type="button" 
                                        onclick="updateQty('{{ $barang->id }}', 1, '{{ addslashes($barang->nama_barang) }}', {{ $barang->harga }}, {{ $barang->stok }})" 
                                        class="w-8 h-8 flex items-center justify-center rounded text-white shadow-sm transition-colors bg-blue-600 hover:bg-blue-700">
                                        <i class="bi bi-plus"></i>
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- No Results Message -->
            <div id="no-results-msg" class="text-center py-12 text-slate-500 hidden">
                <i class="bi bi-search text-3xl mb-3 block text-slate-400"></i>
                <p class="text-base font-medium">Barang tidak ditemukan</p>
                <p class="text-xs text-slate-400 mt-1">Coba masukkan kata kunci pencarian yang lain.</p>
            </div>

            @if($barangs->isEmpty())
                <div class="text-center py-10 text-slate-500">
                    <i class="bi bi-emoji-frown text-4xl mb-3 block"></i>
                    <p>Tidak ada barang yang tersedia atau stok habis.</p>
                </div>
            @endif
        </div>

        <!-- KANAN: Keranjang Belanja -->
        <div class="w-full lg:w-1/3 bg-white rounded-xl shadow-sm border border-slate-100 flex flex-col h-[calc(100vh-12rem)] min-h-[400px] lg:sticky lg:top-[5rem]">
            <div class="p-4 border-b border-slate-100 bg-slate-50 rounded-t-xl flex justify-between items-center">
                <h3 class="font-semibold text-slate-800 flex items-center">
                    <i class="bi bi-cart3 mr-2"></i> Keranjang Belanja
                </h3>
                <button type="button" id="btn-reset-cart" disabled class="text-xs text-red-500 hover:text-red-700 font-semibold flex items-center gap-1 transition-colors px-2.5 py-1.5 rounded-lg hover:bg-red-50 disabled:opacity-40 disabled:cursor-not-allowed disabled:hover:bg-transparent">
                    <i class="bi bi-arrow-counterclockwise text-sm"></i> Reset
                </button>
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
                    <input type="hidden" name="metode_pembayaran" id="input-metode-pembayaran" value="tunai">
                    <input type="hidden" name="bayar" id="input-bayar" value="">
                    <input type="hidden" name="kembalian" id="input-kembalian" value="">
                    
                    <button type="button" id="btn-proses-pembayaran" disabled class="w-full py-3 px-4 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition-colors disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                        <i class="bi bi-check-circle"></i> Proses Transaksi
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Pembayaran POS -->
    <div id="payment-modal" class="fixed inset-0 z-50 flex items-center justify-center hidden">
        <!-- Backdrop blur overlay -->
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity duration-300" id="payment-modal-overlay"></div>
        
        <!-- Modal Content Container -->
        <div class="bg-white rounded-2xl shadow-xl border border-slate-100 w-full max-w-lg mx-4 z-10 overflow-hidden flex flex-col transform scale-95 opacity-0 transition-all duration-300" id="payment-modal-content">
            <!-- Modal Header -->
            <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                    <i class="bi bi-wallet2 text-blue-600"></i> Proses Pembayaran
                </h3>
                <button type="button" class="text-slate-400 hover:text-slate-600 transition-colors p-1 rounded-lg hover:bg-slate-100" id="btn-close-payment-modal">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            
            <!-- Modal Body -->
            <div class="p-6 overflow-y-auto space-y-6">
                <!-- Order Summary -->
                <div class="bg-slate-50 p-4 rounded-xl border border-slate-100 flex justify-between items-center">
                    <span class="text-sm font-medium text-slate-600">Total Tagihan</span>
                    <span class="text-2xl font-black text-blue-600" id="modal-grand-total">Rp 0</span>
                </div>
                
                <!-- Payment Method Selector -->
                <div>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-3">Metode Pembayaran</span>
                    <div class="grid grid-cols-2 gap-4">
                        <!-- Button Tunai -->
                        <button type="button" id="tab-tunai" class="flex flex-col items-center justify-center p-4 border-2 border-blue-500 bg-blue-50/30 text-blue-600 rounded-xl font-semibold transition-all shadow-sm">
                            <i class="bi bi-cash-stack text-2xl mb-1.5"></i>
                            <span class="text-sm">Tunai / Cash</span>
                        </button>
                        <!-- Button QRIS -->
                        <button type="button" id="tab-qris" class="flex flex-col items-center justify-center p-4 border-2 border-slate-200 hover:border-slate-300 text-slate-500 rounded-xl font-semibold transition-all">
                            <i class="bi bi-qr-code-scan text-2xl mb-1.5"></i>
                            <span class="text-sm">QRIS</span>
                        </button>
                    </div>
                </div>
                
                <!-- Panel Tunai Details -->
                <div id="panel-tunai" class="space-y-4">
                    <div>
                        <label for="bayar-tunai" class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-2">Jumlah Bayar (Uang Diterima)</label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 font-semibold text-slate-400 text-sm">Rp</span>
                            <input type="text" id="bayar-tunai" placeholder="0" class="w-full pl-10 pr-4 py-3 bg-white border border-slate-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-100 text-slate-800 font-bold text-lg transition-all placeholder:text-slate-300">
                        </div>
                    </div>
                    
                    <!-- Quick Cash Buttons -->
                    <div class="flex flex-wrap gap-2" id="quick-cash-container">
                        <button type="button" class="btn-quick-cash text-xs font-semibold px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg transition-all" data-value="pas">Uang Pas</button>
                        <button type="button" class="btn-quick-cash text-xs font-semibold px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg transition-all" data-value="10000">Rp 10.000</button>
                        <button type="button" class="btn-quick-cash text-xs font-semibold px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg transition-all" data-value="20000">Rp 20.000</button>
                        <button type="button" class="btn-quick-cash text-xs font-semibold px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg transition-all" data-value="50000">Rp 50.000</button>
                        <button type="button" class="btn-quick-cash text-xs font-semibold px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg transition-all" data-value="100000">Rp 100.000</button>
                    </div>
                    
                    <!-- Kembalian Display -->
                    <div class="p-4 rounded-xl border border-slate-100 flex justify-between items-center transition-all bg-emerald-50/30 border-emerald-100 text-emerald-600" id="kembalian-alert-box">
                        <span class="text-sm font-semibold" id="kembalian-label">Kembalian</span>
                        <span class="text-xl font-bold" id="kembalian-amount">Rp 0</span>
                    </div>
                </div>
                
                <!-- Panel QRIS Details -->
                <div id="panel-qris" class="hidden flex flex-col items-center text-center space-y-4">
                    <div class="p-3 bg-white border border-slate-200 rounded-2xl shadow-sm inline-block">
                        <div class="w-48 h-48 bg-slate-50 flex flex-col items-center justify-center border border-slate-100 rounded-xl relative overflow-hidden">
                            @if(file_exists(public_path('images/qris.png')))
                                <img src="{{ asset('images/qris.png') }}" class="w-full h-full object-contain" alt="QRIS Toko Diza">
                            @elseif(file_exists(public_path('images/qris.jpg')))
                                <img src="{{ asset('images/qris.jpg') }}" class="w-full h-full object-contain" alt="QRIS Toko Diza">
                            @elseif(file_exists(public_path('images/qris.jpeg')))
                                <img src="{{ asset('images/qris.jpeg') }}" class="w-full h-full object-contain" alt="QRIS Toko Diza">
                            @else
                                <svg class="w-36 h-36 text-slate-800 animate-pulse" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M3 3h6v6H3zm2 2v2h2V5zm8 0h2v2h-2zm4 0h2v2h-2zm-8 4v2h2V9zm4 0h2v2h-2zm4 0h2v2h-2zm-8 4h2v2h-2zm4 0h2v2h-2zm4 0h2v2h-2zm-12 4h6v6H3zm2 2v2h2v-2zm8 0h2v2h-2z" />
                                    <rect x="3" y="3" width="6" height="6" fill="none" stroke="currentColor" stroke-width="1.5" />
                                    <rect x="15" y="3" width="6" height="6" fill="none" stroke="currentColor" stroke-width="1.5" />
                                    <rect x="3" y="15" width="6" height="6" fill="none" stroke="currentColor" stroke-width="1.5" />
                                </svg>
                                <div class="absolute bottom-1.5 bg-blue-600 text-white font-black text-[9px] px-2.5 py-0.5 rounded uppercase tracking-wider shadow-sm">
                                    QRIS TOKO DIZA
                                </div>
                            @endif
                        </div>
                    </div>
                    <p class="text-xs text-slate-500 max-w-sm leading-relaxed">
                        Silakan tunjukkan QR Code di atas kepada pelanggan. Setelah pembayaran berhasil diterima, klik tombol <strong>"Selesaikan Transaksi"</strong> di bawah.
                    </p>
                </div>
            </div>
            
            <!-- Modal Footer -->
            <div class="p-6 border-t border-slate-100 bg-slate-50 flex gap-3">
                <button type="button" class="flex-1 py-3 px-4 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-xl font-semibold transition-colors" id="btn-cancel-payment">
                    Batal
                </button>
                <button type="button" class="flex-1 py-3 px-4 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-semibold transition-colors flex items-center justify-center gap-2 shadow-lg shadow-blue-500/20 disabled:opacity-40 disabled:cursor-not-allowed" id="btn-complete-payment" disabled>
                    <i class="bi bi-check-circle-fill"></i> Selesaikan Transaksi
                </button>
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
            const btnSubmit = document.getElementById('btn-proses-pembayaran');
            const btnResetCart = document.getElementById('btn-reset-cart');
            
            // Modal DOM Elements
            const paymentModal = document.getElementById('payment-modal');
            const paymentModalOverlay = document.getElementById('payment-modal-overlay');
            const paymentModalContent = document.getElementById('payment-modal-content');
            const btnClosePaymentModal = document.getElementById('btn-close-payment-modal');
            const btnCancelPayment = document.getElementById('btn-cancel-payment');
            const btnCompletePayment = document.getElementById('btn-complete-payment');
            
            const modalGrandTotal = document.getElementById('modal-grand-total');
            const tabTunai = document.getElementById('tab-tunai');
            const tabQris = document.getElementById('tab-qris');
            const panelTunai = document.getElementById('panel-tunai');
            const panelQris = document.getElementById('panel-qris');
            
            const bayarTunaiInput = document.getElementById('bayar-tunai');
            const kembalianAlertBox = document.getElementById('kembalian-alert-box');
            const kembalianAmount = document.getElementById('kembalian-amount');
            const kembalianLabel = document.getElementById('kembalian-label');
            
            const inputMetodePembayaran = document.getElementById('input-metode-pembayaran');
            const inputBayar = document.getElementById('input-bayar');
            const inputKembalian = document.getElementById('input-kembalian');
            const formKasir = document.getElementById('form-kasir');
            
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
                    if (btnResetCart) btnResetCart.disabled = true;
                } else {
                    cartEmpty.style.display = 'none';
                    btnSubmit.disabled = false;
                    if (btnResetCart) btnResetCart.disabled = false;
                    
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

            // Client-side live search filtering
            const searchInput = document.getElementById('search-kasir');
            const noResultsEl = document.getElementById('no-results-msg');
            const cards = document.querySelectorAll('[id^="card-"]');

            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const query = this.value.toLowerCase().trim();
                    let visibleCount = 0;
                    
                    cards.forEach(card => {
                        const name = card.querySelector('.font-medium').textContent.toLowerCase();
                        const descEl = card.querySelector('.text-\\[10px\\]');
                        const desc = descEl ? descEl.textContent.toLowerCase() : '';
                        
                        if (name.includes(query) || desc.includes(query)) {
                            card.style.display = 'flex';
                            visibleCount++;
                        } else {
                            card.style.display = 'none';
                        }
                    });

                    if (visibleCount === 0 && cards.length > 0) {
                        noResultsEl.classList.remove('hidden');
                    } else {
                        noResultsEl.classList.add('hidden');
                    }
                });
            }

            // Reset Keranjang
            if (btnResetCart) {
                btnResetCart.addEventListener('click', function() {
                    if (cart.length === 0) return;
                    
                    Swal.fire({
                        title: 'Kosongkan Keranjang?',
                        text: 'Semua barang pilihan di keranjang akan dihapus.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ef4444',
                        cancelButtonColor: '#64748b',
                        confirmButtonText: 'Ya, Kosongkan!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Reset qty visual di card
                            cart.forEach(item => {
                                const qtyEl = document.getElementById('qty-' + item.id);
                                if (qtyEl) {
                                    qtyEl.textContent = '0';
                                }
                            });
                            
                            // Kosongkan array cart
                            cart = [];
                            renderCart();
                            
                            Swal.fire({
                                icon: 'success',
                                title: 'Keranjang Dikosongkan',
                                showConfirmButton: false,
                                timer: 1000
                            });
                        }
                    });
                });
            }

            // Hitung total belanja saat ini
            const getGrandTotal = () => {
                return cart.reduce((sum, item) => sum + (item.qty * item.harga), 0);
            };

            // Buka Modal Pembayaran
            if (btnSubmit) {
                btnSubmit.addEventListener('click', function() {
                    if (cart.length === 0) return;
                    
                    const total = getGrandTotal();
                    modalGrandTotal.textContent = formatRupiah(total);
                    
                    // Default Tab ke Tunai
                    selectTab('tunai');
                    
                    // Kosongkan kolom bayar dan hitung ulang kembalian
                    bayarTunaiInput.value = '';
                    updateKembalian();
                    
                    // Show modal dengan transisi mulus
                    paymentModal.classList.remove('hidden');
                    setTimeout(() => {
                        paymentModalContent.classList.remove('scale-95', 'opacity-0');
                        paymentModalContent.classList.add('scale-100', 'opacity-100');
                    }, 50);
                });
            }

            // Tutup Modal Pembayaran
            const closeModal = () => {
                paymentModalContent.classList.remove('scale-100', 'opacity-100');
                paymentModalContent.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    paymentModal.classList.add('hidden');
                }, 300);
            };
            
            if (btnClosePaymentModal) btnClosePaymentModal.addEventListener('click', closeModal);
            if (btnCancelPayment) btnCancelPayment.addEventListener('click', closeModal);
            if (paymentModalOverlay) paymentModalOverlay.addEventListener('click', closeModal);

            // Ganti Tab Pembayaran (Tunai vs QRIS)
            let selectedMethod = 'tunai';
            
            const selectTab = (method) => {
                selectedMethod = method;
                inputMetodePembayaran.value = method;
                
                if (method === 'tunai') {
                    // Gaya Tab Aktif (Tunai)
                    tabTunai.className = "flex flex-col items-center justify-center p-4 border-2 border-blue-500 bg-blue-50/30 text-blue-600 rounded-xl font-semibold transition-all shadow-sm";
                    tabQris.className = "flex flex-col items-center justify-center p-4 border-2 border-slate-200 hover:border-slate-300 text-slate-500 rounded-xl font-semibold transition-all";
                    
                    // Tampilkan panel tunai, sembunyikan QRIS
                    panelTunai.classList.remove('hidden');
                    panelQris.classList.add('hidden');
                    
                    updateKembalian();
                } else {
                    // Gaya Tab Aktif (QRIS)
                    tabQris.className = "flex flex-col items-center justify-center p-4 border-2 border-blue-500 bg-blue-50/30 text-blue-600 rounded-xl font-semibold transition-all shadow-sm";
                    tabTunai.className = "flex flex-col items-center justify-center p-4 border-2 border-slate-200 hover:border-slate-300 text-slate-500 rounded-xl font-semibold transition-all";
                    
                    // Tampilkan panel QRIS, sembunyikan tunai
                    panelQris.classList.remove('hidden');
                    panelTunai.classList.add('hidden');
                    
                    // QRIS otomatis siap diselesaikan
                    btnCompletePayment.disabled = false;
                }
            };
            
            if (tabTunai) tabTunai.addEventListener('click', () => selectTab('tunai'));
            if (tabQris) tabQris.addEventListener('click', () => selectTab('qris'));

            // Kalkulasi Kembalian & Formating Tunai
            const updateKembalian = () => {
                if (selectedMethod !== 'tunai') return;
                
                const total = getGrandTotal();
                const rawBayar = bayarTunaiInput.value.replace(/[^0-9]/g, '');
                const bayar = rawBayar ? parseInt(rawBayar) : 0;
                
                // Format rupiah saat mengetik
                if (rawBayar) {
                    bayarTunaiInput.value = new Intl.NumberFormat('id-ID').format(bayar);
                } else {
                    bayarTunaiInput.value = '';
                }
                
                const kembalian = bayar - total;
                
                if (bayar < total || !rawBayar) {
                    // Uang kurang
                    kembalianAlertBox.className = "p-4 rounded-xl border border-slate-100 flex justify-between items-center transition-all bg-red-50 border-red-100 text-red-600";
                    kembalianLabel.textContent = "Kekurangan";
                    kembalianAmount.textContent = formatRupiah(Math.abs(kembalian));
                    btnCompletePayment.disabled = true;
                    
                    inputBayar.value = "";
                    inputKembalian.value = "";
                } else {
                    // Uang cukup
                    kembalianAlertBox.className = "p-4 rounded-xl border border-slate-100 flex justify-between items-center transition-all bg-emerald-50/30 border-emerald-100 text-emerald-600";
                    kembalianLabel.textContent = "Kembalian";
                    kembalianAmount.textContent = formatRupiah(kembalian);
                    btnCompletePayment.disabled = false;
                    
                    inputBayar.value = bayar;
                    inputKembalian.value = kembalian;
                }
            };
            
            if (bayarTunaiInput) {
                bayarTunaiInput.addEventListener('input', updateKembalian);
            }

            // Tombol Denominasi Uang Cepat (Quick Cash)
            const quickCashButtons = document.querySelectorAll('.btn-quick-cash');
            quickCashButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    const value = this.getAttribute('data-value');
                    const total = getGrandTotal();
                    
                    if (value === 'pas') {
                        bayarTunaiInput.value = total.toString();
                    } else {
                        bayarTunaiInput.value = value;
                    }
                    
                    updateKembalian();
                });
            });

            // Selesaikan Transaksi (Form Submit)
            if (btnCompletePayment) {
                btnCompletePayment.addEventListener('click', function() {
                    this.disabled = true;
                    this.innerHTML = '<i class="bi bi-arrow-repeat animate-spin"></i> Menyimpan...';
                    
                    if (formKasir) {
                        formKasir.submit();
                    }
                });
            }
        });
    </script>
</x-app-layout>
