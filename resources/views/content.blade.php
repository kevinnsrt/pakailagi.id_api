<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Daftar Barang') }}
            </h2>
            <a href="{{ route('tambah-barang') }}" class="inline-flex items-center px-4 py-2 bg-teal-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-teal-700 focus:bg-teal-700 active:bg-teal-900 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition ease-in-out duration-150">
                + Tambah Baru
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

                @forelse ($data as $item)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow duration-300 flex flex-col h-full">
                        
                        <div class="relative aspect-[4/3] w-full bg-gray-100 overflow-hidden group">
                            <img src="{{ asset('storage/' . $item->image_path) }}" 
                                 alt="{{ $item->name }}" 
                                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" />
                            
                            <div class="absolute top-3 left-3">
                                <span class="px-2.5 py-1 text-xs font-semibold tracking-wide text-teal-700 bg-teal-50 rounded-full border border-teal-100 shadow-sm">
                                    {{ $item->kategori }}
                                </span>
                            </div>
                        </div>

                        <div class="p-5 flex flex-col flex-grow">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="text-lg font-bold text-gray-900 line-clamp-1" title="{{ $item->name }}">
                                    {{ $item->name }}
                                </h3>
                            </div>

                            <p class="text-xl font-bold text-teal-600 mb-3">
                                Rp {{ number_format($item->price, 0, ',', '.') }}
                            </p>

                            <div class="flex items-center gap-2 mb-4 text-sm">
                                <span class="flex items-center text-gray-600 bg-gray-100 px-2 py-1 rounded text-xs font-medium">
                                    Size: {{ $item->ukuran }}
                                </span>

                                @php
                                    $condColor = match($item->kondisi) {
                                        'Like New' => 'text-blue-700 bg-blue-50 border-blue-100',
                                        'Good' => 'text-green-700 bg-green-50 border-green-100',
                                        'Fair' => 'text-yellow-700 bg-yellow-50 border-yellow-100',
                                        default => 'text-gray-600 bg-gray-50',
                                    };
                                @endphp
                                <span class="px-2 py-1 rounded text-xs font-medium border {{ $condColor }}">
                                    {{ $item->kondisi }}
                                </span>
                            </div>

                            <p class="text-gray-500 text-sm line-clamp-2 mb-4 flex-grow">
                                {{ $item->deskripsi }}
                            </p>
                            
                            <div class="mt-auto pt-4 border-t border-gray-100">
                                <button class="w-full inline-flex justify-center items-center px-4 py-2 bg-teal-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-teal-700 focus:bg-teal-700 active:bg-teal-900 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Edit Barang
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full flex flex-col items-center justify-center py-12 text-center">
                        <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                        <h3 class="text-lg font-medium text-gray-900">Belum ada barang</h3>
                        <p class="text-gray-500 max-w-sm mt-1">Mulai tambahkan koleksi barang preloved Anda sekarang.</p>
                    </div>
                @endforelse

            </div>
        </div>
    </div>
</x-app-layout>