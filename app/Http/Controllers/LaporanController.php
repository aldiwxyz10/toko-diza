<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function stok(Request $request)
    {
        $query = Barang::query();

        if ($request->filled('jenis'))  $query->where('jenis', $request->jenis);

        if ($request->filled('status')) {
            match ($request->status) {
                'habis'    => $query->where('stok', 0),
                'menipis'  => $query->where('stok', '>', 0)->where('stok', '<=', 5),
                'tersedia' => $query->where('stok', '>', 5),
                default    => null,
            };
        }

        $barangs    = $query->orderBy('nama_barang')->get();
        $jenis      = Barang::distinct()->pluck('jenis');
        $totalNilai = $barangs->sum(fn($b) => $b->stok * $b->harga);

        // Chart 1: Stok per Barang
        $chartLabels = $barangs->pluck('nama_barang');
        $chartData   = $barangs->pluck('stok');

        // Chart 2: Tren Barang Masuk (Line Chart)
        $barangMasukTrend = BarangMasuk::selectRaw('tanggal, SUM(jumlah) as total')
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'asc')
            ->take(30)
            ->get();
        $masukLabels = $barangMasukTrend->map(fn($item) => $item->tanggal ? $item->tanggal->format('d M Y') : '');
        $masukData = $barangMasukTrend->pluck('total');

        // Chart 3: Tren Barang Keluar (Line Chart)
        $barangKeluarTrend = BarangKeluar::selectRaw('tanggal, SUM(jumlah) as total')
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'asc')
            ->take(30)
            ->get();
        $keluarLabels = $barangKeluarTrend->map(fn($item) => $item->tanggal ? $item->tanggal->format('d M Y') : '');
        $keluarData = $barangKeluarTrend->pluck('total');

        // Chart 4: Status Ketersediaan
        $statusCounts = [
            'Tersedia (> 5)' => $barangs->filter(fn($b) => $b->stok > 5)->count(),
            'Menipis (1 - 5)' => $barangs->filter(fn($b) => $b->stok > 0 && $b->stok <= 5)->count(),
            'Habis (0)' => $barangs->filter(fn($b) => $b->stok == 0)->count(),
        ];
        $statusKetersediaanLabels = array_keys($statusCounts);
        $statusKetersediaanData = array_values($statusCounts);

        return view('laporan.stok', compact(
            'barangs', 'jenis', 'totalNilai', 
            'chartLabels', 'chartData',
            'masukLabels', 'masukData',
            'keluarLabels', 'keluarData',
            'statusKetersediaanLabels', 'statusKetersediaanData'
        ));
    }

    public function masuk(Request $request)
    {
        $query = BarangMasuk::with('barang');
        $this->applyDateFilter($query, $request);
        if ($request->filled('barang_id')) $query->where('barang_id', $request->barang_id);

        $barangMasuks = $query->latest('tanggal')->get();
        $totalJumlah  = $barangMasuks->sum('jumlah');
        $barangs      = Barang::orderBy('nama_barang')->get();

        return view('laporan.masuk', compact('barangMasuks', 'totalJumlah', 'barangs'));
    }

    public function keluar(Request $request)
    {
        $query = BarangKeluar::with('barang');
        $this->applyDateFilter($query, $request);
        if ($request->filled('barang_id')) $query->where('barang_id', $request->barang_id);

        $barangKeluars = $query->latest('tanggal')->get();
        $totalJumlah   = $barangKeluars->sum('jumlah');
        $barangs       = Barang::orderBy('nama_barang')->get();

        return view('laporan.keluar', compact('barangKeluars', 'totalJumlah', 'barangs'));
    }

    private function applyDateFilter($query, Request $request): void
    {
        if ($request->filled('tanggal_dari'))   $query->whereDate('tanggal', '>=', $request->tanggal_dari);
        if ($request->filled('tanggal_sampai')) $query->whereDate('tanggal', '<=', $request->tanggal_sampai);
    }
}
