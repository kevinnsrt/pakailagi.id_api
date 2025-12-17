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
                            <label class="label"><span class="label-text font-medium">Nama Barang</span></label>
                            <input name="name" type="text" class="input input-bordered w-full focus:input-accent" placeholder="Contoh: Kemeja Flannel Uniqlo" />
                        </div>

                        <div class="form-control w-full">
                            <label class="label"><span class="label-text font-medium">Ukuran</span></label>
                            <input name="ukuran" type="text" class="input input-bordered w-full focus:input-accent" placeholder="Contoh: M, L, XL, atau 42" />
                        </div>

                        <div class="form-control w-full">
                            <label class="label"><span class="label-text font-medium">Harga (IDR)</span></label>
                            <div class="relative">
                                <span class="absolute left-3 top-3 text-gray-500 text-sm">Rp</span>
                                <input name="price" type="number" class="input input-bordered w-full pl-10 focus:input-accent" placeholder="0" />
                            </div>
                        </div>

                        <div class="form-control w-full relative group">
                            <label class="label"><span class="label-text font-medium">Kondisi Barang</span></label>
                            
                            <input type="hidden" name="kondisi" id="input_kondisi">

                            <button type="button" id="btn_kondisi" onclick="toggleDropdown()" 
                                class="input input-bordered w-full text-left flex justify-between items-center bg-white">
                                <span id="text_kondisi" class="text-gray-400">Pilih Kondisi</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 opacity-50 transition-transform" id="arrow_icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                            </button>

                            <div id="list_kondisi" class="hidden absolute z-50 w-full mt-1 bg-white border border-gray-200 rounded-lg shadow-lg overflow-hidden transition-all">
                                
                                <div onclick="pilihKondisi('Like New', 'text-blue-600', 'bg-blue-50', 'border-blue-500')" 
                                     class="px-4 py-3 cursor-pointer transition-colors duration-200 hover:bg-blue-100 hover:text-blue-700 flex items-center gap-2 group-hover:bg-blue-50">
                                    <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                                    Like New
                                </div>

                                <div onclick="pilihKondisi('Good', 'text-green-600', 'bg-green-50', 'border-green-500')" 
                                     class="px-4 py-3 cursor-pointer transition-colors duration-200 hover:bg-green-100 hover:text-green-700 flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-green-500"></span>
                                    Good
                                </div>

                                <div onclick="pilihKondisi('Fair', 'text-yellow-600', 'bg-yellow-50', 'border-yellow-500')" 
                                     class="px-4 py-3 cursor-pointer transition-colors duration-200 hover:bg-yellow-100 hover:text-yellow-700 flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-yellow-500"></span>
                                    Fair
                                </div>
                            </div>
                        </div>
                        <div class="form-control w-full">
                            <label class="label"><span class="label-text font-medium">Kategori</span></label>
                            <select name="kategori" class="select select-bordered w-full focus:select-accent">
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
                            <label class="label"><span class="label-text font-medium">Foto Barang</span></label>
                            <input name="image" type="file" class="file-input file-input-bordered w-full focus:file-input-accent" />
                        </div>
                    </div>

                    <div class="form-control w-full mt-4">
                        <label class="label"><span class="label-text font-medium">Deskripsi</span></label>
                        <textarea name="deskripsi" class="textarea textarea-bordered h-24 focus:textarea-accent" placeholder="Jelaskan detail barang..."></textarea>
                    </div>

                    <div class="card-actions justify-end mt-8">
                        <button type="button" onclick="history.back()" class="btn btn-ghost hover:bg-teal-50 hover:text-teal-700">Batal</button>
                        <button type="submit" class="btn bg-teal-600 hover:bg-teal-700 text-white border-none px-8">Tambah Barang</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        function toggleDropdown() {
            const list = document.getElementById('list_kondisi');
            const arrow = document.getElementById('arrow_icon');
            list.classList.toggle('hidden');
            arrow.classList.toggle('rotate-180');
        }

        function pilihKondisi(value, textColor, bgColor, borderColor) {
            // 1. Set nilai ke hidden input (untuk dikirim ke backend)
            document.getElementById('input_kondisi').value = value;

            // 2. Ubah Teks tombol
            const textDisplay = document.getElementById('text_kondisi');
            textDisplay.innerText = value;
            
            // 3. Ubah Styling Tombol Trigger agar sesuai warna pilihan
            const btn = document.getElementById('btn_kondisi');
            
            // Reset class lama
            btn.className = 'input input-bordered w-full text-left flex justify-between items-center transition-all duration-300';
            
            // Tambahkan class warna baru
            btn.classList.add(textColor);
            btn.classList.add(bgColor);
            btn.classList.add(borderColor); // Border berwarna
            
            // Hapus style input-bordered default jika ingin border berwarna jelas
            btn.classList.remove('border-gray-300'); // asumsi border default

            // 4. Tutup dropdown
            toggleDropdown();
        }

        // Tutup dropdown jika klik di luar area
        window.onclick = function(event) {
            if (!event.target.closest('#btn_kondisi')) {
                document.getElementById('list_kondisi').classList.add('hidden');
                document.getElementById('arrow_icon').classList.remove('rotate-180');
            }
        }
    </script>
</x-app-layout>