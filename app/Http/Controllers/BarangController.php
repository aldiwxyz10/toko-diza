<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $query = Barang::query();

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn($q) => $q->where('nama_barang', 'like', "%$s%")
                                      ->orWhere('kode_barang', 'like', "%$s%")
                                      ->orWhere('jenis', 'like', "%$s%"));
        }

        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        $barangs = $query->orderBy('nama_barang')->paginate(10)->withQueryString();
        $jenis   = Barang::distinct()->pluck('jenis');

        return view('barang.index', compact('barangs', 'jenis'));
    }

    public function create()
    {
        return view('barang.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_barang' => 'required|string|max:50|unique:barangs,kode_barang',
            'nama_barang' => 'required|string|max:100',
            'jenis'       => 'required|string|max:50',
            'stok'        => 'required|integer|min:0',
            'harga'       => 'required|numeric|min:0',
        ]);

        Barang::create($validated);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function show(Barang $barang)
    {
        $barang->load([
            'barangMasuks'  => fn($q) => $q->latest()->limit(5),
            'barangKeluars' => fn($q) => $q->latest()->limit(5),
        ]);

        return view('barang.show', compact('barang'));
    }

    public function edit(Barang $barang)
    {
        return view('barang.edit', compact('barang'));
    }

    public function update(Request $request, Barang $barang)
    {
        $validated = $request->validate([
            'kode_barang' => "required|string|max:50|unique:barangs,kode_barang,{$barang->id}",
            'nama_barang' => 'required|string|max:100',
            'jenis'       => 'required|string|max:50',
            'stok'        => 'required|integer|min:0',
            'harga'       => 'required|numeric|min:0',
        ]);

        $barang->update($validated);

        return redirect()->route('barang.index')->with('success', 'Data barang berhasil diperbarui.');
    }

    public function destroy(Barang $barang)
    {
        $barang->delete();

        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus.');
    }
}