<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Promosi & Notifikasi') }}
        </h2>
    </x-slot>

    @if(session('success'))
        <div id="toast-success" class="fixed top-0 left-0 right-0 z-[100] flex justify-center transition-all duration-500 ease-in-out -translate-y-full opacity-0 pointer-events-none px-4">
            <div class="relative mt-6 flex items-center w-full max-w-lg p-5 text-gray-600 bg-white rounded-xl shadow-2xl pointer-events-auto overflow-hidden">
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
                <div id="toast-progress" class="absolute bottom-0 left-0 h-1.5 bg-teal-500 w-full transition-all duration-[5000ms] ease-linear"></div>
            </div>
        </div>
    @endif

    <div class="py-6 bg-gray-50 min-h-screen w-full overflow-x-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Buat Promosi Baru</h3>
                    
                    <form action="{{ route('promosi.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Judul Promosi</label>
                            <input type="text" name="title" class="shadow-sm appearance-none border border-gray-300 rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent" placeholder="Contoh: Diskon Akhir Tahun!" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Isi Pesan</label>
                            <textarea name="body" rows="4" class="shadow-sm appearance-none border border-gray-300 rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent" placeholder="Dapatkan potongan harga 50%..." required></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Gambar Banner</label>
                            <input type="file" name="image" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100" required>
                        </div>

                        <div class="flex items-center justify-end">
                            <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition shadow-md">
                                Kirim Notifikasi
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Riwayat Promosi</h3>
                    
                    <div class="space-y-4">
                        @forelse($data as $promo)
                            <div class="flex items-start border-b border-gray-100 pb-4 last:border-0">
                                <img src="{{ asset('storage/' . $promo->image_path) }}" class="w-16 h-16 object-cover rounded-md mr-4 shadow-sm border border-gray-100 flex-shrink-0">
                                <div class="flex-1 min-w-0 mr-4">
                                    <h4 class="font-bold text-gray-800 truncate">{{ $promo->title }}</h4>
                                    <p class="text-sm text-gray-600 line-clamp-2">{{ $promo->body }}</p>
                                    <p class="text-xs text-gray-400 mt-1">{{ $promo->created_at->diffForHumans() }}</p>
                                </div>
                                
                                <div class="flex flex-col space-y-2 flex-shrink-0 w-24">
                                    <button type="button" onclick="openResendModal({{ $promo->id }}, this)" 
                                        class="inline-flex justify-center items-center px-3 py-1.5 text-xs font-semibold text-blue-700 bg-blue-50 hover:bg-blue-100 border border-blue-200 rounded-lg transition focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1 w-full">
                                        Kirim Ulang
                                    </button>

                                    <button type="button" onclick="openDeleteModal({{ $promo->id }}, this)" 
                                        class="inline-flex justify-center items-center px-3 py-1.5 text-xs font-semibold text-red-700 bg-red-50 hover:bg-red-100 border border-red-200 rounded-lg transition focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-1 w-full">
                                        Hapus
                                    </button>
                                </div>
                            </div>
                        @empty
                            <div class="flex flex-col items-center justify-center py-8 text-gray-400">
                                <svg class="w-12 h-12 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                <p class="text-sm">Belum ada promosi yang dibuat.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="resend-modal" class="hidden fixed inset-0 z-[60] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div id="resend-overlay" class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity duration-300 ease-out opacity-0" onclick="closeResendModal()"></div>

        <div class="flex min-h-screen items-center justify-center p-4 text-center pointer-events-none">
            
            <div id="resend-panel" class="relative transform overflow-hidden rounded-xl bg-white text-left shadow-xl w-full max-w-sm border border-gray-200 pointer-events-auto" style="opacity: 0; transform: scale(0.95);">
                
                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                    <div>
                        <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-blue-100">
                            <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center">
                            <h3 class="text-lg font-semibold leading-6 text-gray-900">Kirim Ulang Notifikasi?</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Notifikasi ini akan dikirimkan kembali ke seluruh pengguna aplikasi.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 px-4 py-3 flex flex-col sm:flex-row-reverse sm:px-6 gap-3">
                    <button type="button" onclick="submitResend()" 
                        class="inline-flex w-full justify-center items-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 sm:w-auto transition-all">
                        Ya, Kirim
                    </button>
                    <button type="button" onclick="closeResendModal()" 
                        class="inline-flex w-full justify-center items-center rounded-lg bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-300 sm:w-auto transition-all">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div id="delete-modal" class="hidden fixed inset-0 z-[60] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div id="delete-overlay" class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity duration-300 ease-out opacity-0" onclick="closeDeleteModal()"></div>

        <div class="flex min-h-screen items-center justify-center p-4 text-center pointer-events-none">
            
            <div id="delete-panel" class="relative transform overflow-hidden rounded-xl bg-white text-left shadow-xl w-full max-w-sm border border-gray-200 pointer-events-auto" style="opacity: 0; transform: scale(0.95);">
                
                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                    <div>
                        <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100">
                            <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center">
                            <h3 class="text-lg font-semibold leading-6 text-gray-900">Hapus Riwayat?</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Riwayat promosi ini akan dihapus permanen. Tindakan ini tidak dapat dibatalkan.
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

    <form id="resend-form" method="POST" class="hidden">
        @csrf
    </form>

    <form id="delete-form" method="POST" class="hidden">
        @csrf @method('DELETE')
    </form>

    <script>
        // --- TOAST LOGIC ---
        const toastSuccess = document.getElementById('toast-success');
        const toastProgress = document.getElementById('toast-progress');

        document.addEventListener("DOMContentLoaded", function() {
            if (toastSuccess) {
                // Show
                setTimeout(() => {
                    toastSuccess.classList.remove('-translate-y-full', 'opacity-0');
                }, 100);

                // Progress Bar Animation
                if(toastProgress) {
                    setTimeout(() => {
                        toastProgress.classList.remove('w-full');
                        toastProgress.classList.add('w-0');
                    }, 200);
                }

                // Hide
                setTimeout(() => closeToast(), 5000);
            }
        });

        function closeToast() {
            if(toastSuccess) {
                toastSuccess.classList.add('-translate-y-full', 'opacity-0');
                setTimeout(() => toastSuccess.style.display = 'none', 500);
            }
        }

        // --- ANIMASI ROBUST & GENTLE (SAMA DENGAN BARANG) ---
        function animateFromButton(panel, buttonElement, overlay) {
            // Reset
            panel.style.transition = 'none';
            panel.style.opacity = '0';
            panel.style.transform = 'scale(0.95)';
            
            // Hitung Posisi
            if (buttonElement) {
                const btnRect = buttonElement.getBoundingClientRect();
                const panelRect = panel.getBoundingClientRect();
                
                const btnX = btnRect.left + btnRect.width / 2;
                const btnY = btnRect.top + btnRect.height / 2;
                const originX = btnX - panelRect.left;
                const originY = btnY - panelRect.top;

                panel.style.transformOrigin = `${originX}px ${originY}px`;
            } else {
                panel.style.transformOrigin = 'center center';
            }

            // Force Reflow
            void panel.offsetWidth;

            // Animate
            panel.style.transition = 'all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1)'; 
            requestAnimationFrame(() => {
                overlay.classList.remove('opacity-0');
                panel.style.opacity = '1';
                panel.style.transform = 'scale(1)';
            });
        }

        function animateClose(panel, overlay, callbackWrapper) {
            panel.style.transition = 'all 0.2s ease-in';
            panel.style.opacity = '0';
            panel.style.transform = 'scale(0.95)';
            overlay.classList.add('opacity-0');
            setTimeout(callbackWrapper, 200);
        }

        // --- RESEND MODAL LOGIC ---
        const resendModal = document.getElementById('resend-modal');
        const resendOverlay = document.getElementById('resend-overlay');
        const resendPanel = document.getElementById('resend-panel');
        const resendForm = document.getElementById('resend-form');

        function openResendModal(id, buttonElement) {
            resendForm.action = `/promosi/${id}/resend`;
            resendModal.classList.remove('hidden');
            animateFromButton(resendPanel, buttonElement, resendOverlay);
        }

        function closeResendModal() {
            animateClose(resendPanel, resendOverlay, () => {
                resendModal.classList.add('hidden');
            });
        }

        function submitResend() {
            resendForm.submit();
        }

        // --- DELETE MODAL LOGIC ---
        const deleteModal = document.getElementById('delete-modal');
        const deleteOverlay = document.getElementById('delete-overlay');
        const deletePanel = document.getElementById('delete-panel');
        const deleteForm = document.getElementById('delete-form');

        function openDeleteModal(id, buttonElement) {
            deleteForm.action = `/promosi/${id}`;
            deleteModal.classList.remove('hidden');
            animateFromButton(deletePanel, buttonElement, deleteOverlay);
        }

        function closeDeleteModal() {
            animateClose(deletePanel, deleteOverlay, () => {
                deleteModal.classList.add('hidden');
            });
        }

        function submitDelete() {
            deleteForm.submit();
        }
    </script>
</x-app-layout>