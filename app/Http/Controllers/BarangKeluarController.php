<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangKeluarController extends Controller
{
    public function index(Request $request)
    {
        $query = BarangKeluar::with('barang');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->whereHas('barang', fn($q) => $q->where('nama_barang', 'like', "%$s%")
                                                    ->orWhere('kode_barang', 'like', "%$s%"));
        }

        if ($request->filled('tanggal_dari'))   $query->whereDate('tanggal', '>=', $request->tanggal_dari);
        if ($request->filled('tanggal_sampai')) $query->whereDate('tanggal', '<=', $request->tanggal_sampai);

        $barangKeluars = $query->latest('tanggal')->paginate(10)->withQueryString();

        return view('barang-keluar.index', compact('barangKeluars'));
    }

    public function create()
    {
        $barangs = Barang::where('stok', '>', 0)->orderBy('nama_barang')->get();

        return view('barang-keluar.create', compact('barangs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'barang_id'  => 'required|exists:barangs,id',
            'jumlah'     => 'required|integer|min:1',
            'tanggal'    => 'required|date',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $barang = Barang::findOrFail($validated['barang_id']);

        if ($barang->stok < $validated['jumlah']) {
            return back()->withErrors([
                'jumlah' => "Stok tidak mencukupi. Stok saat ini: {$barang->stok}.",
            ])->withInput();
        }

        DB::transaction(function () use ($validated) {
            BarangKeluar::create($validated);
            Barang::find($validated['barang_id'])->decrement('stok', $validated['jumlah']);
        });

        return redirect()->route('barang-keluar.index')
                         ->with('success', 'Barang keluar dicatat. Stok otomatis berkurang.');
    }

    public function show(BarangKeluar $barangKeluar)
    {
        return view('barang-keluar.show', compact('barangKeluar'));
    }

    public function destroy(BarangKeluar $barangKeluar)
    {
        DB::transaction(function () use ($barangKeluar) {
            $barangKeluar->barang->increment('stok', $barangKeluar->jumlah);
            $barangKeluar->delete();
        });

        return redirect()->route('barang-keluar.index')
                         ->with('success', 'Data dihapus, stok dikembalikan.');
    }
}
