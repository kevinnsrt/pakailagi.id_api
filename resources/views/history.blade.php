<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Pesanan') }}
        </h2>
    </x-slot>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <div class="py-6 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 overflow-hidden overflow-visible">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <h3 class="text-lg font-medium text-gray-900">Daftar Transaksi</h3>
                    <span class="px-3 py-1 text-xs font-semibold text-teal-600 bg-teal-50 rounded-full border border-teal-100">
                        Total: {{ count($data) }} Pesanan
                    </span>
                </div>

                <div class="hidden md:block overflow-x-auto overflow-y-visible"> 
                    <table class="w-full text-left text-sm text-gray-500">
                        <thead class="bg-gray-50 text-xs uppercase text-gray-700">
                            <tr>
                                <th class="px-6 py-4">Order ID</th>
                                <th class="px-6 py-4">Pelanggan</th>
                                <th class="px-6 py-4">Produk</th>
                                <th class="px-6 py-4">Lokasi Pengiriman</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                            @forelse ($data as $item)
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-6 py-4 font-medium text-gray-900">#{{ $item->id }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            @if ($item->user && $item->user->profile_picture)
                                                <img src="{{ asset('storage/' . $item->user->profile_picture) }}" alt="{{ $item->user->name }}" class="w-8 h-8 rounded-full object-cover border border-gray-200">
                                            @else
                                                <div class="w-8 h-8 rounded-full bg-teal-100 flex items-center justify-center text-teal-600 font-bold text-xs border border-teal-200">{{ substr($item->user->name ?? 'U', 0, 1) }}</div>
                                            @endif
                                            <div class="font-medium text-gray-900">{{ $item->user->name ?? 'Guest' }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-gray-900 font-medium">{{ $item->product->name ?? '-' }}</span>
                                    </td>
                                    <td class="px-6 py-4"> 
                                        <div class="flex flex-col text-xs text-gray-500 max-w-[200px]">
                                            <div class="flex items-start gap-1">
                                                <svg class="w-3 h-3 text-red-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                                
                                                <a href="https://www.google.com/maps/search/?api=1&query={{ $item->user->latitude }},{{ $item->user->longitude }}" 
                                                   target="_blank"
                                                   class="load-address leading-snug hover:text-teal-600 hover:underline cursor-pointer transition duration-150" 
                                                   data-lat="{{ $item->user->latitude ?? '' }}" 
                                                   data-lng="{{ $item->user->longitude ?? '' }}"
                                                   onmouseenter="showGlobalMap(this)"
                                                   onmouseleave="hideGlobalMap()">
                                                    <span class="address-text text-gray-400">Memuat alamat...</span>
                                                    <br>
                                                    <span class="coords-text text-[10px] text-gray-400">({{ $item->user->latitude ?? '-' }}, {{ $item->user->longitude ?? '-' }})</span>
                                                </a>
                                            </div>
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
                                                    <button type="submit" class="px-3 py-1.5 bg-teal-600 hover:bg-teal-700 text-white text-xs font-medium rounded-md transition shadow-sm hover:shadow">Proses</button>
                                                </form>
                                                <form method="POST" action="{{ route('batal.pesanan', $item->id) }}">
                                                    @csrf
                                                    <button type="submit" class="px-3 py-1.5 bg-white border border-red-200 text-red-600 hover:bg-red-50 text-xs font-medium rounded-md transition">Batal</button>
                                                </form>
                                            </div>
                                        @else
                                            <span class="text-xs text-gray-400 italic">No Action</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="px-6 py-12 text-center text-gray-500">Belum ada pesanan.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="md:hidden flex flex-col divide-y divide-gray-100">
                    @forelse ($data as $item)
                        <div class="p-4 bg-white">
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
                                <span class="px-2 py-1 rounded text-xs font-semibold {{ $statusClasses }}">{{ $item->status }}</span>
                            </div>
                            
                            <div class="text-sm text-gray-600 mb-4 space-y-2">
                                <div class="flex items-center gap-2">
                                    @if ($item->user && $item->user->profile_picture)
                                        <img src="{{ asset('storage/' . $item->user->profile_picture) }}" class="w-5 h-5 rounded-full object-cover border border-gray-200">
                                    @else
                                        <div class="w-5 h-5 rounded-full bg-teal-100 flex items-center justify-center text-teal-600 font-bold text-[10px] border border-teal-200">{{ substr($item->user->name ?? 'U', 0, 1) }}</div>
                                    @endif
                                    <span class="font-medium">{{ $item->user->name ?? '-' }}</span>
                                </div>

                                <div class="flex items-start gap-2 pl-0.5">
                                    <svg class="w-4 h-4 text-red-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    
                                    <a href="https://www.google.com/maps/search/?api=1&query={{ $item->user->latitude }},{{ $item->user->longitude }}" 
                                       target="_blank"
                                       class="load-address text-xs leading-snug hover:text-teal-600 hover:underline cursor-pointer transition duration-150" 
                                       data-lat="{{ $item->user->latitude ?? '' }}" 
                                       data-lng="{{ $item->user->longitude ?? '' }}">
                                        <span class="address-text text-gray-400">Memuat alamat...</span>
                                        <br>
                                        <span class="coords-text text-[10px] text-gray-400">({{ $item->user->latitude ?? '-' }}, {{ $item->user->longitude ?? '-' }})</span>
                                    </a>
                                </div>
                            </div>

                            @if ($item->status == 'Diproses')
                                <div class="grid grid-cols-2 gap-3 mt-3 pt-3 border-t border-gray-100">
                                    <form method="POST" action="{{ route('batal.pesanan', $item->id) }}" class="w-full">
                                        @csrf <button type="submit" class="w-full py-2 bg-white border border-gray-200 text-gray-700 hover:bg-red-50 hover:text-red-600 text-xs font-medium rounded-lg transition">Batal</button>
                                    </form>
                                    <form method="POST" action="{{ route('proses.pesanan', $item->id) }}" class="w-full">
                                        @csrf <button type="submit" class="w-full py-2 bg-teal-600 text-white hover:bg-teal-700 text-xs font-medium rounded-lg shadow-sm transition">Proses Pesanan</button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="p-8 text-center text-gray-500 text-sm">Tidak ada data.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div id="global-map-popup" class="fixed hidden z-[9999] w-72 h-56 bg-white border-2 border-teal-500 rounded-xl shadow-2xl overflow-hidden pointer-events-none transition-opacity duration-200 opacity-0">
        <div id="global-map" class="w-full h-full bg-gray-100"></div>
        <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 translate-y-1/2 w-4 h-4 bg-white border-b-2 border-r-2 border-teal-500 rotate-45"></div>
    </div>

    <script>
        let globalMap = null;
        let globalMarker = null;
        const popup = document.getElementById('global-map-popup');

        function showGlobalMap(element) {
            const lat = element.getAttribute('data-lat');
            const lng = element.getAttribute('data-lng');
            if (!lat || !lng || lat === '-' || lng === '-') return;

            const rect = element.getBoundingClientRect();
            const topPos = rect.top - 240; 
            const leftPos = rect.left + (rect.width / 2) - 144; 

            popup.style.top = `${topPos}px`;
            popup.style.left = `${leftPos}px`;
            popup.classList.remove('hidden');
            setTimeout(() => popup.classList.remove('opacity-0'), 10);

            if (!globalMap) {
                globalMap = L.map('global-map', { zoomControl: false, attributionControl: false });
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19 }).addTo(globalMap);
                globalMarker = L.marker([0, 0]).addTo(globalMap);
            }
            globalMap.setView([lat, lng], 15);
            globalMarker.setLatLng([lat, lng]);
            globalMap.invalidateSize(); 
        }

        function hideGlobalMap() {
            popup.classList.add('opacity-0');
            setTimeout(() => { popup.classList.add('hidden'); }, 200);
        }

        document.addEventListener("DOMContentLoaded", function() {
            const addressElements = document.querySelectorAll('.load-address');
            
            const fetchAddress = (lat, lng, element, delay) => {
                setTimeout(() => {
                    const addressSpan = element.querySelector('.address-text'); 
                    
                    if (!lat || !lng || lat === '-') {
                        if(addressSpan) addressSpan.innerText = 'Lokasi tidak tersedia'; 
                        return;
                    }
                    
                    fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                        .then(r => r.json()).then(d => {
                            if (d.display_name && addressSpan) {
                                addressSpan.innerText = d.display_name;
                                addressSpan.classList.remove('text-gray-400');
                                addressSpan.classList.add('text-gray-700');
                            } else if(addressSpan) {
                                addressSpan.innerText = "Alamat tidak ditemukan";
                            }
                        });
                }, delay);
            };

            addressElements.forEach((el, index) => {
                fetchAddress(el.getAttribute('data-lat'), el.getAttribute('data-lng'), el, index * 1200);
            });
        });
    </script>
</x-app-layout>