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

    @if(session('success'))
        <div id="toast-success" class="fixed top-5 right-5 z-[100] transform transition-all duration-500 ease-in-out translate-x-full opacity-0">
            <div class="flex items-center w-full max-w-xs p-4 text-gray-500 bg-white rounded-lg shadow-xl border-l-4 border-teal-500" role="alert">
                <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-teal-500 bg-teal-100 rounded-lg">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                    </svg>
                </div>
                <div class="ml-3 text-sm font-normal text-gray-800">{{ session('success') }}</div>
                <button type="button" onclick="closeToast()" class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 transition">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                </button>
            </div>
        </div>
    @endif

    <div class="py-6 sm:py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-6">

                @forelse ($data as $item)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow duration-300 flex flex-col h-full">
                        
                        <div class="relative aspect-[4/3] w-full bg-gray-100 overflow-hidden group">
                            <img src="{{ asset('storage/' . $item->image_path) }}" 
                                 alt="{{ $item->name }}" 
                                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" />
                            
                            <div class="absolute top-2 left-2 sm:top-3 sm:left-3">
                                <span class="px-2 py-0.5 sm:px-2.5 sm:py-1 text-[10px] sm:text-xs font-semibold tracking-wide text-teal-700 bg-teal-50 rounded-full border border-teal-100 shadow-sm">
                                    {{ $item->kategori }}
                                </span>
                            </div>
                        </div>

                        <div class="p-3 sm:p-5 flex flex-col flex-grow">
                            <div class="flex justify-between items-start mb-1 sm:mb-2">
                                <h3 class="text-sm sm:text-lg font-bold text-gray-900 line-clamp-1" title="{{ $item->name }}">
                                    {{ $item->name }}
                                </h3>
                            </div>

                            <p class="text-base sm:text-xl font-bold text-teal-600 mb-2 sm:mb-3">
                                Rp {{ number_format($item->price, 0, ',', '.') }}
                            </p>

                            <div class="flex flex-wrap items-center gap-1 sm:gap-2 mb-2 sm:mb-4 text-xs sm:text-sm">
                                <span class="flex items-center text-gray-600 bg-gray-100 px-1.5 py-0.5 sm:px-2 sm:py-1 rounded font-medium">
                                    {{ $item->ukuran }}
                                </span>

                                @php
                                    $condColor = match($item->kondisi) {
                                        'Like New' => 'text-blue-700 bg-blue-50 border-blue-100',
                                        'Good' => 'text-green-700 bg-green-50 border-green-100',
                                        'Fair' => 'text-yellow-700 bg-yellow-50 border-yellow-100',
                                        default => 'text-gray-600 bg-gray-50',
                                    };
                                @endphp
                                <span class="px-1.5 py-0.5 sm:px-2 sm:py-1 rounded font-medium border {{ $condColor }}">
                                    {{ $item->kondisi }}
                                </span>
                            </div>

                            <p class="text-gray-500 text-xs sm:text-sm line-clamp-2 mb-3 flex-grow">
                                {{ $item->deskripsi }}
                            </p>
                            
                            <div class="mt-auto pt-3 sm:pt-4 border-t border-gray-100">
                                <button onclick="openEditModal({{ json_encode($item) }})" 
                                    class="w-full inline-flex justify-center items-center px-3 py-1.5 sm:px-4 sm:py-2 bg-teal-600 border border-transparent rounded-lg font-semibold text-[10px] sm:text-xs text-white uppercase tracking-widest hover:bg-teal-700 focus:bg-teal-700 active:bg-teal-900 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Edit
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

