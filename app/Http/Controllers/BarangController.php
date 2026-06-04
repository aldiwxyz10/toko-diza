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

        // Sorting Logic
        $sort = $request->query('sort', 'terbaru');
        switch ($sort) {
            case 'kode_asc':
                $query->orderBy('kode_barang', 'asc');
                break;
            case 'kode_desc':
                $query->orderBy('kode_barang', 'desc');
                break;
            case 'nama_asc':
                $query->orderBy('nama_barang', 'asc');
                break;
            case 'nama_desc':
                $query->orderBy('nama_barang', 'desc');
                break;
            case 'stok_asc':
                $query->orderBy('stok', 'asc');
                break;
            case 'stok_desc':
                $query->orderBy('stok', 'desc');
                break;
            case 'terbaru':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $barangs = $query->paginate(10)->withQueryString();
        $jenis   = Barang::distinct()->pluck('jenis');

        return view('barang.index', compact('barangs', 'jenis'));
    }

    public function create()
    {
        return view('barang.create');
    }

    public function getNextCode(Request $request)
    {
        $jenis = $request->query('jenis');

        $prefixes = [
            'Plastik' => 'PLK',
            'Bahan Kue & Makanan' => 'BHK',
            'Wadah Makanan' => 'WDM',
            'Peralatan Konsumsi' => 'PAM',
            'Tali & Packing' => 'TLP',
            'Kebutuhan Harian' => 'KBH',
        ];

        $prefix = $prefixes[$jenis] ?? 'BRG';

        $latest = Barang::where('kode_barang', 'like', "$prefix-%")->latest('id')->first();

        if (!$latest) {
            $nextCode = $prefix . '-001';
        } else {
            $string = preg_replace("/[^0-9]/", "", $latest->kode_barang);
            if (empty($string)) {
                $nextCode = $prefix . '-001';
            } else {
                $number = intval($string) + 1;
                $nextCode = $prefix . '-' . str_pad($number, 3, '0', STR_PAD_LEFT);
            }
        }

        return response()->json(['next_code' => $nextCode]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_barang' => 'required|string|max:50|unique:barangs,kode_barang',
            'nama_barang' => 'required|string|max:100',
            'jenis'       => 'required|string|max:50',
            'stok'        => 'required|integer|min:0',
            'harga'       => 'required|numeric|min:0',
            'deskripsi'   => 'nullable|string',
        ]);

        $barang = Barang::create($validated);

        if ($barang->stok > 0) {
            \App\Models\BarangMasuk::create([
                'barang_id' => $barang->id,
                'jumlah' => $barang->stok,
                'tanggal' => now(),
                'keterangan' => 'Stok Awal (Master Data)',
            ]);
        }

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
            'deskripsi'   => 'nullable|string',
        ]);

        $selisih = $validated['stok'] - $barang->stok;
        
        $barang->update($validated);

        if ($selisih > 0) {
            \App\Models\BarangMasuk::create([
                'barang_id' => $barang->id,
                'jumlah' => $selisih,
                'tanggal' => now(),
                'keterangan' => 'Penyesuaian Stok (Edit Master)',
            ]);
        } elseif ($selisih < 0) {
            \App\Models\BarangKeluar::create([
                'barang_id' => $barang->id,
                'jumlah' => abs($selisih),
                'tanggal' => now(),
                'keterangan' => 'Penyesuaian Stok (Edit Master)',
            ]);
        }

        return redirect()->route('barang.index')->with('success', 'Data barang berhasil diperbarui.');
    }

    public function destroy(Barang $barang)
    {
        $barang->delete();

        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus.');
    }
}