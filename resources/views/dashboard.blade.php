<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Card Barang Habis -->
            @php
                $barangHabis = \App\Models\Barang::where('stok', 0)->get();
                $stokMenipis = \App\Models\Barang::where('stok', '<=', 5)->where('stok','>',0)->get();
            @endphp
            
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-red-100 overflow-hidden">
                <div class="bg-red-50 px-6 py-4 border-b border-red-100 flex justify-between items-center">
                    <h3 class="font-bold text-red-700 flex items-center gap-2">
                        <i class="bi bi-exclamation-triangle-fill"></i> Barang Habis ({{ $barangHabis->count() }})
                    </h3>
                </div>
                <div class="p-0">
                    @if($barangHabis->isEmpty())
                        <div class="p-6 text-center text-gray-500">
                            <i class="bi bi-check-circle text-3xl text-green-400 mb-2 block"></i>
                            <p>Tidak ada barang yang habis stoknya.</p>
                        </div>
                    @else
                        <ul class="divide-y divide-gray-100 dark:divide-gray-700 max-h-80 overflow-y-auto">
                            @foreach($barangHabis as $item)
                                <li class="px-6 py-3 flex justify-between items-center hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                    <div class="flex flex-col">
                                        <span class="font-medium text-gray-800 dark:text-gray-200">{{ $item->nama_barang }}</span>
                                        <span class="text-xs text-gray-500 font-mono">{{ $item->kode_barang }}</span>
                                    </div>
                                    <span class="px-2 py-1 bg-red-100 text-red-700 rounded-lg text-xs font-bold">Stok: 0</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>

            <!-- Card Stok Menipis -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-yellow-100 overflow-hidden">
                <div class="bg-yellow-50 px-6 py-4 border-b border-yellow-100 flex justify-between items-center">
                    <h3 class="font-bold text-yellow-700 flex items-center gap-2">
                        <i class="bi bi-exclamation-circle-fill"></i> Stok Menipis ({{ $stokMenipis->count() }})
                    </h3>
                </div>
                <div class="p-0">
                    @if($stokMenipis->isEmpty())
                        <div class="p-6 text-center text-gray-500">
                            <i class="bi bi-check-circle text-3xl text-green-400 mb-2 block"></i>
                            <p>Stok barang masih aman.</p>
                        </div>
                    @else
                        <ul class="divide-y divide-gray-100 dark:divide-gray-700 max-h-80 overflow-y-auto">
                            @foreach($stokMenipis as $item)
                                <li class="px-6 py-3 flex justify-between items-center hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                    <div class="flex flex-col">
                                        <span class="font-medium text-gray-800 dark:text-gray-200">{{ $item->nama_barang }}</span>
                                        <span class="text-xs text-gray-500 font-mono">{{ $item->kode_barang }}</span>
                                    </div>
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded-lg text-xs font-bold">Stok: {{ $item->stok }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
