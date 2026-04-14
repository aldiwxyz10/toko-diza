<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    /**
     * Display katalog produk untuk pelanggan
     */
    public function katalog()
    {
        $barangs = Barang::with('kategori')->where('stok', '>', 0)->get();
        $kategoris = Kategori::all();

        return view('pelanggan', compact('barangs', 'kategoris'));
    }

    /**
     * Display detail produk (optional)
     */
    public function detail(Barang $barang)
    {
        $barang->load('kategori');
        return view('pelanggan-detail', compact('barang'));
    }
}