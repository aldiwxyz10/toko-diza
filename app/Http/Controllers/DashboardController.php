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
        $totalBarang = Barang::count();
        $totalKategori = Kategori::count();
        $totalStok = Barang::sum('stok');
        $transaksiHariIni = StokMasuk::whereDate('tanggal', today())->count() + 
                            StokKeluar::whereDate('tanggal', today())->count();

        return view('dashboard', compact('totalBarang', 'totalKategori', 'totalStok', 'transaksiHariIni'));
    }
}
