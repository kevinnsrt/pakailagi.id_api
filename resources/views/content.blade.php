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

<div id="delete-modal" class="hidden fixed inset-0 z-[60] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity"></div>

        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            
            <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 w-full max-w-lg border border-gray-200">
                
                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                    <div>
                        
                        <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100">
                            <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                            </svg>
                        </div>

                        <div class="mt-3 text-center">
                            <h3 class="text-lg font-semibold leading-6 text-gray-900" id="modal-title">Hapus Barang?</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Apakah Anda yakin ingin menghapus barang ini secara permanen? <br>
                                    <span class="text-red-500 font-medium">Tindakan ini tidak dapat dibatalkan.</span>
                                </p>
                            </div>
                        </div>
                        
                    </div>
                </div>

                <div class="bg-gray-50 px-4 py-3 flex flex-col sm:flex-row-reverse sm:px-6 gap-3">
                    <button type="button" onclick="submitDelete()" 
                        class="inline-flex w-full justify-center items-center rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:w-auto transition-all">
                        Ya, Hapus
                    </button>
                    <button type="button" onclick="closeDeleteModal()" 
                        class="inline-flex w-full justify-center items-center rounded-lg bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-300 sm:w-auto transition-all">
                        Batal
                    </button>
                </div>

            </div>
        </div>
    </div>

    <form id="delete-form" method="POST" class="hidden">
        @csrf @method('DELETE')
    </form>

    <script>
        const toastSuccess = document.getElementById('toast-success');
        const editModal = document.getElementById('edit-modal');
        const editForm = document.getElementById('edit-form');
        const deleteModal = document.getElementById('delete-modal');
        const deleteForm = document.getElementById('delete-form');

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

        function openEditModal(product) {
            editForm.action = `/barang/${product.id}`;
            deleteForm.action = `/barang/${product.id}`;

            document.getElementById('edit-name').value = product.name;
            document.getElementById('edit-price').value = product.price;
            document.getElementById('edit-kategori').value = product.kategori;
            document.getElementById('edit-kondisi').value = product.kondisi;
            document.getElementById('edit-ukuran').value = product.ukuran;
            document.getElementById('edit-deskripsi').value = product.deskripsi;

            editModal.classList.remove('hidden');
        }

        function closeEditModal() {
            editModal.classList.add('hidden');
        }

        function openDeleteModal() {
            deleteModal.classList.remove('hidden');
        }

        function closeDeleteModal() {
            deleteModal.classList.add('hidden');
        }

        function submitDelete() {
            deleteForm.submit();
        }
    </script>
</x-app-layout>