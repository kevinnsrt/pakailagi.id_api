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
                                        class="input input-bordered w-full focus:outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 rounded-lg" 
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
                                <input name="image" type="file" 
                                    class="file-input file-input-bordered w-full file-input-ghost focus:outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 rounded-lg text-sm text-gray-500
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-full file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-teal-50 file:text-teal-700
                                    hover:file:bg-teal-100" />
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
</x-app-layout>