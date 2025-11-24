<!DOCTYPE html>
<html lang="id {{ str_replace('_', '-', app()->getLocale()) }}" class="{{ session('theme', 'light') }} h-full bg-gray-800 scroll-smooth">
<head>
    {{-- ... (kode head Anda tidak berubah) ... --}}
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? config('app.name', 'Website') }}</title>
    <style>
        html, body {
            overscroll-behavior: none;
            overflow-x: hidden;
        }
        body {
            overscroll-behavior-y: contain;
        }

        .google-sans-flex-<uniquifier> {
        font-family: "Google Sans Flex", sans-serif;
        font-optical-sizing: auto;
        font-weight: <weight>;
        font-style: normal;
        font-variation-settings:
            "slnt" 0,
            "wdth" 100,
            "GRAD" 0,
            "ROND" 0;
        }
    </style>
    @vite([
        'resources/css/app.css', 
        'resources/js/app.js', 
        'resources/js/dashboard.js'
    ])

    {{-- 👇 TEMPELKAN KODE GOOGLE FONTS BARU DI SINI --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Google+Sans+Flex:opsz,wght@6..144,1..1000&display=swap" rel="stylesheet">
</head>

{{-- PERBAIKAN 1: Hapus kelas yang tidak perlu dari body --}}
<body class="bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200 antialiased">
    {{-- Struktur flex untuk sticky footer --}}
    <div class="flex flex-col min-h-screen">
        <x-navbar/>
        {{-- PERBAIKAN 2: Tambahkan 'pt-16' untuk memberi ruang bagi navbar --}}
        <main class="flex-grow py-[60px]">
            {{-- PERBAIKAN 3: Gunakan kontainer yang konsisten dengan halaman lain --}}
            {{-- Padding vertikal (py-8) ditambahkan di sini untuk jarak atas/bawah konten --}}
            <div class="container px-0 sm:px-0 lg:px-0 py-11 lg:py-11 relative mx-auto">
                {{ $slot }}
            </div>
        </main>
        <x-footer/>
    </div>
</body>
</html>