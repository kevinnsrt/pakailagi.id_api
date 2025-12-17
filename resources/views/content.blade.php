<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Daftar Barang') }}
            </h2>
            <a href="{{ route('tambah-barang') }}" class="px-4 py-2 bg-teal-600 text-white text-sm font-medium rounded-lg hover:bg-teal-700 transition shadow-sm">
                + Tambah Barang
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-50 border-l-4 border-green-500 text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl border border-gray-100">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-500">
                        <thead class="bg-gray-50 text-xs uppercase text-gray-700 border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-4">Foto</th>
                                <th class="px-6 py-4">Nama Barang</th>
                                <th class="px-6 py-4">Kategori</th>
                                <th class="px-6 py-4">Harga</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($data as $item)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4">
                                        <div class="h-12 w-12 rounded-lg bg-gray-100 overflow-hidden border border-gray-200">
                                            <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}" class="h-full w-full object-cover">
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-900">{{ $item->name }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 text-xs font-semibold bg-gray-100 text-gray-600 rounded-md border border-gray-200">
                                            {{ $item->kategori }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-gray-900">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $item->status == 'Ready' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                            {{ $item->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <button onclick="editProduct({{ json_encode($item) }})" 
                                                class="p-2 bg-yellow-50 text-yellow-600 hover:bg-yellow-100 rounded-lg transition border border-yellow-200">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                            </button>

                                            <form action="#" method="POST" onsubmit="return confirm('Yakin hapus?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="p-2 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg transition border border-red-200">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">Belum ada barang yang dijual.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="edit-modal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity backdrop-blur-sm"></div>

        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl border border-gray-200">
                
                <div class="bg-gray-50 px-4 py-3 sm:px-6 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-lg font-semibold leading-6 text-gray-900" id="modal-title">Edit Barang</h3>
                    <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <form id="edit-form" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT') <div class="px-4 py-5 sm:p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <div class="form-control w-full">
                                <label class="label mb-1 font-semibold text-gray-700 text-sm">Nama Barang</label>
                                <input type="text" name="name" id="edit-name" class="input input-bordered w-full rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500" required>
                            </div>

                            <div class="form-control w-full">
                                <label class="label mb-1 font-semibold text-gray-700 text-sm">Kategori</label>
                                <select name="kategori" id="edit-kategori" class="select select-bordered w-full rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500">
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
                                <label class="label mb-1 font-semibold text-gray-700 text-sm">Harga (Rp)</label>
                                <input type="number" name="price" id="edit-price" class="input input-bordered w-full rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500" required>
                            </div>

                            <div class="form-control w-full">
                                <label class="label mb-1 font-semibold text-gray-700 text-sm">Ukuran</label>
                                <input type="text" name="ukuran" id="edit-ukuran" class="input input-bordered w-full rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500">
                            </div>

                            <div class="form-control w-full">
                                <label class="label mb-1 font-semibold text-gray-700 text-sm">Kondisi</label>
                                <select name="kondisi" id="edit-kondisi" class="select select-bordered w-full rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500">
                                    <option value="Like New">Like New</option>
                                    <option value="Good">Good</option>
                                    <option value="Fair">Fair</option>
                                </select>
                            </div>

                            <div class="form-control w-full">
                                <label class="label mb-1 font-semibold text-gray-700 text-sm">Ganti Foto (Opsional)</label>
                                <input type="file" name="image" class="file-input file-input-bordered w-full file-input-xs rounded-lg text-xs">
                                <p class="text-[10px] text-gray-400 mt-1">*Biarkan kosong jika tidak ingin mengganti foto.</p>
                            </div>

                            <div class="form-control w-full md:col-span-2">
                                <label class="label mb-1 font-semibold text-gray-700 text-sm">Deskripsi</label>
                                <textarea name="deskripsi" id="edit-deskripsi" rows="3" class="textarea textarea-bordered w-full rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500"></textarea>
                            </div>

                        </div>
                    </div>

                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                        <button type="submit" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-teal-600 text-base font-medium text-white hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 sm:w-auto sm:text-sm">
                            Simpan Perubahan
                        </button>
                        <button type="button" onclick="closeEditModal()" class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 sm:mt-0 sm:w-auto sm:text-sm">
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

        // Fungsi Membuka Modal & Mengisi Data
        function editProduct(product) {
            // 1. Set Action Form ke URL Update
            // Ganti 'ID_PLACEHOLDER' dengan id produk yang diklik
            // Pastikan route 'barang.update' sesuai dengan di routes/web.php
            editForm.action = `/barang/${product.id}`;

            // 2. Isi Input dengan Data Produk
            document.getElementById('edit-name').value = product.name;
            document.getElementById('edit-kategori').value = product.kategori;
            document.getElementById('edit-price').value = product.price;
            document.getElementById('edit-ukuran').value = product.ukuran;
            document.getElementById('edit-kondisi').value = product.kondisi;
            document.getElementById('edit-deskripsi').value = product.deskripsi;

            // 3. Tampilkan Modal
            editModal.classList.remove('hidden');
        }

        // Fungsi Menutup Modal
        function closeEditModal() {
            editModal.classList.add('hidden');
        }
    </script>

</x-app-layout>