<!DOCTYPE html>
<html lang="id" class="h-full bg-gray-800 scroll-smooth overflow-x-hidden">
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
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

{{-- PERBAIKAN 1: Hapus kelas yang tidak perlu dari body --}}
<body class="bg-gray-900 text-gray-200 antialiased">
    {{-- Struktur flex untuk sticky footer --}}
    <div class="flex flex-col min-h-screen">
        <x-navbar/>
        {{-- PERBAIKAN 2: Tambahkan 'pt-16' untuk memberi ruang bagi navbar --}}
        <main class="flex-grow pt-16">
            {{-- PERBAIKAN 3: Gunakan kontainer yang konsisten dengan halaman lain --}}
            {{-- Padding vertikal (py-8) ditambahkan di sini untuk jarak atas/bawah konten --}}
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-0 py-8">
                {{ $slot }}
            </div>
        </main>
        <x-footer/>
    </div>
</body>
</html>