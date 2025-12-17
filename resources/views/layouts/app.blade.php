<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300..700&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased overflow-x-hidden"> <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main>
                {{ $slot }}
            </main>
        </div>

        <div id="global-toast-container" class="fixed top-24 right-0 z-[100] flex flex-col gap-3 pointer-events-none p-4 overflow-hidden w-full sm:w-auto items-end">
            </div>

        <audio id="notif-sound" src="https://assets.mixkit.co/active_storage/sfx/2869/2869-preview.mp3" preload="auto"></audio>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                let lastCheckTime = new Date(Date.now() - 5000).toISOString().slice(0, 19).replace('T', ' ');

                // POLLING SETIAP 5 DETIK
                setInterval(() => {
                    fetch(`{{ route('api.check.notif') }}?last_check=${lastCheckTime}`)
                        .then(response => response.json())
                        .then(data => {
                            if(data.server_time) lastCheckTime = data.server_time;

                            // Notif Pesanan
                            if (data.new_orders && data.new_orders.length > 0) {
                                playNotificationSound();
                                data.new_orders.forEach(order => {
                                    showGlobalToast(
                                        `💰 Pesanan Masuk!`, 
                                        `${order.user ? order.user.name : 'Seseorang'} baru saja checkout.`, 
                                        'bg-teal-600'
                                    );
                                });
                            }

                            // Notif Keranjang
                            if (data.new_carts && data.new_carts.length > 0) {
                                data.new_carts.forEach(cart => {
                                    const productName = cart.product ? cart.product.name : 'Produk';
                                    showGlobalToast(
                                        `🛒 Masuk Keranjang`, 
                                        `Seseorang menambahkan "${productName}" ke keranjang.`, 
                                        'bg-blue-600'
                                    );
                                });
                            }
                        })
                        .catch(error => {});
                }, 5000); 
            });

            // FUNGSI MEMUNCULKAN TOAST (SLIDE KANAN + TIMER)
            function showGlobalToast(title, message, bgColor) {
                const container = document.getElementById('global-toast-container');
                
                // Buat elemen div Toast
                const toast = document.createElement('div');
                
                // Styling:
                // - translate-x-full (mulai dari luar layar kanan)
                // - overflow-hidden (agar timer line rapi)
                // - pointer-events-auto (agar bisa diklik close)
                toast.className = `
                    relative transform transition-all duration-500 ease-out translate-x-[120%] 
                    flex items-center w-80 max-w-[90vw] p-4 text-white rounded-xl shadow-2xl 
                    pointer-events-auto ${bgColor} border border-white/20 overflow-hidden mb-2
                `;
                
                toast.innerHTML = `
                    <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-white bg-white/20 rounded-full">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    </div>
                    
                    <div class="ml-3 text-sm font-normal flex-1">
                        <span class="font-bold block text-sm">${title}</span>
                        <span class="text-xs opacity-90 leading-tight block mt-0.5">${message}</span>
                    </div>
                    
                    <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-transparent text-white hover:bg-white/20 rounded-lg p-1.5 inline-flex h-8 w-8 items-center justify-center transition z-10" onclick="closeToastManually(this.parentElement)">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 14 14"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/></svg>
                    </button>

                    <div class="toast-timer absolute bottom-0 left-0 h-1.5 bg-white/40 w-full transition-all ease-linear" style="transition-duration: 5000ms;"></div>
                `;

                container.appendChild(toast);

                // 1. ANIMASI SLIDE IN (Masuk dari kanan)
                requestAnimationFrame(() => {
                    // Hapus translate agar masuk ke layar
                    toast.classList.remove('translate-x-[120%]');
                });

                // 2. ANIMASI TIMER BERKURANG
                // Kita beri delay sedikit agar transisi slide in mulai dulu
                setTimeout(() => {
                    const timerLine = toast.querySelector('.toast-timer');
                    if(timerLine) {
                        timerLine.classList.remove('w-full');
                        timerLine.classList.add('w-0'); // Menyusut ke 0
                    }
                }, 100);

                // 3. AUTO CLOSE SETELAH 5 DETIK
                setTimeout(() => {
                    closeToastManually(toast);
                }, 5100); // 5000ms timer + 100ms buffer
            }

            // Fungsi Menutup Toast (Slide Out ke kanan lalu hapus)
            function closeToastManually(toastElement) {
                // Slide ke kanan (keluar layar)
                toastElement.classList.add('translate-x-[120%]', 'opacity-0');
                
                // Tunggu animasi slide selesai (500ms), lalu hapus dari DOM
                setTimeout(() => {
                    if(toastElement && toastElement.parentElement) {
                        toastElement.remove();
                    }
                }, 500);
            }

            function playNotificationSound() {
                const audio = document.getElementById('notif-sound');
                if(audio) {
                    audio.play().catch(e => console.log("Audio autoplay waiting interaction"));
                }
            }
        </script>
    </body>
</html>