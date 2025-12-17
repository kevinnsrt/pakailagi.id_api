<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Pesanan') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 overflow-hidden">
                
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <h3 class="text-lg font-medium text-gray-900">Daftar Transaksi</h3>
                    <span class="px-3 py-1 text-xs font-semibold text-teal-600 bg-teal-50 rounded-full border border-teal-100">
                        Total: {{ count($data) }} Pesanan
                    </span>
                </div>

                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-500">
                        <thead class="bg-gray-50 text-xs uppercase text-gray-700">
                            <tr>
                                <th class="px-6 py-4 font-semibold">Order ID</th>
                                <th class="px-6 py-4 font-semibold">Pelanggan</th>
                                <th class="px-6 py-4 font-semibold">Produk</th>
                                <th class="px-6 py-4 font-semibold">Lokasi Pengiriman</th>
                                <th class="px-6 py-4 font-semibold">Status</th>
                                <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                            @forelse ($data as $item)
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-6 py-4 font-medium text-gray-900">
                                        #{{ $item->id }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            @if (!empty($item->profile_picture))
                                                <img src="{{ asset('storage/' . $item->profile_picture) }}" 
                                                     alt="{{ $item->user->name }}" 
                                                     class="w-8 h-8 rounded-full object-cover border border-gray-200">
                                            @else
                                                <div class="w-8 h-8 rounded-full bg-teal-100 flex items-center justify-center text-teal-600 font-bold text-xs border border-teal-200">
                                                    {{ substr($item->user->name ?? 'U', 0, 1) }}
                                                </div>
                                            @endif
                                            
                                            <div class="font-medium text-gray-900">
                                                {{ $item->user->name ?? 'Guest' }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-gray-900 font-medium">{{ $item->product->name ?? '-' }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col text-xs text-gray-500">
                                            <span class="flex items-center gap-1">
                                                <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                                Lat: {{ $item->user->latitude ?? '-' }}
                                            </span>
                                            <span class="ml-4">Long: {{ $item->user->longitude ?? '-' }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @php
                                            $statusClasses = match($item->status) {
                                                'Selesai' => 'bg-green-50 text-green-700 border-green-100',
                                                'Diproses' => 'bg-teal-50 text-teal-700 border-teal-100',
                                                'Dibatalkan' => 'bg-red-50 text-red-700 border-red-100',
                                                'Dikeranjang' => 'bg-gray-50 text-gray-600 border-gray-200',
                                                default => 'bg-yellow-50 text-yellow-700 border-yellow-100',
                                            };
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $statusClasses }}">
                                            {{ $item->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        @if ($item->status == 'Diproses')
                                            <div class="flex items-center justify-end gap-2">
                                                <form method="POST" action="{{ route('proses.pesanan', $item->id) }}">
                                                    @csrf
                                                    <button type="submit" class="px-3 py-1.5 bg-teal-600 hover:bg-teal-700 text-white text-xs font-medium rounded-md transition shadow-sm hover:shadow">
                                                        Proses
                                                    </button>
                                                </form>
                                                
                                                <form method="POST" action="{{ route('batal.pesanan', $item->id) }}">
                                                    @csrf
                                                    <button type="submit" class="px-3 py-1.5 bg-white border border-red-200 text-red-600 hover:bg-red-50 text-xs font-medium rounded-md transition">
                                                        Batal
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <span class="text-xs text-gray-400 italic">No Action</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                            <p>Belum ada riwayat pesanan.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="md:hidden flex flex-col divide-y divide-gray-100">
                    @forelse ($data as $item)
                        <div class="p-4 bg-white hover:bg-gray-50 transition">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <span class="text-xs text-gray-500">Order #{{ $item->id }}</span>
                                    <h4 class="font-bold text-gray-900">{{ $item->product->name ?? 'Unknown Product' }}</h4>
                                </div>
                                @php
                                    $statusClasses = match($item->status) {
                                        'Selesai' => 'bg-green-50 text-green-700',
                                        'Diproses' => 'bg-teal-50 text-teal-700',
                                        'Dibatalkan' => 'bg-red-50 text-red-700',
                                        default => 'bg-gray-100 text-gray-600',
                                    };
                                @endphp
                                <span class="px-2 py-1 rounded text-xs font-semibold {{ $statusClasses }}">
                                    {{ $item->status }}
                                </span>
                            </div>
                            
                            <div class="text-sm text-gray-600 mb-4 space-y-2">
                                <div class="flex items-center gap-2">
                                    @if (!empty($item->profile_picture))
                                        <img src="{{ asset('storage/' . $item->profile_picture) }}" 
                                             class="w-5 h-5 rounded-full object-cover border border-gray-200">
                                    @else
                                        <div class="w-5 h-5 rounded-full bg-teal-100 flex items-center justify-center text-teal-600 font-bold text-[10px] border border-teal-200">
                                            {{ substr($item->user->name ?? 'U', 0, 1) }}
                                        </div>
                                    @endif
                                    
                                    <span class="font-medium">{{ $item->user->name ?? '-' }}</span>
                                </div>

                                <div class="flex items-start gap-2 pl-0.5">
                                    <svg class="w-4 h-4 text-gray-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    <span class="text-xs">
                                        Lat: {{ $item->user->latitude ?? '-' }}, <br>
                                        Long: {{ $item->user->longitude ?? '-' }}
                                    </span>
                                </div>
                            </div>

                            @if ($item->status == 'Diproses')
                                <div class="grid grid-cols-2 gap-3 mt-3 pt-3 border-t border-gray-100">
                                    <form method="POST" action="{{ route('batal.pesanan', $item->id) }}" class="w-full">
                                        @csrf
                                        <button type="submit" class="w-full py-2 bg-white border border-gray-200 text-gray-700 hover:bg-red-50 hover:border-red-200 hover:text-red-600 text-xs font-medium rounded-lg transition">
                                            Batal
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('proses.pesanan', $item->id) }}" class="w-full">
                                        @csrf
                                        <button type="submit" class="w-full py-2 bg-teal-600 text-white hover:bg-teal-700 text-xs font-medium rounded-lg shadow-sm transition">
                                            Proses Pesanan
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="p-8 text-center text-gray-500 text-sm">
                            Tidak ada data pesanan.
                        </div>
                    @endforelse
                </div>

            </div>
        </div>
    </div>
</x-app-layout>