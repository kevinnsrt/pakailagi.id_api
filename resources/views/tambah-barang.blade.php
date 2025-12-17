<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tambah Barang Baru') }}
            </h2>
        </div>
    </x-slot>

    <div id="loading-overlay" class="hidden fixed inset-0 z-[9999] bg-black/60 backdrop-blur-sm grid place-items-center transition-opacity duration-300">
        <div class="bg-white p-6 rounded-2xl shadow-2xl flex flex-col items-center transform transition-all scale-100 mx-4">
            <div class="animate-spin rounded-full h-12 w-12 border-4 border-teal-100 border-t-teal-600 mb-4"></div>
            <p id="loading-text" class="text-gray-800 font-bold text-base text-center">Sedang Memproses...</p>
            <p class="text-gray-500 text-xs mt-1 text-center">Mohon jangan tutup halaman ini.</p>
        </div>
    </div>

    @if(session('success'))
        <div id="toast-success" class="fixed top-0 left-0 right-0 z-[100] flex justify-center transition-all duration-500 ease-in-out -translate-y-full opacity-0 pointer-events-none px-4">
            <div class="mt-6 flex items-center w-full max-w-lg p-4 sm:p-5 text-gray-600 bg-white rounded-xl shadow-2xl border-t-4 border-teal-500 pointer-events-auto" role="alert">
                <div class="inline-flex items-center justify-center flex-shrink-0 w-10 h-10 text-teal-500 bg-teal-100 rounded-lg">
                    <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                    </svg>
                </div>
                <div class="ml-4 text-sm sm:text-base font-medium text-gray-800 flex-grow">{{ session('success') }}</div>
                <button type="button" onclick="closeToast()" class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-2 hover:bg-gray-100 inline-flex items-center justify-center h-9 w-9 transition">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                </button>
            </div>
        </div>
    @endif

    <div class="py-12 bg-gray-50 min-h-screen w-full overflow-x-hidden">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            
            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-md shadow-sm text-sm">
                    <p class="font-bold">Gagal menyimpan!</p>
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="upload-form" method="POST" action="{{ route('tambah-barang-post') }}" enctype="multipart/form-data">
                @csrf
                
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl border border-gray-100 w-full">
                    
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
                                <input name="name" type="text" value="{{ old('name') }}"
                                    class="input input-bordered h-12 w-full text-base focus:outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 rounded-lg" 
                                    placeholder="Contoh: Kemeja Flannel Uniqlo" required />
                            </div>

                            <div class="form-control w-full">
                                <label class="label mb-1">
                                    <span class="label-text text-gray-700 font-semibold">Kategori</span>
                                </label>
                                <select name="kategori" id="kategori" 
                                    class="select select-bordered h-12 w-full text-base focus:outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 rounded-lg text-gray-700">
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
    <div class="relative w-full">
        <div id="price-scrub-handle" 
             class="absolute inset-y-0 left-0 pl-3 flex items-center cursor-ew-resize select-none z-10 hover:text-teal-600 transition-colors group"
             title="Tahan dan geser kiri/kanan untuk atur harga">
            <span class="text-gray-500 sm:text-sm font-bold group-hover:text-teal-600">Rp</span>
            <svg class="w-3 h-3 ml-1 text-gray-400 group-hover:text-teal-500 hidden sm:block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
            </svg>
        </div>

            <input name="price" id="price-input" type="number" value="{{ old('price') }}"
                class="input input-bordered h-12 w-full pl-14 text-base focus:outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 rounded-lg" 
                placeholder="0" required />
        </div>
            <label class="label">
                <span class="label-text-alt text-gray-400 text-xs">Tips: Klik & geser label "Rp" untuk atur harga cepat.</span>
            </label>
        </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const handle = document.getElementById('price-scrub-handle');
            const input = document.getElementById('price-input');
            
            let isDragging = false;
            let startX = 0;
            let startValue = 0;
            
            // Sensitivitas: Semakin besar angkanya, semakin cepat harga naik
            // 1 pixel geser = Rp 1.000
            const SENSITIVITY = 1000; 

            // --- LOGIKA MOUSE (DESKTOP) ---
            handle.addEventListener('mousedown', function(e) {
                isDragging = true;
                startX = e.clientX;
                // Jika input kosong, anggap 0
                startValue = parseInt(input.value) || 0;
                
                // Ubah cursor body agar tetap resize walau mouse keluar dari handle
                document.body.style.cursor = 'ew-resize';
                // Hindari seleksi teks saat drag
                document.body.style.userSelect = 'none';
            });

            // --- LOGIKA TOUCH (MOBILE) ---
            handle.addEventListener('touchstart', function(e) {
                isDragging = true;
                startX = e.touches[0].clientX;
                startValue = parseInt(input.value) || 0;
                // Prevent scroll layar saat drag harga
                e.preventDefault(); 
            }, { passive: false });

            // --- FUNGSI UPDATE NILAI (SHARED) ---
            const handleMove = (clientX) => {
                if (!isDragging) return;

                const currentX = clientX;
                // Hitung jarak geser (delta)
                const deltaX = currentX - startX;
                
                // Hitung harga baru
                let newValue = startValue + (deltaX * SENSITIVITY);
                
                // Pastikan tidak minus
                if (newValue < 0) newValue = 0;

                input.value = newValue;
            };

            // --- FUNGSI STOP DRAG ---
            const stopDrag = () => {
                if (isDragging) {
                    isDragging = false;
                    document.body.style.cursor = 'default';
                    document.body.style.userSelect = 'auto';
                }
            };

            // --- GLOBAL LISTENERS (Agar bisa drag sampai keluar elemen) ---
            
            // Desktop
            document.addEventListener('mousemove', (e) => handleMove(e.clientX));
            document.addEventListener('mouseup', stopDrag);

            // Mobile
            document.addEventListener('touchmove', (e) => {
                if(isDragging) handleMove(e.touches[0].clientX);
            });
            document.addEventListener('touchend', stopDrag);
        });
    </script>

                            <div class="form-control w-full">
                                <label class="label mb-1">
                                    <span class="label-text text-gray-700 font-semibold">Ukuran</span>
                                </label>
                                <input name="ukuran" type="text" value="{{ old('ukuran') }}"
                                    class="input input-bordered h-12 w-full text-base focus:outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 rounded-lg" 
                                    placeholder="Contoh: M, L, XL, 40, 42" />
                            </div>

                            <div class="form-control w-full">
                                <label class="label mb-1">
                                    <span class="label-text text-gray-700 font-semibold">Kondisi Barang</span>
                                </label>
                                <select name="kondisi" id="kondisi" 
                                    class="select select-bordered h-12 w-full text-base focus:outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 rounded-lg text-gray-700">
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
                                    class="hidden md:block file-input file-input-bordered h-12 w-full focus:outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 rounded-lg text-sm text-gray-500
                                    file:h-full file:mr-4 file:py-2 file:px-4
                                    file:rounded-l-lg file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-teal-50 file:text-teal-700
                                    hover:file:bg-teal-100" />

                                <div class="md:hidden grid grid-cols-2 gap-4 mb-2 w-full">
                                    <button type="button" onclick="openCamera()" 
                                        class="flex flex-col items-center justify-center gap-2 px-4 py-4 bg-teal-50 text-teal-700 border border-teal-200 rounded-xl hover:bg-teal-100 transition shadow-sm active:scale-95 w-full">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        <span class="font-medium text-sm">Ambil Foto</span>
                                    </button>

                                    <button type="button" onclick="openGallery()" 
                                        class="flex flex-col items-center justify-center gap-2 px-4 py-4 bg-white text-gray-700 border border-gray-300 rounded-xl hover:bg-gray-50 transition shadow-sm active:scale-95 w-full">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        <span class="font-medium text-sm">Pilih Galeri</span>
                                    </button>
                                </div>

                                <div id="file-info" class="hidden md:hidden mt-3 flex items-center justify-between text-sm text-teal-600 bg-teal-50 px-3 py-3 rounded-lg border border-teal-100 w-full">
                                    <div class="flex items-center truncate overflow-hidden">
                                        <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        <div class="truncate">
                                            <span id="filename-display" class="font-medium truncate block"></span>
                                            <span id="filesize-display" class="text-xs text-teal-500 block"></span>
                                        </div>
                                    </div>
                                    <button type="button" onclick="cancelUpload()" class="text-gray-400 hover:text-red-500 ml-2 p-1 flex-shrink-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </button>
                                </div>
                                
                                <label class="label md:hidden">
                                    <span class="label-text-alt text-gray-400 text-xs mt-1">Otomatis kompres jika > 1MB</span>
                                </label>

                                @error('image')
                                    <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-control w-full md:col-span-2">
                                <label class="label mb-1">
                                    <span class="label-text text-gray-700 font-semibold">Deskripsi</span>
                                </label>
                                <textarea name="deskripsi" rows="4"
                                    class="textarea textarea-bordered h-32 w-full text-base focus:outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 rounded-lg" 
                                    placeholder="Jelaskan detail barang, kondisi fisik, minus (jika ada), dan kelebihan lainnya...">{{ old('deskripsi') }}</textarea>
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

    <div id="preview-modal" class="hidden relative z-[150]" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div id="preview-overlay" class="fixed inset-0 bg-black/80 backdrop-blur-sm transition-opacity duration-300 ease-out opacity-0" onclick="closeModal()"></div>

        <div class="fixed inset-0 z-10 w-full h-full overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                
                <div id="preview-panel" class="relative transform overflow-hidden rounded-xl bg-white text-left shadow-xl transition-all w-full max-w-lg border border-gray-200" style="opacity: 0; transform: scale(0.95);">
                    
                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <div class="flex flex-col items-center">
                            <div class="mt-2 text-center w-full">
                                <h3 class="text-lg font-bold leading-6 text-gray-900 mb-4" id="modal-title">Preview Foto</h3>
                                
                                <div class="relative flex justify-center bg-gray-100 rounded-lg border border-dashed border-gray-300 p-2">
                                    <img id="modal-image-preview" src="#" alt="Preview Upload" class="max-h-[60vh] w-auto max-w-full object-contain rounded-md shadow-sm" />
                                </div>

                                <div class="mt-3 space-y-1">
                                    <p id="modal-filename" class="text-sm font-medium text-gray-700 truncate px-4"></p>
                                    <p id="modal-filesize" class="text-xs text-teal-600 font-bold"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 px-4 py-4 sm:px-6 flex flex-col-reverse sm:flex-row sm:justify-end gap-3">
                        <button type="button" onclick="cancelUpload()" 
                            class="w-full sm:w-auto inline-flex justify-center items-center rounded-lg bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-400 transition-all">
                            Ganti Foto
                        </button>
                        <button type="button" onclick="closeModal()" 
                            class="w-full sm:w-auto inline-flex justify-center items-center rounded-lg bg-teal-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition-all">
                            Konfirmasi
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // --- TOAST & UI LOGIC ---
        const toastSuccess = document.getElementById('toast-success');
        const uploadForm = document.getElementById('upload-form');
        const loadingOverlay = document.getElementById('loading-overlay');
        const loadingText = document.getElementById('loading-text');

        document.addEventListener("DOMContentLoaded", function() {
            if (toastSuccess) {
                setTimeout(() => toastSuccess.classList.remove('-translate-y-full', 'opacity-0'), 100);
                setTimeout(() => closeToast(), 5000);
            }
        });

        function closeToast() {
            if(toastSuccess) {
                toastSuccess.classList.add('-translate-y-full', 'opacity-0');
                setTimeout(() => toastSuccess.style.display = 'none', 500);
            }
        }

        uploadForm.addEventListener('submit', function() {
            loadingText.innerText = "Mengupload Barang...";
            loadingOverlay.classList.remove('hidden');
        });

        // --- COMPRESSION LOGIC ---
        async function compressImage(file, { quality = 0.7, maxWidth = 1280, type = 'image/jpeg' }) {
            return new Promise((resolve, reject) => {
                const image = new Image();
                image.src = URL.createObjectURL(file);
                image.onload = () => {
                    const canvas = document.createElement('canvas');
                    let width = image.width;
                    let height = image.height;

                    if (width > maxWidth) {
                        height *= maxWidth / width;
                        width = maxWidth;
                    }

                    canvas.width = width;
                    canvas.height = height;
                    const ctx = canvas.getContext('2d');
                    ctx.drawImage(image, 0, 0, width, height);

                    canvas.toBlob((blob) => {
                        if (!blob) { reject(new Error('Canvas is empty')); return; }
                        resolve(blob);
                    }, type, quality);
                };
                image.onerror = (error) => reject(error);
            });
        }

        // --- FILE HANDLING ---
        const imageInput = document.getElementById("image-input");
        const modal = document.getElementById("preview-modal");
        const modalOverlay = document.getElementById("preview-overlay");
        const modalPanel = document.getElementById("preview-panel");
        const modalImage = document.getElementById("modal-image-preview");
        const modalFilename = document.getElementById("modal-filename");
        const modalFilesize = document.getElementById("modal-filesize");
        
        const fileInfoContainer = document.getElementById("file-info");
        const filenameDisplay = document.getElementById("filename-display");
        const filesizeDisplay = document.getElementById("filesize-display");

        function openCamera() {
            imageInput.setAttribute('capture', 'environment'); 
            imageInput.click();
        }

        function openGallery() {
            imageInput.removeAttribute('capture');
            imageInput.click();
        }

        function formatBytes(bytes, decimals = 2) {
            if (!+bytes) return '0 Bytes';
            const k = 1024;
            const dm = decimals < 0 ? 0 : decimals;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return `${parseFloat((bytes / Math.pow(k, i)).toFixed(dm))} ${sizes[i]}`;
        }

        async function handleFileSelect(event) {
            const file = event.target.files[0];

            if (file) {
                loadingText.innerText = "Mengompres Foto...";
                loadingOverlay.classList.remove('hidden');

                try {
                    let processedFile = file;
                    
                    if (file.size > 1024 * 1024) {
                        const compressedBlob = await compressImage(file, { quality: 0.7, maxWidth: 1280 });
                        processedFile = new File([compressedBlob], file.name, {
                            type: compressedBlob.type,
                            lastModified: Date.now(),
                        });

                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(processedFile);
                        imageInput.files = dataTransfer.files;
                    }

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        modalImage.src = e.target.result;
                        modalFilename.innerText = processedFile.name;
                        modalFilesize.innerText = `Ukuran: ${formatBytes(processedFile.size)}`;
                        
                        filenameDisplay.innerText = processedFile.name;
                        filesizeDisplay.innerText = formatBytes(processedFile.size);
                        
                        loadingOverlay.classList.add('hidden');
                        
                        modal.classList.remove("hidden");
                        document.body.style.overflow = 'hidden'; 
                        
                        animateOpen(modalPanel, modalOverlay);
                    }
                    reader.readAsDataURL(processedFile);

                } catch (error) {
                    console.error("Compression failed:", error);
                    loadingOverlay.classList.add('hidden');
                    alert("Gagal memproses gambar.");
                }
            }
        }

        // --- ANIMASI MODAL ---
        function animateOpen(panel, overlay) {
            panel.style.transition = 'none';
            panel.style.opacity = '0';
            panel.style.transform = 'scale(0.95)';
            void panel.offsetWidth;
            panel.style.transition = 'all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1)';
            requestAnimationFrame(() => {
                overlay.classList.remove('opacity-0');
                panel.style.opacity = '1';
                panel.style.transform = 'scale(1)';
            });
        }

        function animateClose(panel, overlay, callback) {
            panel.style.transition = 'all 0.2s ease-in';
            panel.style.opacity = '0';
            panel.style.transform = 'scale(0.95)';
            overlay.classList.add('opacity-0');
            setTimeout(callback, 200);
        }

        function closeModal() {
            animateClose(modalPanel, modalOverlay, () => {
                modal.classList.add("hidden");
                document.body.style.overflow = 'auto'; 
                fileInfoContainer.classList.remove("hidden");
            });
        }

        function cancelUpload() {
            animateClose(modalPanel, modalOverlay, () => {
                imageInput.value = ""; 
                fileInfoContainer.classList.add("hidden");
                filenameDisplay.innerText = "";
                modal.classList.add("hidden");
                document.body.style.overflow = 'auto'; 
            });
        }
    </script>

</x-app-layout>