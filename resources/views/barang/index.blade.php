<x-app-layout>
    <x-slot name="title">Data Barang</x-slot>
    <x-slot name="header">Data Barang</x-slot>

    <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <h3 class="text-lg font-semibold text-slate-800">Daftar Inventory</h3>
            @if(auth()->user()->isAdmin())
                <a href="{{ route('barang.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors text-sm">
                    <i class="bi bi-plus-lg mr-2"></i> Tambah Barang
                </a>
            @endif
        </div>

        <!-- Search and Filter Panel -->
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
            <form action="{{ route('barang.index') }}" method="GET" class="flex flex-col md:flex-row gap-3 items-center w-full">
                <!-- Search Input -->
                <div class="flex items-center border pl-3 gap-2 bg-white border-slate-200 focus-within:border-blue-500 focus-within:ring-2 focus-within:ring-blue-100 h-[42px] rounded-lg overflow-hidden w-full md:w-96 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 30 30" fill="#6B7280">
                        <path d="M13 3C7.489 3 3 7.489 3 13s4.489 10 10 10a9.95 9.95 0 0 0 6.322-2.264l5.971 5.971a1 1 0 1 0 1.414-1.414l-5.97-5.97A9.95 9.95 0 0 0 23 13c0-5.511-4.489-10-10-10m0 2c4.43 0 8 3.57 8 8s-3.57 8-8 8-8-3.57-8-8 3.57-8 8-8"/>
                    </svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama barang atau kode..." 
                           class="w-full h-full bg-transparent border-0 p-0 focus:ring-0 text-slate-600 placeholder-slate-400 text-sm">
                    @if(request('search') || request('jenis') || request('sort'))
                        <a href="{{ route('barang.index') }}" class="pr-3 text-slate-400 hover:text-slate-600 transition-colors" title="Bersihkan Pencarian">
                            <i class="bi bi-x-circle-fill"></i>
                        </a>
                    @endif
                </div>

                <!-- Category Filter -->
                <select name="jenis" onchange="this.form.submit()" 
                        class="rounded-lg border-slate-200 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-colors text-sm h-[42px] bg-white text-slate-600 py-1.5 px-3 w-full md:w-48 cursor-pointer flex-shrink-0">
                    <option value="">-- Semua Kategori --</option>
                    @foreach([
                        'Plastik',
                        'Bahan Kue & Makanan',
                        'Wadah Makanan',
                        'Peralatan Makan',
                        'Tali & Packing',
                        'Kebutuhan Harian'
                    ] as $cat)
                        <option value="{{ $cat }}" {{ request('jenis') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>

                <!-- Sorting Filter Button-style Dropdown (Like the Filter Button in Laporan Keluar) -->
                @php
                    $currentSort = request('sort', 'terbaru');
                @endphp
                <div class="relative w-full md:w-48 flex-shrink-0">
                    <select name="sort" onchange="this.form.submit()" 
                            class="appearance-none bg-none w-full pl-9 pr-10 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors font-medium text-sm h-[42px] border-0 focus:ring-2 focus:ring-blue-300 cursor-pointer">
                        <option value="terbaru" class="bg-white text-slate-700" {{ $currentSort === 'terbaru' || $currentSort === 'terbaru_desc' ? 'selected' : '' }}>Terbaru</option>
                        <option value="nama_asc" class="bg-white text-slate-700" {{ $currentSort === 'nama_asc' ? 'selected' : '' }}>Nama A - Z</option>
                        <option value="stok_asc" class="bg-white text-slate-700" {{ $currentSort === 'stok_asc' ? 'selected' : '' }}>Stok Terendah</option>
                    </select>
                    <!-- Filter/Sort Icon on the left -->
                    <div class="absolute left-3 top-1/2 -translate-y-1/2 text-white pointer-events-none">
                        <i class="bi bi-filter text-base"></i>
                    </div>
                    <!-- White Chevron Icon on the right -->
                    <div class="absolute right-3 top-1/2 -translate-y-1/2 text-white pointer-events-none">
                        <i class="bi bi-chevron-down text-xs"></i>
                    </div>
                </div>
            </form>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                @php
                    $currentSort = request('sort', 'terbaru');
                    $nameNextSort = $currentSort === 'nama_asc' ? 'nama_desc' : 'nama_asc';
                    $stockNextSort = $currentSort === 'stok_asc' ? 'stok_desc' : 'stok_asc';
                @endphp
                <thead class="bg-slate-50 text-slate-500 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Kode</th>
                        <th class="px-6 py-4 font-semibold">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => $nameNextSort]) }}" class="hover:text-blue-600 inline-flex items-center gap-1.5 transition-colors">
                                Nama Barang
                                @if($currentSort === 'nama_asc')
                                    <i class="bi bi-sort-alpha-down text-blue-600 text-sm"></i>
                                @elseif($currentSort === 'nama_desc')
                                    <i class="bi bi-sort-alpha-down-alt text-blue-600 text-sm"></i>
                                @else
                                    <i class="bi bi-arrow-down-up text-slate-300 text-[10px] opacity-40 hover:opacity-100"></i>
                                @endif
                            </a>
                        </th>
                        <th class="px-6 py-4 font-semibold">Jenis</th>
                        <th class="px-6 py-4 font-semibold">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => $stockNextSort]) }}" class="hover:text-blue-600 inline-flex items-center gap-1.5 transition-colors">
                                Stok
                                @if($currentSort === 'stok_asc')
                                    <i class="bi bi-sort-numeric-down text-blue-600 text-sm"></i>
                                @elseif($currentSort === 'stok_desc')
                                    <i class="bi bi-sort-numeric-down-alt text-blue-600 text-sm"></i>
                                @else
                                    <i class="bi bi-arrow-down-up text-slate-300 text-[10px] opacity-40 hover:opacity-100"></i>
                                @endif
                            </a>
                        </th>
                        <th class="px-6 py-4 font-semibold">Harga (Rp)</th>
                        @if(auth()->user()->isAdmin())
                        <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($barangs as $barang)
                        <tr class="hover:bg-slate-50 transition-colors {{ $barang->stok == 0 ? 'bg-red-50' : '' }}">
                            <td class="px-6 py-4">
                                <span class="font-mono text-xs text-slate-500 bg-slate-100 px-2 py-1 rounded">{{ $barang->kode_barang }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('barang.show', $barang) }}" class="font-medium text-slate-800 hover:text-blue-600 hover:underline decoration-blue-500/40 block transition-colors">
                                    {{ $barang->nama_barang }}
                                </a>
                                @if($barang->deskripsi)
                                    <span class="text-xs text-slate-400 mt-0.5 block line-clamp-1 max-w-xs" title="{{ $barang->deskripsi }}">
                                        {{ $barang->deskripsi }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-slate-600">{{ $barang->jenis }}</td>
                            <td class="px-6 py-4">
                                @if($barang->stok > 10)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        {{ $barang->stok }}
                                    </span>
                                @elseif($barang->stok > 0)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        {{ $barang->stok }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Habis (0)
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-slate-600">Rp {{ number_format($barang->harga, 0, ',', '.') }}</td>
                            @if(auth()->user()->isAdmin())
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <!-- Edit Button (Admin Only) -->
                                    <a href="{{ route('barang.edit', $barang) }}" class="text-blue-600 hover:text-blue-800 p-2 hover:bg-blue-50 rounded-lg transition-colors" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <!-- Delete Button (Admin Only) -->
                                    <form action="{{ route('barang.destroy', $barang) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus barang ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 p-2 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ auth()->user()->isAdmin() ? '6' : '5' }}" class="px-6 py-12 text-center text-slate-500">
                                <div class="flex flex-col items-center">
                                    <i class="bi bi-box-seam text-4xl text-slate-300 mb-3"></i>
                                    <p class="text-lg">Belum ada data barang.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>