<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $activeTab = $request->input('tab', 'stok');

        // --- 1. DATA STOK BARANG & CHART ---
        $stokQuery = Barang::query();
        if ($request->filled('stok_jenis')) {
            $stokQuery->where('jenis', $request->stok_jenis);
        }
        if ($request->filled('stok_status')) {
            match ($request->stok_status) {
                'habis'    => $stokQuery->where('stok', 0),
                'menipis'  => $stokQuery->where('stok', '>', 0)->where('stok', '<=', 5),
                'tersedia' => $stokQuery->where('stok', '>', 5),
                default    => null,
            };
        }

        $barangs = $stokQuery->orderBy('nama_barang')->get();
        $jenisList = Barang::distinct()->pluck('jenis');
        $totalNilai = $barangs->sum(fn($b) => $b->stok * $b->harga);

        // Chart 1: Stok per Barang
        $chartLabels = $barangs->pluck('nama_barang');
        $chartData   = $barangs->pluck('stok');

        // Chart 2: Tren Barang Masuk (Line Chart - 30 hari terakhir)
        $barangMasukTrend = BarangMasuk::selectRaw('tanggal, SUM(jumlah) as total')
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'asc')
            ->take(30)
            ->get();
        $masukLabels = $barangMasukTrend->map(fn($item) => $item->tanggal ? $item->tanggal->format('d M Y') : '');
        $masukData = $barangMasukTrend->pluck('total');

        // Chart 3: Tren Barang Keluar (Line Chart - 30 hari terakhir)
        $barangKeluarTrend = BarangKeluar::selectRaw('tanggal, SUM(jumlah) as total')
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'asc')
            ->take(30)
            ->get();
        $keluarLabels = $barangKeluarTrend->map(fn($item) => $item->tanggal ? $item->tanggal->format('d M Y') : '');
        $keluarData = $barangKeluarTrend->pluck('total');

        // Chart 4: Status Ketersediaan
        $allBarangs = Barang::all();
        $statusCounts = [
            'Tersedia (> 5)' => $allBarangs->filter(fn($b) => $b->stok > 5)->count(),
            'Menipis (1 - 5)' => $allBarangs->filter(fn($b) => $b->stok > 0 && $b->stok <= 5)->count(),
            'Habis (0)' => $allBarangs->filter(fn($b) => $b->stok == 0)->count(),
        ];
        $statusKetersediaanLabels = array_keys($statusCounts);
        $statusKetersediaanData = array_values($statusCounts);


        // --- 2. DATA BARANG MASUK ---
        $masukQuery = BarangMasuk::with('barang');
        $this->applyDateFilter($masukQuery, $request);
        if ($request->filled('masuk_barang_id')) {
            $masukQuery->where('barang_id', $request->masuk_barang_id);
        }
        $barangMasuks = $masukQuery->latest('tanggal')->get();
        $totalJumlahMasuk = $barangMasuks->sum('jumlah');


        // --- 3. DATA BARANG KELUAR ---
        $keluarQuery = BarangKeluar::with('barang');
        $this->applyDateFilter($keluarQuery, $request);
        if ($request->filled('keluar_barang_id')) {
            $keluarQuery->where('barang_id', $request->keluar_barang_id);
        }
        $barangKeluars = $keluarQuery->latest('tanggal')->get();
        $totalJumlahKeluar = $barangKeluars->sum('jumlah');

        // List semua barang untuk pilihan dropdown filter
        $allBarangsList = Barang::orderBy('nama_barang')->get();

        return view('laporan.index', compact(
            'activeTab',
            'barangs', 'jenisList', 'totalNilai', 'allBarangsList',
            'chartLabels', 'chartData',
            'masukLabels', 'masukData',
            'keluarLabels', 'keluarData',
            'statusKetersediaanLabels', 'statusKetersediaanData',
            'barangMasuks', 'totalJumlahMasuk',
            'barangKeluars', 'totalJumlahKeluar'
        ));
    }

    private function applyDateFilter($query, Request $request): void
    {
        if ($request->filled('tanggal_dari'))   $query->whereDate('tanggal', '>=', $request->tanggal_dari);
        if ($request->filled('tanggal_sampai')) $query->whereDate('tanggal', '<=', $request->tanggal_sampai);
    }
}
