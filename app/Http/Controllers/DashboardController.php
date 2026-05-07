<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use App\Models\RequestStock;
use App\Models\User;

class DashboardController extends Controller
{
    public function admin()
    {
        $totalBarang    = Barang::count();
        $totalStok      = Barang::sum('stok');
        $barangHabis    = Barang::where('stok', 0)->count();
        $barangMenipis  = Barang::where('stok', '>', 0)->where('stok', '<=', 5)->count();
        $totalUser      = User::where('role', 'user')->count();
        $requestPending = RequestStock::where('status', 'pending')->count();

        $masukBulanIni  = BarangMasuk::whereMonth('tanggal', now()->month)
                                      ->whereYear('tanggal', now()->year)->sum('jumlah');
        $keluarBulanIni = BarangKeluar::whereMonth('tanggal', now()->month)
                                       ->whereYear('tanggal', now()->year)->sum('jumlah');

        $barangKritis   = Barang::where('stok', '<=', 5)->orderBy('stok')->limit(5)->get();
        $requestTerbaru = RequestStock::with(['barang', 'user'])->latest()->limit(5)->get();

        return view('dashboard.admin', compact(
            'totalBarang', 'totalStok', 'barangHabis', 'barangMenipis',
            'totalUser', 'requestPending', 'masukBulanIni', 'keluarBulanIni',
            'barangKritis', 'requestTerbaru'
        ));
    }

    public function user()
    {
        $barangHabis   = Barang::where('stok', 0)->count();
        $barangMenipis = Barang::where('stok', '>', 0)->where('stok', '<=', 5)->count();
        $totalBarang   = Barang::count();
        $myRequests    = RequestStock::where('user_id', auth()->id())->with('barang')->latest()->limit(5)->get();
        $myPending     = RequestStock::where('user_id', auth()->id())->where('status', 'pending')->count();
        $myDisetujui   = RequestStock::where('user_id', auth()->id())->where('status', 'disetujui')->count();
        $barangKritis  = Barang::where('stok', '<=', 5)->orderBy('stok')->get();

        return view('dashboard.user', compact(
            'barangHabis', 'barangMenipis', 'totalBarang',
            'myRequests', 'myPending', 'myDisetujui', 'barangKritis'
        ));
    }
}