<div id="edit-modal" class="hidden relative z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        
        <div id="edit-overlay" class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity duration-300 ease-out opacity-0"></div>

        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-0 text-center sm:items-center sm:p-0">
                
                <div id="edit-panel" class="relative transform overflow-hidden rounded-t-2xl sm:rounded-xl bg-white text-left shadow-xl transition-all duration-300 ease-out translate-y-full sm:translate-y-full sm:scale-95 w-full max-w-lg border border-gray-200">
                    
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 border-b border-gray-100 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-gray-900">Edit Barang</h3>
                        <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-500 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <form id="edit-form" method="POST" enctype="multipart/form-data">
                        @csrf @method('PUT') 
                        <div class="px-4 py-5 sm:p-6 space-y-4">
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

                        <div class="bg-gray-50 px-4 py-3 sm:px-6 flex justify-between items-center">
                            <button type="button" onclick="openDeleteModal()" class="inline-flex justify-center items-center rounded-lg border border-transparent px-3 py-2 bg-red-100 text-red-700 text-sm font-medium hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                Hapus
                            </button>

                            <div class="flex gap-2">
                                <button type="button" onclick="closeEditModal()" class="inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-3 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 sm:text-sm">
                                    Batal
                                </button>
                                <button type="submit" class="inline-flex justify-center rounded-lg border border-transparent shadow-sm px-3 py-2 bg-teal-600 text-base font-medium text-white hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 sm:text-sm">
                                    Simpan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const editModal = document.getElementById('edit-modal');
        const editOverlay = document.getElementById('edit-overlay');
        const editPanel = document.getElementById('edit-panel');
        const editForm = document.getElementById('edit-form');
        
        // ... (Variable Toast & Delete Modal Biarkan saja, fokus di sini) ...

        function openEditModal(product) {
            editForm.action = `/barang/${product.id}`;
            // Isi data form (sama seperti sebelumnya)
            document.getElementById('edit-name').value = product.name;
            document.getElementById('edit-price').value = product.price;
            document.getElementById('edit-kategori').value = product.kategori;
            document.getElementById('edit-kondisi').value = product.kondisi;
            document.getElementById('edit-ukuran').value = product.ukuran;
            document.getElementById('edit-deskripsi').value = product.deskripsi;
            
            // Delete Action
            const deleteForm = document.getElementById('delete-form');
            if(deleteForm) deleteForm.action = `/barang/${product.id}`;

            // 1. Hapus class 'hidden' dari wrapper
            editModal.classList.remove('hidden');

            // 2. Gunakan setTimeout kecil agar transisi CSS terbaca oleh browser
            setTimeout(() => {
                // Munculkan overlay (Fade In)
                editOverlay.classList.remove('opacity-0');
                
                // Naikkan panel (Slide Up)
                // Kita hapus class yang memaksa dia di bawah
                editPanel.classList.remove('translate-y-full', 'sm:translate-y-full', 'sm:scale-95');
            }, 10);
        }

        function closeEditModal() {
            // 1. Kembalikan ke state awal (Fade Out & Slide Down)
            editOverlay.classList.add('opacity-0');
            editPanel.classList.add('translate-y-full', 'sm:translate-y-full', 'sm:scale-95');

            // 2. Tunggu durasi animasi (300ms) baru tambahkan class 'hidden'
            setTimeout(() => {
                editModal.classList.add('hidden');
            }, 300); // Sesuaikan dengan duration-300 di class tailwind
        }

        // ... (Fungsi Toast & Delete Modal tetap sama) ...
        const toastSuccess = document.getElementById('toast-success');
        const deleteModal = document.getElementById('delete-modal');
        const deleteForm = document.getElementById('delete-form');

        // Logic Toast
        document.addEventListener("DOMContentLoaded", function() {
            if (toastSuccess) {
                setTimeout(() => toastSuccess.classList.remove('translate-x-full', 'opacity-0'), 100);
                setTimeout(() => closeToast(), 5000);
            }
        });
        function closeToast() {
            if(toastSuccess) {
                toastSuccess.classList.add('translate-x-full', 'opacity-0');
                setTimeout(() => toastSuccess.style.display = 'none', 500);
            }
        }

        // Logic Delete Modal
        function openDeleteModal() { deleteModal.classList.remove('hidden'); }
        function closeDeleteModal() { deleteModal.classList.add('hidden'); }
        function submitDelete() { deleteForm.submit(); }
    </script>
</x-app-layout>