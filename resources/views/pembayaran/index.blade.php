@extends('layouts.app')

@section('title', 'Pembayaran & Pesanan - Toko Plastik Diza')

@section('content')
<div class="mb-4">
    <h1 class="h2">Pembayaran & Pesanan Pelanggan</h1>
    <p class="text-muted">Kelola pesanan dan pembayaran dari pelanggan</p>
</div>

<!-- Info Alert -->
<div class="row mb-4">
    <div class="col-12">
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <strong>ℹ️ Informasi:</strong> Pelanggan membuat pesanan melalui WhatsApp atau kontak langsung. 
            Catat pesanan dan konfirmasi pembayaran di sini.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
</div>

<!-- Tombol Tambah Pesanan -->
<div class="row mb-4">
    <div class="col-12">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahPesanan">
            <i class="fas fa-plus"></i> Tambah Pesanan Baru
        </button>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalTambahPembayaran">
            <i class="fas fa-check"></i> Konfirmasi Pembayaran
        </button>
    </div>
</div>

<!-- Tabel Pesanan -->
<div class="row mb-5">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light">
                <h5 class="mb-0">📋 Daftar Pesanan Masuk</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>No. Pesanan</th>
                                <th>Nama Pelanggan</th>
                                <th>Produk</th>
                                <th>Jumlah</th>
                                <th>Total Harga</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>PSN001</td>
                                <td>Budi Santoso</td>
                                <td>Kantong Plastik Tebal 25x35</td>
                                <td>10 pack</td>
                                <td>Rp 150.000</td>
                                <td>14-04-2026</td>
                                <td><span class="badge bg-warning text-dark">Menunggu Pembayaran</span></td>
                                <td>
                                    <button class="btn btn-sm btn-info" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-success" title="Konfirmasi Pembayaran">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>PSN002</td>
                                <td>Siti Nurhaliza</td>
                                <td>Gelas Plastik 300ml</td>
                                <td>20 pack</td>
                                <td>Rp 100.000</td>
                                <td>14-04-2026</td>
                                <td><span class="badge bg-success">Pembayaran Diterima</span></td>
                                <td>
                                    <button class="btn btn-sm btn-info" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>PSN003</td>
                                <td>Ahmad Wijaya</td>
                                <td>Wadah Plastik Kotak</td>
                                <td>5 pcs</td>
                                <td>Rp 15.000</td>
                                <td>13-04-2026</td>
                                <td><span class="badge bg-danger">Pembayaran Ditolak</span></td>
                                <td>
                                    <button class="btn btn-sm btn-info" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistik Pembayaran -->
<div class="row">
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="card-title text-muted mb-0">Total Pesanan</h6>
                        <h2 class="text-primary mb-0">3</h2>
                    </div>
                    <div class="fs-1 text-primary opacity-50">📦</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="card-title text-muted mb-0">Menunggu Pembayaran</h6>
                        <h2 class="text-warning mb-0">1</h2>
                    </div>
                    <div class="fs-1 text-warning opacity-50">⏳</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="card-title text-muted mb-0">Terbayar</h6>
                        <h2 class="text-success mb-0">1</h2>
                    </div>
                    <div class="fs-1 text-success opacity-50">✓</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Pesanan -->
<div class="modal fade" id="modalTambahPesanan" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Pesanan Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label">Nama Pelanggan</label>
                        <input type="text" class="form-control" placeholder="Nama pelanggan" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nomor WhatsApp</label>
                        <input type="text" class="form-control" placeholder="08xx xxxx xxxx" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Produk</label>
                        <select class="form-select" required>
                            <option value="">-- Pilih Produk --</option>
                            <option>Kantong Plastik Tebal 25x35</option>
                            <option>Gelas Plastik 300ml</option>
                            <option>Wadah Plastik Kotak</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumlah</label>
                        <input type="number" class="form-control" placeholder="Jumlah pesanan" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary">Simpan Pesanan</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Pembayaran -->
<div class="modal fade" id="modalTambahPembayaran" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label">Pilih Pesanan</label>
                        <select class="form-select" required>
                            <option value="">-- Pilih Pesanan --</option>
                            <option>PSN001 - Budi Santoso (Rp 150.000)</option>
                            <option>PSN003 - Ahmad Wijaya (Rp 15.000)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Metode Pembayaran</label>
                        <select class="form-select" required>
                            <option value="">-- Pilih Metode --</option>
                            <option>Transfer Bank</option>
                            <option>Cash / Tunai</option>
                            <option>E-Wallet</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Pembayaran</label>
                        <input type="date" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Catatan</label>
                        <textarea class="form-control" rows="3" placeholder="Catatan pembayaran..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-success">Konfirmasi Pembayaran</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endpush

@endsection
