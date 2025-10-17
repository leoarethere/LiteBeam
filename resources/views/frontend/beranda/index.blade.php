{{-- 
    ✅ PENYEMPURNAAN:
    - Menggunakan Blade directive @forelse untuk menyederhanakan perulangan dan penanganan kondisi kosong.
    - Mengganti URL hard-coded dengan helper route() untuk URL yang lebih dinamis dan mudah dikelola.
    - Menambahkan komentar untuk menjelaskan setiap bagian dan perubahan.
    - Memastikan konsistensi penulisan kode dan kerapian.
--}}
<x-layout>
    <x-slot:title>{{ $title ?? 'Beranda' }}</x-slot:title>

    {{-- Kontainer utama untuk menyamakan lebar dengan komponen lain --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Komponen Hero Carousel --}}
        <x-hero-carousel :slides="$heroSlides" />

        {{-- SEKSI BERITA TERBARU --}}
        <section class="py-12 md:py-16">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                        Berita Terbaru
                    </h2>
                    <p class="text-gray-600 dark:text-gray-400">
                        Informasi terkini dari TVRI Yogyakarta
                    </p>
                </div>
                <a href="{{ route('posts.index') }}" 
                   class="hidden sm:inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 font-semibold group">
                    Lihat Semua
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </a>
            </div>

            {{-- Grid Postingan --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                {{-- ✅ PENYEMPURNAAN: Menggunakan @forelse untuk loop yang lebih bersih --}}
                @forelse($latestPosts as $post)
                    <x-post-card :post="$post" />
                @empty
                    {{-- Kondisi jika tidak ada postingan --}}
                    <div class="md:col-span-2 lg:col-span-3 text-center py-16 bg-gray-50 dark:bg-gray-800/50 rounded-lg">
                        <svg class="mx-auto h-16 w-16 text-gray-400 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                        </svg>
                        <p class="text-gray-600 dark:text-gray-400 text-lg">Belum ada berita tersedia saat ini.</p>
                    </div>
                @endforelse
            </div>
            
            {{-- Tombol "Lihat Semua" untuk mobile --}}
            @if(isset($latestPosts) && $latestPosts->count() > 0)
                <div class="mt-8 text-center sm:hidden">
                    <a href="{{ route('posts.index') }}" 
                       class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition-colors">
                        Lihat Semua Berita
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </a>
                </div>
            @endif
        </section>

        {{-- SEKSI KATEGORI --}}
        <section class="py-12 md:py-16">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-8 text-center md:text-left">
                Kategori Berita
            </h2>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                {{-- ✅ PENYEMPURNAAN: Menggunakan @forelse dan helper route() --}}
                @forelse($categories as $category)
                    <a href="{{ route('posts.index', ['category' => $category->slug]) }}" 
                       class="group p-6 bg-white dark:bg-gray-800 rounded-lg border-2 border-gray-200 dark:border-gray-700 hover:border-blue-500 dark:hover:border-blue-500 transition-all hover:shadow-lg transform hover:-translate-y-1">
                        <div class="flex flex-col items-center text-center">
                            <div class="w-12 h-12 mb-3 rounded-full {{ $category->color_classes ?? 'bg-gray-200 text-gray-800' }} flex items-center justify-center text-2xl font-bold">
                                {{ substr($category->name, 0, 1) }}
                            </div>
                            <h3 class="font-semibold text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                {{ $category->name }}
                            </h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                {{ $category->posts_count ?? 0 }} artikel
                            </p>
                        </div>
                    </a>
                @empty
                    {{-- Kondisi jika tidak ada kategori --}}
                    <div class="col-span-full text-center py-12 text-gray-500 dark:text-gray-400">
                        <p>Belum ada kategori yang tersedia.</p>
                    </div>
                @endforelse
            </div>
        </section>

        {{-- SEKSI STATISTIK --}}
        <section class="py-12 md:py-16">
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-2xl p-8 md:p-12 text-white">
                <h2 class="text-2xl md:text-3xl font-bold mb-8 text-center">TVRI Yogyakarta dalam Angka</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                    <div class="text-center">
                        <div class="text-4xl md:text-5xl font-bold mb-2">{{ $stats['posts'] ?? 0 }}+</div>
                        <div class="text-blue-100 text-sm md:text-base">Artikel Berita</div>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl md:text-5xl font-bold mb-2">{{ $stats['categories'] ?? 0 }}+</div>
                        <div class="text-blue-100 text-sm md:text-base">Kategori</div>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl md:text-5xl font-bold mb-2">{{ $stats['users'] ?? 0 }}+</div>
                        <div class="text-blue-100 text-sm md:text-base">Penulis</div>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl md:text-5xl font-bold mb-2">24/7</div>
                        <div class="text-blue-100 text-sm md:text-base">Siaran Online</div>
                    </div>
                </div>
            </div>
        </section>

        {{-- SEKSI CALL TO ACTION (CTA) --}}
        <section class="py-12 md:py-16 text-center bg-gray-50 dark:bg-gray-800/50 rounded-2xl p-12 mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                Tetap Terhubung dengan Kami
            </h2>
            <p class="text-lg text-gray-600 dark:text-gray-400 mb-8 max-w-2xl mx-auto">
                Dapatkan informasi terbaru dan berita terkini langsung dari TVRI Yogyakarta.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('contact') }}" {{-- ✅ Ganti dengan nama route yang sesuai --}}
                   class="inline-flex items-center justify-center gap-2 px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    Hubungi Kami
                </a>
                <a href="{{ route('about') }}" {{-- ✅ Ganti dengan nama route yang sesuai --}}
                   class="inline-flex items-center justify-center gap-2 px-8 py-3 bg-white dark:bg-gray-700 text-gray-900 dark:text-white border-2 border-gray-300 dark:border-gray-600 hover:border-gray-400 dark:hover:border-gray-500 rounded-lg font-semibold transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Tentang Kami
                </a>
            </div>
        </section>

    </div>
</x-layout>