<x-layout>
    {{-- Judul halaman dinamis --}}
    <x-slot:title>
        {{ $title ?? 'Program Penyiaran' }}
        @if(request('category') && isset($activeCategory))
            - {{ $activeCategory->name }}
        @endif
    </x-slot:title>

    {{-- KONTAINER UTAMA --}}
    <div class="px-4 sm:px-6 lg:px-8">

        {{-- HERO SECTION (TETAP SAMA) --}}
        <div class="relative rounded-3xl overflow-hidden mb-10 bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 dark:from-blue-900 dark:via-blue-950 dark:to-indigo-950 shadow-xl">
            <div class="absolute inset-0 bg-grid-white/[0.03] bg-[size:24px_24px] [mask-image:radial-gradient(ellipse_at_center,black_40%,transparent_100%)]"></div>
            <div class="relative px-6 py-12 lg:px-12 lg:py-20 text-center">
                <div class="max-w-3xl mx-auto">
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-4 drop-shadow-md">
                        @if(isset($activeCategory))
                            {{ $activeCategory->name }}
                        @else
                            Program Penyiaran
                        @endif
                    </h1>
                    <p class="text-base sm:text-lg text-blue-100 max-w-2xl mx-auto leading-relaxed">
                        @if(isset($activeCategory))
                            Jelajahi program unggulan TVRI Yogyakarta dalam kategori {{ $activeCategory->name }}.
                        @else
                            Jelajahi berbagai program unggulan TVRI Yogyakarta yang menghadirkan informasi, hiburan, dan edukasi berkualitas untuk Anda.
                        @endif
                    </p>
                </div>
            </div>
        </div>
        
        {{-- BAGIAN FILTER (TETAP SAMA) --}}
        <div class="mb-10">
            <div class="flex flex-col sm:flex-row items-start sm:items-center sm:justify-between mb-6 gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                        Filter Kategori
                    </h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                        Pilih kategori untuk melihat program spesifik
                    </p>
                </div>
                
                <div class="flex-shrink-0 flex items-center gap-2 px-4 py-2 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"></path>
                    </svg>
                    <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                        {{ $broadcasts->total() }} Program Ditemukan
                    </span>
                </div>
            </div>
            
            {{-- Category Filter Pills (TETAP SAMA) --}}
            <div class="relative">
                <div class="absolute -left-4 top-0 bottom-0 w-12 bg-gradient-to-r from-white dark:from-gray-900 to-transparent z-10 pointer-events-none md:hidden"></div>
                <div class="overflow-x-auto scrollbar-hide -mx-4 px-4 lg:mx-0 lg:px-0">
                    <nav class="flex gap-2 lg:gap-3 pb-2" style="min-width: min-content;">
                        <a href="{{ route('broadcasts.index') }}"
                           class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-medium rounded-full transition-all duration-200 whitespace-nowrap
                           {{ !request('category') 
                               ? 'bg-blue-600 text-white' 
                               : 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                            </svg>
                            Semua Kategori
                        </a>
                        @foreach ($categories as $category)
                        <a href="{{ route('broadcasts.index', ['category' => $category->slug]) }}"
                           class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-medium rounded-full transition-all duration-200 whitespace-nowrap
                           {{ request('category') == $category->slug 
                               ? 'bg-blue-600 text-white' 
                               : 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700' }}">
                            <span class="w-3 h-3 rounded-full {{ $category->color_classes }}"></span>
                            {{ $category->name }}
                        </a>
                        @endforeach
                    </nav>
                </div>
                <div class="absolute -right-4 top-0 bottom-0 w-12 bg-gradient-to-l from-white dark:from-gray-900 to-transparent z-10 pointer-events-none md:hidden"></div>
            </div>
        </div>
        
        {{-- PROGRAMS GRID --}}
        <div class="pb-8">
            @if($broadcasts->count() > 0)
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4 lg:gap-6">
                    @foreach ($broadcasts as $broadcast)
                        <a href="{{ route('broadcasts.show', $broadcast) }}" 
                           class="group block bg-white dark:bg-gray-800 rounded-xl overflow-hidden transition-all duration-300 hover:-translate-y-1.5 border border-gray-200 dark:border-gray-700/50 hover:border-blue-400 dark:hover:border-blue-600">
                            <div class="relative overflow-hidden bg-gray-100 dark:bg-gray-900">
                                @if ($broadcast->poster)
                                    <img src="{{ Storage::url($broadcast->poster) }}" 
                                         alt="{{ $broadcast->title }}" 
                                         class="w-full h-auto object-cover transition-transform duration-500 group-hover:scale-110" 
                                         style="aspect-ratio: 3 / 4;">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        <div class="absolute bottom-0 left-0 right-0 p-3 transform translate-y-3 group-hover:translate-y-0 transition-transform duration-300 flex items-center justify-between">
                                            <span class="inline-flex items-center gap-1 text-white text-xs font-bold">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z" /><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" /></svg>
                                                Lihat Detail
                                            </span>
                                        </div>
                                    </div>
                                @else
                                    {{-- Placeholder Image (TETAP SAMA) --}}
                                    <div class="w-full flex flex-col items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-900" style="aspect-ratio: 3 / 4;">
                                        <svg class="w-12 h-12 text-gray-400 dark:text-gray-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">No Poster</span>
                                    </div>
                                @endif
                                
                                {{-- 🟢 UPDATE: Badge Kategori & Status --}}
                                
                                {{-- Badge Kategori (Kiri Atas) --}}
                                @if($broadcast->broadcastCategory)
                                <div class="absolute top-2.5 left-2.5 z-10">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $broadcast->broadcastCategory->color_classes }} shadow-sm">
                                        {{ $broadcast->broadcastCategory->name }}
                                    </span>
                                </div>
                                @endif

                                {{-- [BARU] Badge Status Produksi (Kanan Atas) --}}
                                <div class="absolute top-2.5 right-2.5 z-10">
                                    @if($broadcast->is_active)
                                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-[10px] font-bold bg-green-600/90 text-white backdrop-blur-sm shadow-sm border border-green-400/50">
                                            <span class="w-1.5 h-1.5 bg-white rounded-full animate-pulse"></span>
                                            ON AIR
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-[10px] font-bold bg-gray-900/80 text-gray-200 backdrop-blur-sm shadow-sm border border-gray-700/50">
                                            TAMAT
                                        </span>
                                    @endif
                                </div>

                            </div>
                            <div class="p-3 lg:p-4">
                                <h3 class="text-sm lg:text-base font-semibold text-gray-900 dark:text-white line-clamp-2 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors leading-snug h-10 lg:h-12">
                                    {{ $broadcast->title }}
                                </h3>
                                @if($broadcast->published_at)
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    {{ $broadcast->published_at->format('d M Y') }}
                                </p>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                {{-- EMPTY STATE (TETAP SAMA) --}}
                <div class="text-center py-12 lg:py-12">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gray-100 dark:bg-gray-800 mb-6">
                        <svg class="w-10 h-10 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white mb-3">Tidak Ada Program Ditemukan</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-8 max-w-md mx-auto">
                        @if(request('category')) Tidak ada program penyiaran di kategori ini saat ini. @else Belum ada program penyiaran yang tersedia. @endif
                    </p>
                    @if(request('category'))
                        <a href="{{ route('broadcasts.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition-all duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg> Kembali ke Semua Program
                        </a>
                    @endif
                </div>
            @endif
        </div>

        {{-- PAGINATION --}}
        @if ($broadcasts->hasPages())
            <div class="mb-8">
                {{ $broadcasts->links() }}
            </div>
        @endif

    </div>

    {{-- Custom Styles --}}
    <style>
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
        .bg-grid-white { background-image: linear-gradient(rgba(255, 255, 255, 0.03) 1px, transparent 1px), linear-gradient(90deg, rgba(255, 255, 255, 0.03) 1px, transparent 1px); }
    </style>
</x-layout>