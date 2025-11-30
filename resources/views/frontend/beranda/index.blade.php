<x-layout>
    <x-slot:title>{{ $title ?? 'Beranda' }}</x-slot:title>

    {{-- Kontainer utama untuk menyamakan lebar dengan komponen lain --}}
    {{-- 'px-4 sm:px-6 lg:px-8' sudah menangani padding horizontal --}}
    <div class="px-4 sm:px-6 lg:px-8">

        {{-- Komponen Hero Carousel --}}
        {{-- Kita asumsikan 'x-hero-carousel' tidak memiliki padding horizontal sendiri --}}
        <x-hero-carousel :slides="$heroSlides" />

        {{-- SEKSI POSTINGAN TERBARU --}}
        {{-- [PERBAIKAN] 'py-4 md:py-8' diubah menjadi 'pt-8 md:pt-12' untuk jarak dari hero --}}
        <section class="pt-8 md:pt-8">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                        Postingan Terbaru
                    </h2>
                    <p class="text-gray-600 dark:text-gray-400">
                        Konten terkini dari TVRI Yogyakarta
                    </p>
                </div>
            </div>
                
                {{-- Tombol mobile --}}
                <div class="mt-8 text-center sm:hidden">
                    <a href="{{ route('posts.index') }}" 
                       class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition-colors">
                        Lihat Semua Postingan
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </a>
                </div>
        <section class="py-12 text-center bg-gray-50 dark:bg-gray-800/50 rounded-2xl p-12 mb-8">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                Tetap Terhubung dengan Kami
            </h2>
            <p class="text-lg text-gray-600 dark:text-gray-400 mb-8 max-w-2xl mx-auto">
                Dapatkan informasi terbaru dan berita terkini langsung dari TVRI Yogyakarta.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('contact') }}"
                   class="inline-flex items-center justify-center gap-2 px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    Hubungi Kami
                </a>
                <a href="{{ route('about') }}"
                   class="inline-flex items-center justify-center gap-2 px-8 py-3 bg-white dark:bg-gray-700 text-gray-900 dark:text-white border-2 border-gray-300 dark:border-gray-600 hover:border-gray-400 dark:hover:border-gray-500 rounded-lg font-semibold transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Tentang Kami
                </a>
            </div>
        </section>

    </div>
</x-layout>