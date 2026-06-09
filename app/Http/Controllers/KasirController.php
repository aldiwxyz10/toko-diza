<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class KasirController extends Controller
{
    public function index()
    {
        $barangs = Barang::where('stok', '>', 0)->get();
        return view('kasir.index', compact('barangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|array',
            'barang_id.*' => 'required|exists:barang,id',
            'jumlah' => 'required|array',
            'jumlah.*' => 'required|integer|min:1',
            'metode_pembayaran' => 'required|in:tunai,qris',
            'bayar' => 'required_if:metode_pembayaran,tunai|nullable|integer',
            'kembalian' => 'required_if:metode_pembayaran,tunai|nullable|integer',
        ]);

        try {
            DB::beginTransaction();

            $total_harga = 0;
            $items = [];

            // Validasi stok dan hitung total
            foreach ($request->barang_id as $key => $barang_id) {
                $barang = Barang::findOrFail($barang_id);
                $qty = $request->jumlah[$key];

                if ($barang->stok < $qty) {
                    throw new \Exception("Stok {$barang->nama_barang} tidak mencukupi.");
                }

                $subtotal = $barang->harga * $qty;
                $total_harga += $subtotal;

                $items[] = [
                    'barang' => $barang,
                    'qty' => $qty,
                    'subtotal' => $subtotal
                ];
            }

            // Buat Transaksi
            $transaksi = Transaksi::create([
                'invoice_number' => 'INV-' . strtoupper(Str::random(8)),
                'user_id' => auth()->id(),
                'total_harga' => $total_harga,
                'tanggal' => now(),
                'metode_pembayaran' => $request->metode_pembayaran,
                'bayar' => $request->metode_pembayaran === 'tunai' ? $request->bayar : null,
                'kembalian' => $request->metode_pembayaran === 'tunai' ? $request->kembalian : null,
            ]);

            // Simpan Detail dan Kurangi Stok
            foreach ($items as $item) {
                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'barang_id' => $item['barang']->id,
                    'jumlah' => $item['qty'],
                    'harga_satuan' => $item['barang']->harga,
                    'subtotal' => $item['subtotal'],
                ]);

                \App\Models\BarangKeluar::create([
                    'barang_id' => $item['barang']->id,
                    'jumlah' => $item['qty'],
                    'tanggal' => now(),
                    'keterangan' => 'Penjualan Kasir ' . $transaksi->invoice_number,
                ]);

                $item['barang']->decrement('stok', $item['qty']);
            }

            DB::commit();

            return redirect()->route('kasir.struk', $transaksi->id)
                             ->with('success', 'Transaksi berhasil disimpan!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memproses transaksi: ' . $e->getMessage());
        }
    }

    public function struk($id)
    {
        $transaksi = Transaksi::with(['detail.barang', 'user'])->findOrFail($id);
        return view('kasir.struk', compact('transaksi'));
    }
}
