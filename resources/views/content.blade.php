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
            
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

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
                                <button onclick="openEditModal({{ json_encode($item) }})" 
                                    class="w-full inline-flex justify-center items-center px-4 py-2 bg-teal-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-teal-700 focus:bg-teal-700 active:bg-teal-900 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition ease-in-out duration-150">
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

<div id="edit-modal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity"></div>

        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-xl bg-white text-left shadow-2xl transition-all sm:my-8 w-full max-w-lg border border-gray-200 z-10">
                
                <div class="bg-gray-50 px-4 py-3 sm:px-6 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-900">Edit Barang</h3>
                    <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-500 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <form id="edit-form" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT') <div class="px-4 py-5 sm:p-6 space-y-4">
                        <div class="form-control w-full">
                            <label class="label mb-1 font-semibold text-gray-700 text-sm">Nama Barang</label>
                            <input type="text" name="name" id="edit-name" class="input input-bordered w-full rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500 h-10" required>
                        </div>

                        <div class="form-control w-full">
                            <label class="label mb-1 font-semibold text-gray-700 text-sm">Harga (Rp)</label>
                            <input type="number" name="price" id="edit-price" class="input input-bordered w-full rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500 h-10" required>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="form-control w-full">
                                <label class="label mb-1 font-semibold text-gray-700 text-sm">Kategori</label>
                                <select name="kategori" id="edit-kategori" class="select select-bordered w-full rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500 h-10 min-h-0">
                                    <option value="Atasan">Atasan</option>
                                    <option value="Bawahan">Bawahan</option>
                                    <option value="Outer">Outer</option>
                                    <option value="Tas">Tas</option>
                                    <option value="Sepatu">Sepatu</option>
                                    <option value="accessories">Accessories</option>
                                    <option value="Others">Others</option>
                                </select>
                            </div>

                            <div class="form-control w-full">
                                <label class="label mb-1 font-semibold text-gray-700 text-sm">Kondisi</label>
                                <select name="kondisi" id="edit-kondisi" class="select select-bordered w-full rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500 h-10 min-h-0">
                                    <option value="Like New">Like New</option>
                                    <option value="Good">Good</option>
                                    <option value="Fair">Fair</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-control w-full">
                            <label class="label mb-1 font-semibold text-gray-700 text-sm">Ukuran</label>
                            <input type="text" name="ukuran" id="edit-ukuran" class="input input-bordered w-full rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500 h-10">
                        </div>

                        <div class="form-control w-full">
                            <label class="label mb-1 font-semibold text-gray-700 text-sm">Deskripsi</label>
                            <textarea name="deskripsi" id="edit-deskripsi" rows="3" class="textarea textarea-bordered w-full rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500"></textarea>
                        </div>

                        <div class="form-control w-full">
                            <label class="label mb-1 font-semibold text-gray-700 text-sm">Ganti Foto (Opsional)</label>
                            <input type="file" name="image" class="file-input file-input-bordered w-full file-input-xs rounded-lg text-xs">
                        </div>
                    </div>

                    <div class="bg-gray-50 px-4 py-3 sm:px-6 flex flex-row-reverse gap-3">
                        <button type="submit" class="inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-teal-600 text-base font-medium text-white hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 sm:text-sm">
                            Simpan Perubahan
                        </button>
                        <button type="button" onclick="closeEditModal()" class="inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 sm:text-sm">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const editModal = document.getElementById('edit-modal');
        const editForm = document.getElementById('edit-form');

        function openEditModal(product) {
            // 1. Set Action URL Form
            // Ini akan menghasilkan URL seperti: /barang/15
            editForm.action = `/barang/${product.id}`;

            // 2. Isi Input Form dengan Data Produk
            document.getElementById('edit-name').value = product.name;
            document.getElementById('edit-price').value = product.price;
            document.getElementById('edit-kategori').value = product.kategori;
            document.getElementById('edit-kondisi').value = product.kondisi;
            document.getElementById('edit-ukuran').value = product.ukuran;
            document.getElementById('edit-deskripsi').value = product.deskripsi;

            // 3. Tampilkan Modal
            editModal.classList.remove('hidden');
        }

        function closeEditModal() {
            editModal.classList.add('hidden');
        }
    </script>
</x-app-layout>