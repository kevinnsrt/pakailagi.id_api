<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Overview') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-6 mb-6 sm:mb-8">
                
                <div class="bg-white p-4 sm:p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col sm:flex-row items-start sm:items-center">
                    <div class="p-2 sm:p-3 bg-green-50 rounded-full text-green-600 mb-2 sm:mb-0 sm:mr-4">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs sm:text-sm text-gray-500 font-medium">Pendapatan</p>
                        <h3 class="text-lg sm:text-xl font-bold text-gray-900 truncate">
                            Rp {{ number_format($pendapatan, 0, ',', '.') }}
                        </h3>
                    </div>
                </div>

                <div class="bg-white p-4 sm:p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col sm:flex-row items-start sm:items-center">
                    <div class="p-2 sm:p-3 bg-indigo-50 rounded-full text-indigo-600 mb-2 sm:mb-0 sm:mr-4">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs sm:text-sm text-gray-500 font-medium">Proses</p>
                        <h3 class="text-lg sm:text-xl font-bold text-gray-900">
                            {{ $pesananAktif }} <span class="text-xs font-normal text-gray-400">Order</span>
                        </h3>
                    </div>
                </div>

                <div class="bg-white p-4 sm:p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col sm:flex-row items-start sm:items-center">
                    <div class="p-2 sm:p-3 bg-blue-50 rounded-full text-blue-600 mb-2 sm:mb-0 sm:mr-4">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs sm:text-sm text-gray-500 font-medium">Produk</p>
                        <h3 class="text-lg sm:text-xl font-bold text-gray-900">
                            {{ $totalProduk }} <span class="text-xs font-normal text-gray-400">Unit</span>
                        </h3>
                    </div>
                </div>

                <div class="bg-white p-4 sm:p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col sm:flex-row items-start sm:items-center">
                    <div class="p-2 sm:p-3 bg-orange-50 rounded-full text-orange-600 mb-2 sm:mb-0 sm:mr-4">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs sm:text-sm text-gray-500 font-medium">User</p>
                        <h3 class="text-lg sm:text-xl font-bold text-gray-900">
                            {{ $totalUser }} <span class="text-xs font-normal text-gray-400">Akun</span>
                        </h3>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <div class="bg-white p-4 sm:p-6 rounded-2xl shadow-sm border border-gray-100">
                    <h3 class="text-base sm:text-lg font-semibold text-gray-800 mb-4">Statistik Pesanan</h3>
                    <div class="relative h-56 sm:h-64 w-full flex justify-center">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>

                <div class="bg-white p-4 sm:p-6 rounded-2xl shadow-sm border border-gray-100">
                    <h3 class="text-base sm:text-lg font-semibold text-gray-800 mb-4">Penjualan Kategori</h3>
                    <div class="relative h-56 sm:h-64 w-full">
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-4 sm:px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <h3 class="text-base sm:text-lg font-semibold text-gray-800">Pesanan Terbaru</h3>
                    <a href="{{ route('history.admin') }}" class="text-xs sm:text-sm text-indigo-600 hover:text-indigo-800 font-medium">Lihat Semua &rarr;</a>
                </div>
                
                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-500">
                        <thead class="bg-gray-50 text-xs uppercase text-gray-700">
                            <tr>
                                <th class="px-6 py-3">Order ID</th>
                                <th class="px-6 py-3">User</th>
                                <th class="px-6 py-3">Barang</th>
                                <th class="px-6 py-3">Status</th>
                                <th class="px-6 py-3 text-right">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($latestOrders as $order)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 font-medium text-gray-900">#{{ $order->id }}</td>
                                    <td class="px-6 py-4">{{ $order->user->name ?? 'Guest' }}</td>
                                    <td class="px-6 py-4 text-gray-800">{{ $order->product->name ?? '-' }}</td>
                                    <td class="px-6 py-4">
                                        @include('components.status-badge', ['status' => $order->status])
                                    </td>
                                    <td class="px-6 py-4 text-right text-xs text-gray-400">
                                        {{ $order->created_at->diffForHumans() }}
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="px-6 py-8 text-center text-gray-400">Belum ada pesanan terbaru.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="md:hidden flex flex-col divide-y divide-gray-100">
                    @forelse($latestOrders as $order)
                        <div class="p-4 flex justify-between items-start">
                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="text-xs font-bold text-gray-900">#{{ $order->id }}</span>
                                    <span class="text-xs text-gray-500">&bull; {{ $order->user->name ?? 'Guest' }}</span>
                                </div>
                                <h4 class="text-sm font-medium text-gray-800 mb-2">{{ $order->product->name ?? '-' }}</h4>
                                <span class="text-xs text-gray-400">{{ $order->created_at->diffForHumans() }}</span>
                            </div>
                            <div>
                                @php
                                    $color = match($order->status) {
                                        'Selesai' => 'bg-green-100 text-green-700',
                                        'Diproses' => 'bg-indigo-100 text-indigo-700',
                                        'Dalam Pengiriman' => 'bg-blue-100 text-blue-700',
                                        'Dibatalkan' => 'bg-red-100 text-red-700',
                                        default => 'bg-gray-100 text-gray-600',
                                    };
                                @endphp
                                <span class="px-2 py-1 rounded-md text-[10px] font-bold uppercase {{ $color }}">
                                    {{ $order->status }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="p-6 text-center text-gray-400 text-sm">Belum ada pesanan terbaru.</div>
                    @endforelse
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const statusLabels = {{ \Illuminate\Support\Js::from($chartStatusLabel) }};
        const statusData   = {{ \Illuminate\Support\Js::from($chartStatusData) }};
        const categoryLabels = {{ \Illuminate\Support\Js::from($chartKategoriLabel) }};
        const categoryData   = {{ \Illuminate\Support\Js::from($chartKategoriData) }};

        // CHART STATUS (Doughnut)
        new Chart(document.getElementById('statusChart').getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: statusLabels,
                datasets: [{
                    data: statusData,
                    backgroundColor: ['#F3F4F6', '#6366F1', '#3B82F6', '#10B981', '#EF4444'],
                    borderWidth: 0, hoverOffset: 4
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: { legend: { position: 'right', labels: { boxWidth: 12, font: { size: 11 } } } }
            }
        });

        // CHART KATEGORI (Bar)
        new Chart(document.getElementById('categoryChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: categoryLabels,
                datasets: [{
                    label: 'Terjual',
                    data: categoryData,
                    backgroundColor: '#6366F1', borderRadius: 4
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                scales: {
                    y: { beginAtZero: true, grid: { display: false }, ticks: { font: { size: 10 } } },
                    x: { grid: { display: false }, ticks: { font: { size: 10 } } }
                }
            }
        });
    </script>
</x-app-layout>