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
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
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

        <div id="global-toast-container" class="fixed top-20 right-4 z-[100] flex flex-col gap-3 pointer-events-none">
            </div>

        <audio id="notif-sound" src="https://assets.mixkit.co/active_storage/sfx/2869/2869-preview.mp3" preload="auto"></audio>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Format Waktu Awal (UTC to Local String format YYYY-MM-DD HH:mm:ss simple approximation)
                // Kita gunakan waktu client saat ini dikurangi sedikit buffer sebagai titik mulai
                let lastCheckTime = new Date(Date.now() - 5000).toISOString().slice(0, 19).replace('T', ' ');

                // Jalankan pengecekan setiap 5 detik (5000ms)
                setInterval(() => {
                    // Pastikan route 'api.check.notif' sudah dibuat di web.php
                    fetch(`{{ route('api.check.notif') }}?last_check=${lastCheckTime}`)
                        .then(response => response.json())
                        .then(data => {
                            // Update waktu terakhir check dengan waktu server agar sinkron
                            if(data.server_time) {
                                lastCheckTime = data.server_time;
                            }

                            // A. Notifikasi Pesanan Baru (Checkout)
                            if (data.new_orders && data.new_orders.length > 0) {
                                playNotificationSound();
                                data.new_orders.forEach(order => {
                                    showGlobalToast(
                                        `💰 Pesanan Masuk!`, 
                                        `${order.user ? order.user.name : 'Seseorang'} baru saja checkout pesanan.`, 
                                        'bg-teal-600'
                                    );
                                });
                            }

                            // B. Notifikasi Masuk Keranjang
                            if (data.new_carts && data.new_carts.length > 0) {
                                // Opsional: Matikan playNotificationSound() disini jika tidak ingin bunyi saat masuk keranjang
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
                        .catch(error => {
                            // Silent fail agar tidak mengganggu console jika user offline sebentar
                            // console.error('Polling error:', error); 
                        });
                }, 5000); 
            });

            // Fungsi Membuat Elemen Toast
            function showGlobalToast(title, message, bgColor) {
                const container = document.getElementById('global-toast-container');
                
                // Buat elemen div
                const toast = document.createElement('div');
                // Styling Tailwind
                toast.className = `transform transition-all duration-500 ease-out translate-x-full opacity-0 flex items-center w-80 p-4 text-white rounded-xl shadow-2xl pointer-events-auto ${bgColor} border border-white/20`;
                
                toast.innerHTML = `
                    <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-white bg-white/20 rounded-full">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    </div>
                    <div class="ml-3 text-sm font-normal">
                        <span class="font-bold block text-sm">${title}</span>
                        <span class="text-xs opacity-90 leading-tight">${message}</span>
                    </div>
                    <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-transparent text-white hover:bg-white/20 rounded-lg p-1.5 inline-flex h-8 w-8 items-center justify-center transition" onclick="this.parentElement.remove()">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 14 14"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/></svg>
                    </button>
                `;

                container.appendChild(toast);

                // Animasi Masuk (Slide In)
                requestAnimationFrame(() => {
                    toast.classList.remove('translate-x-full', 'opacity-0');
                });

                // Hapus Otomatis setelah 5 detik
                setTimeout(() => {
                    toast.classList.add('translate-x-full', 'opacity-0'); // Slide Out
                    setTimeout(() => toast.remove(), 500); // Hapus dari DOM
                }, 5000);
            }

            // Fungsi Play Sound
            function playNotificationSound() {
                const audio = document.getElementById('notif-sound');
                if(audio) {
                    audio.play().catch(e => {
                        // Browser modern memblokir autoplay audio jika user belum berinteraksi dengan halaman.
                        // Ini normal. Audio akan bunyi setelah user klik sembarang tempat di halaman.
                        console.log("Audio autoplay blocked waiting for interaction");
                    });
                }
            }
        </script>
    </body>
</html>