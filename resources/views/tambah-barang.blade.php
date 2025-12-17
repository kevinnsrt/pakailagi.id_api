<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Barang') }}
        </h2>
    </x-slot>

    <div class="py-12 px-4 sm:px-6 lg:px-8">
        <form method="POST" action="{{ route('tambah-barang-post') }}" enctype="multipart/form-data">
            @csrf
            
            <div class="card bg-base-100 w-full max-w-4xl mx-auto shadow-xl border border-base-200">
                <div class="card-body">
                    <h3 class="card-title mb-4 text-gray-700">Informasi Produk</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text font-medium">Nama Barang</span>
                            </label>
                            <input name="name" type="text" class="input input-bordered w-full focus:input-accent" placeholder="Contoh: Kemeja Flannel Uniqlo" />
                        </div>

                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text font-medium">Ukuran</span>
                            </label>
                            <input name="ukuran" type="text" class="input input-bordered w-full focus:input-accent" placeholder="Contoh: M, L, XL, atau 42" />
                        </div>

                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text font-medium">Harga (IDR)</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-3 text-gray-500 text-sm">Rp</span>
                                <input name="price" type="number" class="input input-bordered w-full pl-10 focus:input-accent" placeholder="0" />
                            </div>
                        </div>

                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text font-medium">Kondisi Barang</span>
                            </label>
                            <select name="kondisi" id="kondisi" class="select select-bordered w-full focus:select-accent">
                                <option disabled selected>Pilih Kondisi</option>
                                <option value="Like New">Like New &nbsp; 🔵</option>
                                <option value="Good">Good &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 🟢</option>
                                <option value="Fair">Fair &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 🟡</option>
                            </select>
                            <label class="label">
                                <span class="label-text-alt text-xs text-gray-400">
                                    🔵 Like New (Biru) &bull; 🟢 Good (Hijau) &bull; 🟡 Fair (Kuning)
                                </span>
                            </label>
                        </div>

                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text font-medium">Kategori</span>
                            </label>
                            <select name="kategori" id="kategori" class="select select-bordered w-full focus:select-accent">
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
                            <label class="label">
                                <span class="label-text font-medium">Foto Barang</span>
                            </label>
                            <input name="image" type="file" class="file-input file-input-bordered w-full focus:file-input-accent" />
                        </div>

                    </div>

                    <div class="form-control w-full mt-4">
                        <label class="label">
                            <span class="label-text font-medium">Deskripsi</span>
                        </label>
                        <textarea name="deskripsi" class="textarea textarea-bordered h-24 focus:textarea-accent" placeholder="Jelaskan detail barang..."></textarea>
                    </div>

                    <div class="card-actions justify-end mt-8">
                        <button type="button" onclick="history.back()" class="btn btn-ghost hover:bg-teal-50 hover:text-teal-700">Batal</button>
                        
                        <button type="submit" class="btn bg-teal-600 hover:bg-teal-700 text-white border-none px-8">
                            Tambah Barang
                        </button>
                    </div>

                </div>
            </div>
        </form>
    </div>
</x-app-layout>