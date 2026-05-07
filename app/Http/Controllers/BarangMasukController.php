<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangMasukController extends Controller
{
    public function index(Request $request)
    {
        $query = BarangMasuk::with('barang');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->whereHas('barang', fn($q) => $q->where('nama_barang', 'like', "%$s%")
                                                    ->orWhere('kode_barang', 'like', "%$s%"));
        }

        if ($request->filled('tanggal_dari'))   $query->whereDate('tanggal', '>=', $request->tanggal_dari);
        if ($request->filled('tanggal_sampai')) $query->whereDate('tanggal', '<=', $request->tanggal_sampai);

        $barangMasuks = $query->latest('tanggal')->paginate(10)->withQueryString();

        return view('barang-masuk.index', compact('barangMasuks'));
    }

    public function create()
    {
        $barangs = Barang::orderBy('nama_barang')->get();

        return view('barang-masuk.create', compact('barangs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'barang_id'  => 'required|exists:barangs,id',
            'jumlah'     => 'required|integer|min:1',
            'tanggal'    => 'required|date',
            'keterangan' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($validated) {
            BarangMasuk::create($validated);
            
            $barang = Barang::find($validated['barang_id']);
            $barang->increment('stok', $validated['jumlah']);
        });

        return redirect()->route('barang-masuk.index')
                         ->with('success', 'Barang masuk dicatat. Stok otomatis bertambah.');
    }

    public function show(BarangMasuk $barangMasuk)
    {
        return view('barang-masuk.show', compact('barangMasuk'));
    }

    public function destroy(BarangMasuk $barangMasuk)
    {
        DB::transaction(function () use ($barangMasuk) {
            $barangMasuk->barang->decrement('stok', $barangMasuk->jumlah);
            $barangMasuk->delete();
        });

        return redirect()->route('barang-masuk.index')
                         ->with('success', 'Data dihapus, stok dikurangi kembali.');
    }
}
