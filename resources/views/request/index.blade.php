<x-app-layout>
    <x-slot name="title">Request Stock</x-slot>
    <x-slot name="header">Manajemen Request Stock</x-slot>

    <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <h3 class="text-lg font-semibold text-slate-800">Daftar Permintaan Stok</h3>
            @if(auth()->user()->isUser())
                <a href="{{ route('request.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors text-sm">
                    <i class="bi bi-plus-lg mr-2"></i> Buat Request Baru
                </a>
            @endif
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 text-slate-500 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-6 py-4 font-semibold text-left">Tanggal</th>
                        @if(auth()->user()->isAdmin())
                        <th class="px-6 py-4 font-semibold text-left">Peminta</th>
                        @endif
                        <th class="px-6 py-4 font-semibold text-left">Barang</th>
                        <th class="px-6 py-4 font-semibold text-center">Jumlah</th>
                        <th class="px-6 py-4 font-semibold text-center">Status</th>
                        <th class="px-14 py-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($requests as $req)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-slate-600 text-left">{{ $req->created_at->format('d/m/Y H:i') }}</td>
                            @if(auth()->user()->isAdmin())
                            <td class="px-6 py-4 font-medium text-slate-800 text-left">{{ $req->user->name }}</td>
                            @endif
                            <td class="px-6 py-4 text-left">
                                <span class="font-medium text-slate-800">{{ $req->barang->nama_barang }}</span>
                                <div class="text-xs text-slate-500">Stok saat ini: {{ $req->barang->stok }}</div>
                            </td>
                            <td class="px-6 py-4 text-slate-800 font-medium text-center">{{ $req->jumlah }}</td>
                            <td class="px-6 py-4 text-center">
                                @php
                                    $color = match($req->status) {
                                        'disetujui' => 'green',
                                        'ditolak' => 'red',
                                        default => 'yellow'
                                    };
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $color }}-100 text-{{ $color }}-800">
                                    {{ ucfirst($req->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    @if(auth()->user()->isAdmin() && $req->status === 'pending')
                                        <form action="{{ route('request.updateStatus', $req) }}" method="POST" class="inline-block" onsubmit="return confirm('Setujui request ini?');">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="disetujui">
                                            <button type="submit" class="text-white bg-green-500 hover:bg-green-600 px-2 py-1 rounded text-xs font-medium transition-colors">
                                                <i class="bi bi-check-lg"></i> Setujui
                                            </button>
                                        </form>
                                        <form action="{{ route('request.updateStatus', $req) }}" method="POST" class="inline-block" onsubmit="return confirm('Tolak request ini?');">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="ditolak">
                                            <button type="submit" class="text-white bg-red-500 hover:bg-red-600 px-2 py-1 rounded text-xs font-medium transition-colors">
                                                <i class="bi bi-x-lg"></i> Tolak
                                            </button>
                                        </form>
                                    @elseif(auth()->user()->isUser() && $req->status === 'pending')
                                        <form action="{{ route('request.destroy', $req) }}" method="POST" class="inline-block" onsubmit="return confirm('Batalkan request ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center gap-1 text-red-600 hover:text-white border border-red-200 hover:bg-red-600 px-4 py-2 rounded-lg text-xs font-semibold transition-all shadow-sm" title="Batalkan Request">
                                                <i class="bi bi-x-circle text-[15px]"></i> Batalkan
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-slate-400 text-sm italic">Selesai</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ auth()->user()->isAdmin() ? '6' : '5' }}" class="px-6 py-12 text-center text-slate-500">
                                <div class="flex flex-col items-center">
                                    <i class="bi bi-clipboard-check text-4xl text-slate-300 mb-3"></i>
                                    <p class="text-lg">Belum ada request stok yang diajukan.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($requests->hasPages())
        <div class="px-6 py-4 border-t border-slate-100">
            {{ $requests->links() }}
        </div>
        @endif
    </div>
</x-app-layout>
