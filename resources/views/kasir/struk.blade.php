<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Transaksi - {{ $transaksi->invoice_number }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @media print {
            body {
                width: 80mm;
                margin: 0;
                padding: 0;
            }
            .no-print {
                display: none !important;
            }
        }
        body {
            font-family: 'Courier New', Courier, monospace;
            background-color: #f8fafc;
            color: #0f172a;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen py-8">
    
    <div class="bg-white p-6 shadow-sm border border-slate-200 w-full max-w-[80mm] print:shadow-none print:border-none print:max-w-full print:p-0">
        
        <!-- Header -->
        <div class="text-center mb-6">
            <h1 class="text-xl font-bold uppercase tracking-wider mb-1">Toko Plastik Diza</h1>
            <p class="text-xs text-slate-500">Jl. Pahlawan IIIB No. 12</p>
            <p class="text-xs text-slate-500">No. WA: 0882-9790-7388</p>
        </div>

        <div class="border-t border-dashed border-slate-300 my-4"></div>

        <!-- Info Transaksi -->
        <div class="text-xs space-y-1 mb-4">
            <div class="flex justify-between">
                <span>No. Invoice:</span>
                <span class="font-semibold">{{ $transaksi->invoice_number }}</span>
            </div>
            <div class="flex justify-between">
                <span>Tanggal:</span>
                <span>{{ \Carbon\Carbon::parse($transaksi->created_at)->format('d/m/Y H:i') }}</span>
            </div>
            <div class="flex justify-between">
                <span>Kasir:</span>
                <span>{{ $transaksi->user->name }}</span>
            </div>
        </div>

        <div class="border-t border-dashed border-slate-300 my-4"></div>

        <!-- Item List -->
        <div class="text-xs mb-4">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b border-dashed border-slate-300">
                        <th class="py-2 font-semibold">Item</th>
                        <th class="py-2 font-semibold text-center">Qty</th>
                        <th class="py-2 font-semibold text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transaksi->detail as $dt)
                    <tr>
                        <td class="py-2">
                            <div class="font-medium truncate max-w-[120px]">{{ $dt->barang->nama_barang }}</div>
                            <div class="text-[10px] text-slate-500">{{ number_format($dt->harga_satuan, 0, ',', '.') }}</div>
                        </td>
                        <td class="py-2 text-center align-top">{{ $dt->jumlah }}</td>
                        <td class="py-2 text-right align-top">{{ number_format($dt->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="border-t border-dashed border-slate-300 my-4"></div>

        <!-- Total -->
        <div class="text-sm font-bold flex justify-between mb-2">
            <span>TOTAL</span>
            <span>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
        </div>

        <!-- Rincian Pembayaran -->
        <div class="text-xs space-y-1 mb-6">
            <div class="flex justify-between">
                <span>Bayar Via:</span>
                <span class="font-semibold uppercase">{{ $transaksi->metode_pembayaran }}</span>
            </div>
            @if($transaksi->metode_pembayaran === 'tunai')
            <div class="flex justify-between">
                <span>Tunai:</span>
                <span>Rp {{ number_format($transaksi->bayar, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between">
                <span>Kembali:</span>
                <span>Rp {{ number_format($transaksi->kembalian, 0, ',', '.') }}</span>
            </div>
            @else
            <div class="flex justify-between text-emerald-600 font-semibold">
                <span>Status:</span>
                <span>LUNAS (QRIS)</span>
            </div>
            @endif
        </div>

        <!-- Footer -->
        <div class="text-center text-xs text-slate-500 space-y-1">
            <p>Terima kasih atas kunjungan Anda!</p>
            <p>Barang yang sudah dibeli tidak dapat ditukar/dikembalikan.</p>
        </div>

        <!-- Print Button (No Print) -->
        <div class="mt-8 no-print flex gap-2">
            <button onclick="window.print()" class="flex-1 py-2 bg-blue-600 text-white rounded font-medium hover:bg-blue-700 transition-colors">
                Cetak
            </button>
            <a href="{{ route('kasir.index') }}" class="flex-1 py-2 bg-slate-200 text-slate-700 text-center rounded font-medium hover:bg-slate-300 transition-colors">
                Kembali
            </a>
        </div>
    </div>

    <!-- Script auto print -->
    <script>
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 500);
        }
    </script>
</body>
</html>
