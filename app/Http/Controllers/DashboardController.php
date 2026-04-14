<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\StokMasuk;
use App\Models\StokKeluar;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index()
    {
        // Statistik Umum
        $totalBarang = Barang::count();
        $totalKategori = Kategori::count();
        $totalStok = Barang::sum('stok');
        $stokHabis = Barang::where('stok', '<=', 0)->count();
        $stokMenipis = Barang::where('stok', '>', 0)->where('stok', '<', 10)->count();

        // Daftar barang dengan stok rendah (< 10)
        $barangStokRendah = Barang::where('stok', '<', 10)
            ->with('kategori')
            ->orderBy('stok', 'asc')
            ->get();

        // Daftar semua barang untuk monitoring
        $semuaBarang = Barang::with('kategori')->orderBy('nama_barang')->get();

        return view('dashboard', compact(
            'totalBarang',
            'totalKategori',
            'totalStok',
            'stokHabis',
            'stokMenipis',
            'barangStokRendah',
            'semuaBarang'
        ));
    }
}
