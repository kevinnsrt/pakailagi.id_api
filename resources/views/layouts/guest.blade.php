<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Tailwind CSS + DaisyUI CDN (sementara) -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.3/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5.0.0/dist/full.css" rel="stylesheet">

    <!-- Vite (tetap disertakan, tapi jika gagal tidak fatal) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen flex flex-col justify-center items-center px-4">

        <!-- Logo -->
        <div class="mb-6">
            <a href="/">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-20 w-auto drop-shadow-sm" />
            </a>
        </div>

        <!-- Content Card -->
        <div class="w-full sm:max-w-md px-6 py-8 bg-white shadow-xl overflow-hidden sm:rounded-2xl border border-gray-100">
            {{ $slot }}
        </div>
    </div>
</body>
</html>
