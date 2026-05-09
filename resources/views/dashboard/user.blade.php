<x-app-layout>
    <x-slot name="title">Dashboard User</x-slot>
    <x-slot name="header">Dashboard</x-slot>

    <div class="bg-white rounded-2xl shadow-sm border border-blue-100 p-8 mb-6 relative overflow-hidden">
        <div class="absolute right-0 top-0 w-64 h-64 bg-blue-50 rounded-full blur-3xl -z-10 translate-x-1/2 -translate-y-1/2"></div>
        <div class="relative z-10">
            <h3 class="text-2xl font-bold text-slate-800 mb-2">Selamat Datang, {{ auth()->user()->name }}!</h3>
            <p class="text-slate-500">Anda masuk sebagai Karyawan. Pantau stok barang dan ajukan permintaan stok jika diperlukan.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <!-- Card: Request Pending -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center text-2xl flex-shrink-0">
                <i class="bi bi-clock-history"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500 mb-1">Request Menunggu</p>
                <h3 class="text-2xl font-bold text-slate-800">{{ number_format($myPending) }}</h3>
            </div>
        </div>

        <!-- Card: Barang Habis -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-red-100 text-red-600 flex items-center justify-center text-2xl flex-shrink-0">
                <i class="bi bi-x-octagon"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500 mb-1">Stok Habis</p>
                <h3 class="text-2xl font-bold text-slate-800">{{ number_format($barangHabis) }}</h3>
            </div>
        </div>

        <!-- Card: Stok Kritis -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center text-2xl flex-shrink-0">
                <i class="bi bi-exclamation-triangle"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500 mb-1">Stok Menipis (≤ 5)</p>
                <h3 class="text-2xl font-bold text-slate-800">{{ number_format($barangMenipis) }}</h3>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-2">
            <i class="bi bi-clipboard-check text-blue-500"></i>
            <h4 class="font-semibold text-slate-800">Status Request Stok Terakhir Anda</h4>
        </div>
        <div class="p-0 overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 text-slate-500">
                    <tr>
                        <th class="px-6 py-3 font-medium">Tanggal</th>
                        <th class="px-6 py-3 font-medium">Barang</th>
                        <th class="px-6 py-3 font-medium">Jumlah</th>
                        <th class="px-6 py-3 font-medium">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($myRequests as $req)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-3 text-slate-800">{{ $req->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-3 font-medium text-slate-800">{{ $req->barang->nama_barang }}</td>
                            <td class="px-6 py-3">{{ $req->jumlah }}</td>
                            <td class="px-6 py-3">
                                @php
                                    $color = match($req->status) {
                                        'approved' => 'green',
                                        'rejected' => 'red',
                                        default => 'yellow'
                                    };
                                @endphp
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-{{ $color }}-100 text-{{ $color }}-800">
                                    {{ ucfirst($req->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-slate-500">
                                <div class="flex flex-col items-center">
                                    <i class="bi bi-inbox text-4xl text-slate-300 mb-2"></i>
                                    <p>Anda belum membuat request stok sama sekali.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
