@extends('layouts.pelanggan')

@section('title', 'Katalog - Toko Plastik Diza')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <span class="badge bg-light text-primary mb-3">Toko Plastik Terpercaya</span>
                <h1 class="display-4 fw-bold text-white mb-3">Toko Plastik Diza</h1>
                <p class="lead text-white-50 mb-4">
                    Plastik, masker, minyak, bumbu, dan kebutuhan harian tersedia lengkap.
                    Hubungi kami untuk pemesanan via WhatsApp.
                </p>
                <a href="https://wa.me/6281200000000" target="_blank" class="btn btn-light btn-lg">
                    <i class="fab fa-whatsapp me-2"></i>Pesan Sekarang
                </a>
            </div>
            <div class="col-lg-4 text-center">
                <i class="fas fa-store hero-icon"></i>
            </div>
        </div>
    </div>
</section>

<!-- Katalog Section -->
<div class="container mb-5">
    <!-- Filter Kategori -->
    <div class="row mb-4">
        <div class="col-12">
            <h3 class="mb-3">Katalog Produk</h3>
            <div class="d-flex flex-wrap gap-2" id="kategoriFilter">
                <button class="btn btn-outline-primary active" onclick="filterKategori('semua', this)">Semua</button>
                @foreach($kategoris as $kategori)
                    <button class="btn btn-outline-primary" onclick="filterKategori('{{ $kategori->id_kategori }}', this)">
                        {{ $kategori->nama_kategori }}
                    </button>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Grid Produk -->
    <div class="row g-4" id="produkGrid">
        @forelse($barangs as $barang)
            <div class="col-lg-3 col-md-4 col-sm-6 barang-item" data-kategori="{{ $barang->id_kategori }}">
                <div class="card barang-card h-100">
                    <div class="card-body d-flex flex-column">
                        <div class="text-center mb-3">
                            <i class="fas fa-box-open fa-3x text-primary"></i>
                        </div>
                        <h5 class="card-title text-center">{{ $barang->nama_barang }}</h5>
                        <p class="card-text text-muted small text-center mb-2">
                            {{ $barang->kategori->nama_kategori ?? 'Tidak ada kategori' }}
                        </p>
                        <div class="mt-auto">
                            <div class="row text-center mb-3">
                                <div class="col-6">
                                    <small class="text-muted d-block">Harga</small>
                                    <span class="harga-text">Rp {{ number_format($barang->harga, 0, ',', '.') }}</span>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted d-block">Stok</small>
                                    <span class="badge {{ $barang->stok > 0 ? 'bg-success' : 'bg-danger' }}">
                                        {{ $barang->stok }} {{ $barang->satuan }}
                                    </span>
                                </div>
                            </div>
                            @if($barang->stok > 0)
                                <a href="https://wa.me/6281200000000?text={{ urlencode('Halo Toko Plastik Diza, saya ingin memesan: ' . $barang->nama_barang) }}"
                                   target="_blank"
                                   class="btn btn-primary w-100">
                                    <i class="fab fa-whatsapp me-1"></i>Pesan via WA
                                </a>
                            @else
                                <button class="btn btn-secondary w-100" disabled>
                                    <i class="fas fa-times me-1"></i>Stok Habis
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle fa-3x mb-3 text-info"></i>
                    <h4>Belum ada barang tersedia</h4>
                    <p>Saat ini belum ada barang yang terdaftar di katalog.</p>
                </div>
            </div>
        @endforelse
    </div>
</div>

<!-- Info Toko Section -->
<section class="bg-light py-5">
    <div class="container">
        <h3 class="text-center mb-4">Informasi Toko</h3>
        <div class="row g-4">
            <div class="col-md-3 col-sm-6">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center">
                        <i class="fas fa-map-marker-alt fa-2x text-primary mb-3"></i>
                        <h6>Alamat</h6>
                        <p class="text-muted small">Bekasi, Jawa Barat</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center">
                        <i class="fas fa-clock fa-2x text-primary mb-3"></i>
                        <h6>Jam Buka</h6>
                        <p class="text-muted small">Senin – Sabtu<br>07.00 – 17.00 WIB</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center">
                        <i class="fab fa-whatsapp fa-2x text-success mb-3"></i>
                        <h6>WhatsApp</h6>
                        <p class="text-muted small">+62 812-xxxx-xxxx</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center">
                        <i class="fas fa-shopping-cart fa-2x text-primary mb-3"></i>
                        <h6>Cara Pesan</h6>
                        <p class="text-muted small">Hubungi via WA, sebutkan nama & jumlah barang</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
function filterKategori(kategoriId, button) {
    // Update active button
    document.querySelectorAll('#kategoriFilter .btn').forEach(btn => {
        btn.classList.remove('active');
        btn.classList.remove('btn-primary');
        btn.classList.add('btn-outline-primary');
    });
    button.classList.add('active');
    button.classList.remove('btn-outline-primary');
    button.classList.add('btn-primary');

    // Filter products
    const produkItems = document.querySelectorAll('.barang-item');
    produkItems.forEach(item => {
        if (kategoriId === 'semua' || item.dataset.kategori === kategoriId) {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    });
}
</script>
@endpush
@endsection