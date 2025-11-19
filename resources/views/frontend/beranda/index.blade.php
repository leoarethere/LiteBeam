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
        <section class="pt-8 md:pt-12">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                        Postingan Terbaru
                    </h2>
                    <p class="text-gray-600 dark:text-gray-400">
                        Konten terkini dari TVRI Yogyakarta
                    </p>
                </div>
                
                @if(isset($latestPosts) && $latestPosts->count() > 0)
                    <a href="{{ route('posts.index') }}" 
                       class="hidden sm:inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 font-semibold group">
                        Lihat Semua Postingan
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </a>
                @endif
            </div>

            @if(isset($latestPosts) && $latestPosts->count() > 0)
                <div class="grid gap-6 xl:grid-cols-3 lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1">
                    @foreach($latestPosts->take(6) as $post)
                        <x-post-card :post="$post" />
                    @endforeach
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
            @else
                {{-- Empty state --}}
                {{-- [PERBAIKAN] 'py-16' dipertahankan karena ini adalah padding internal --}}
                <div class="text-center py-16 bg-gray-50 dark:bg-gray-800/50 rounded-lg">
                    <svg class="mx-auto h-20 w-20 text-gray-300 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Belum Ada Postingan
                    </h3>
                    <p class="text-gray-500 dark:text-gray-400 mb-6 max-w-md mx-auto">
                        Saat ini belum ada postingan yang tersedia. Silakan kembali lagi nanti untuk melihat konten terbaru.
                    </p>
                    @auth
                        <a href="{{ route('dashboard.posts.create') }}" 
                           class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Buat Postingan Pertama
                        </a>
                    @endauth
                </div>
            @endif
        </section>

        {{-- SEKSI KATEGORI --}}
        @if(isset($categories) && $categories->count() > 0)
        {{-- [PERBAIKAN] 'py-12 md:py-16' dipertahankan (padding vertikal OK) --}}
        <section class="py-12 md:py-16">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-8 text-center md:text-left">
                Kategori Berita
            </h2>
            <div class="grid gap-8 lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1">
                @foreach($categories as $category)
                    <a href="{{ route('categories.show', $category) }}" 
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
                @endforeach
            </div>
        </section>
        @endif

        <iframe width="420" height="315"
        src="https://www.youtube.com/embed/tgbNymZ7vqY">
        </iframe>

        <iframe width="420" height="315" src="https://yogyakarta.tvri.go.id/kelola/index.php" title="W3Schools Free Online Web Tutorials"></iframe>

        {{-- SEKSI STATISTIK --}}
        {{-- [PERBAIKAN] 'py-12 md:py-16' dipertahankan (padding vertikal OK) --}}
        <section class="py-12 md:py-16">
            {{-- [PERBAIKAN] 'p-8 md:p-12' (padding internal) dipertahankan, karena ini adalah box berwarna --}}
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
        {{-- [PERBAIKAN] 'py-12 md:py-16' dipertahankan (padding vertikal OK) --}}
        {{-- 'p-12' (padding internal) dipertahankan --}}
        <section class="py-12 md:py-16 text-center bg-gray-50 dark:bg-gray-800/50 rounded-2xl p-12 mb-12">
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