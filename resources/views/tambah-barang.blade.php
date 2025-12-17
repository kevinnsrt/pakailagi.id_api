<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tambah Barang Baru') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <form method="POST" action="{{ route('tambah-barang-post') }}" enctype="multipart/form-data">
                @csrf
                
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl border border-gray-100">
                    
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                        <h3 class="text-lg font-medium text-gray-900">Formulir Produk</h3>
                        <p class="mt-1 text-sm text-gray-500">Lengkapi detail barang yang akan dijual di bawah ini.</p>
                    </div>

                    <div class="p-6 md:p-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                            
                            <div class="form-control w-full">
                                <label class="label mb-1">
                                    <span class="label-text text-gray-700 font-semibold">Nama Barang</span>
                                </label>
                                <input name="name" type="text" 
                                    class="input input-bordered w-full focus:outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 rounded-lg" 
                                    placeholder="Contoh: Kemeja Flannel Uniqlo" required />
                            </div>

                            <div class="form-control w-full">
                                <label class="label mb-1">
                                    <span class="label-text text-gray-700 font-semibold">Kategori</span>
                                </label>
                                <select name="kategori" id="kategori" 
                                    class="select select-bordered w-full focus:outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 rounded-lg text-gray-700">
                                    <option disabled selected>Pilih Kategori</option>
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
                                <label class="label mb-1">
                                    <span class="label-text text-gray-700 font-semibold">Harga</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm font-bold">Rp</span>
                                    </div>
                                    <input name="price" type="number" 
                                        class="input input-bordered w-full pl-10 focus:outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 rounded-lg" 
                                        placeholder="0" required />
                                </div>
                            </div>

                            <div class="form-control w-full">
                                <label class="label mb-1">
                                    <span class="label-text text-gray-700 font-semibold">Ukuran</span>
                                </label>
                                <input name="ukuran" type="text" 
                                    class="input input-bordered w-full focus:outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 rounded-lg" 
                                    placeholder="Contoh: M, L, XL, 40, 42" />
                            </div>

                            <div class="form-control w-full">
                                <label class="label mb-1">
                                    <span class="label-text text-gray-700 font-semibold">Kondisi Barang</span>
                                </label>
                                <select name="kondisi" id="kondisi" 
                                    class="select select-bordered w-full focus:outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 rounded-lg text-gray-700">
                                    <option disabled selected>Pilih Kondisi</option>
                                    <option value="Like New" class="text-teal-600 font-medium">✨ Like New (Seperti Baru)</option>
                                    <option value="Good" class="text-green-600 font-medium">✅ Good (Baik)</option>
                                    <option value="Fair" class="text-yellow-600 font-medium">⚠️ Fair (Layak Pakai)</option>
                                </select>
                            </div>

                            <div class="form-control w-full">
                                <label class="label mb-1">
                                    <span class="label-text text-gray-700 font-semibold">Foto Barang</span>
                                </label>
                                
                                <input name="image" type="file" id="image-input" 
                                    accept="image/*" 
                                    onchange="handleFileSelect(event)"
                                    class="hidden" />

                                <div class="grid grid-cols-2 gap-4 mb-2">
                                    <button type="button" onclick="openCamera()" 
                                        class="flex items-center justify-center gap-2 px-4 py-3 bg-teal-50 text-teal-700 border border-teal-200 rounded-xl hover:bg-teal-100 transition shadow-sm">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        <span class="font-medium text-sm">Ambil Foto</span>
                                    </button>

                                    <button type="button" onclick="openGallery()" 
                                        class="flex items-center justify-center gap-2 px-4 py-3 bg-white text-gray-700 border border-gray-300 rounded-xl hover:bg-gray-50 transition shadow-sm">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        <span class="font-medium text-sm">Pilih Galeri</span>
                                    </button>
                                </div>

                                <div id="file-info" class="hidden flex items-center justify-between text-sm text-teal-600 bg-teal-50 px-3 py-2 rounded-lg border border-teal-100">
                                    <div class="flex items-center truncate">
                                        <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        <span id="filename-display" class="font-medium truncate max-w-[200px]"></span>
                                    </div>
                                    <button type="button" onclick="cancelUpload()" class="text-gray-400 hover:text-red-500 ml-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </button>
                                </div>

                                <label class="label">
                                    <span class="label-text-alt text-gray-400 text-xs mt-1">Format: JPG, PNG (Max 2MB)</span>
                                </label>
                            </div>

                            <div class="form-control w-full md:col-span-2">
                                <label class="label mb-1">
                                    <span class="label-text text-gray-700 font-semibold">Deskripsi</span>
                                </label>
                                <textarea name="deskripsi" rows="4"
                                    class="textarea textarea-bordered h-32 w-full focus:outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 rounded-lg text-base" 
                                    placeholder="Jelaskan detail barang, kondisi fisik, minus (jika ada), dan kelebihan lainnya..."></textarea>
                            </div>

                        </div>
                    </div>

                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex items-center justify-end gap-x-4">
                        <button type="button" onclick="history.back()" 
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition">
                            Batal
                        </button>
                        <button type="submit" 
                            class="px-6 py-2 text-sm font-medium text-white bg-teal-600 border border-transparent rounded-lg shadow-sm hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition shadow-teal-200">
                            Simpan Barang
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <div id="preview-modal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity backdrop-blur-sm"></div>

        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-gray-200">
                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start flex-col items-center">
                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left w-full">
                            <h3 class="text-lg font-semibold leading-6 text-gray-900 mb-4 text-center" id="modal-title">Preview Foto</h3>
                            <div class="mt-2 flex justify-center bg-gray-100 rounded-lg border border-dashed border-gray-300 p-2">
                                <img id="modal-image-preview" src="#" alt="Preview Upload" class="max-h-[300px] w-auto object-contain rounded-md shadow-sm" />
                            </div>
                            <p id="modal-filename" class="text-sm text-gray-500 mt-2 text-center break-all"></p>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-4 sm:px-6 sm:flex sm:flex-row-reverse gap-3">
                    <button type="button" onclick="closeModal()" 
                        class="inline-flex w-full justify-center items-center rounded-lg bg-teal-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition-all sm:w-auto">
                        Konfirmasi
                    </button>
                    
                    <button type="button" onclick="cancelUpload()" 
                        class="inline-flex w-full justify-center items-center rounded-lg bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-400 transition-all sm:w-auto">
                        Ganti Foto
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const imageInput = document.getElementById("image-input");
        const modal = document.getElementById("preview-modal");
        const modalImage = document.getElementById("modal-image-preview");
        const modalFilename = document.getElementById("modal-filename");
        
        const fileInfoContainer = document.getElementById("file-info");
        const filenameDisplay = document.getElementById("filename-display");

        // 1. Saat user memilih file -> Baca file -> Tampilkan Modal
        function handleFileSelect(event) {
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    // Set gambar ke modal
                    modalImage.src = e.target.result;
                    modalFilename.innerText = file.name;
                    
                    // Set nama file ke indikator form (tapi belum ditampilkan karena tertutup modal)
                    filenameDisplay.innerText = file.name;
                    
                    // Tampilkan Modal
                    modal.classList.remove("hidden");
                }
                
                reader.readAsDataURL(file);
            }
        }

        // 2. Tombol "Konfirmasi & Tutup" -> Sembunyikan Modal -> Tampilkan Nama File di Form
        function closeModal() {
            modal.classList.add("hidden");
            // Tampilkan indikator nama file di form utama
            fileInfoContainer.classList.remove("hidden");
        }

        // 3. Tombol "Ganti Foto" -> Reset Input -> Tutup Modal
        function cancelUpload() {
            imageInput.value = ""; // Reset input
            fileInfoContainer.classList.add("hidden"); // Sembunyikan info file
            filenameDisplay.innerText = "";
            modal.classList.add("hidden"); // Tutup modal
        }
    </script>

</x-app-layout>