<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\RequestStock;
use Illuminate\Http\Request;

class RequestStockController extends Controller
{
    public function index(Request $request)
    {
        $user  = auth()->user();
        $query = RequestStock::with(['barang', 'user']);

        if ($user->isUser()) $query->where('user_id', $user->id);

        if ($request->filled('status')) $query->where('status', $request->status);

        if ($request->filled('search')) {
            $s = $request->search;
            $query->whereHas('barang', fn($q) => $q->where('nama_barang', 'like', "%$s%"));
        }

        $requests = $query->latest()->paginate(10)->withQueryString();

        return view('request.index', compact('requests'));
    }

    public function create()
    {
        $barangs = Barang::orderBy('nama_barang')->get();

        return view('request.create', compact('barangs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'jumlah'    => 'required|integer|min:1',
            'catatan'   => 'nullable|string|max:500',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['status']  = 'pending';

        RequestStock::create($validated);

        return redirect()->route('request.index')
                         ->with('success', 'Request stok diajukan. Menunggu persetujuan admin.');
    }

    public function show(RequestStock $request)
    {
        $this->authorizeAccess($request);
        $request->load(['barang', 'user']);

        return view('request.show', compact('request'));
    }

    public function destroy(RequestStock $request)
    {
        $this->authorizeAccess($request);

        if ($request->status !== 'pending') {
            return back()->with('error', 'Request yang sudah diproses tidak dapat dihapus.');
        }

        $request->delete();

        return redirect()->route('request.index')->with('success', 'Request dibatalkan.');
    }

    public function updateStatus(Request $request, RequestStock $requestStock)
    {
        $validated = $request->validate([
            'status' => 'required|in:disetujui,ditolak',
        ]);

        \Illuminate\Support\Facades\DB::transaction(function () use ($requestStock, $validated) {
            $requestStock->update($validated);

            if ($validated['status'] === 'disetujui') {
                $requestStock->barang->increment('stok', $requestStock->jumlah);

                \App\Models\BarangMasuk::create([
                    'barang_id' => $requestStock->barang_id,
                    'jumlah' => $requestStock->jumlah,
                    'tanggal' => now(),
                    'keterangan' => 'Dari Permintaan Stok (Request ID: ' . $requestStock->id . ')',
                ]);
            }
        });

        return back()->with('success', "Request berhasil {$validated['status']}.");
    }

    private function authorizeAccess(RequestStock $request): void
    {
        $user = auth()->user();
        if ($user->isUser() && $request->user_id !== $user->id) {
            abort(403);
        }
    }
}
