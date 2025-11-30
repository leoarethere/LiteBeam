<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    {{-- KONTENER UTAMA --}}
    <div class="px-4 sm:px-6 lg:px-8"> {{-- ✅ PERBAIKAN: Padding mobile yang lebih kecil --}}

        {{-- BAGIAN HERO & PENCARIAN --}}
        <div class="mb-6 sm:mb-8"> {{-- ✅ PERBAIKAN: Margin bottom yang responsif --}}
            <x-hero-posts />
        </div>
        
        {{-- BAGIAN FILTER DAN SORTING --}}
        <div class="my-6 sm:my-8"> {{-- ✅ PERBAIKAN: Margin yang responsif --}}
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mt-4 mb-4">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{ $title }}
                </h2>
                
                {{-- FORM FILTER DAN SORTING --}}
                <form method="GET" action="{{ route('posts.index') }}" 
                      class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                    @if (request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif

                    {{-- Filter Kategori --}}
                    <div class="flex-1 sm:flex-none">
                        <select name="category" onchange="this.form.submit()" 
                                class="w-full sm:w-48 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->slug }}" 
                                        @selected(request('category') == $category->slug)>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Filter Author --}}
                    <div class="flex-1 sm:flex-none">
                        <select name="author" onchange="this.form.submit()" 
                                class="w-full sm:w-48 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                            <option value="">Semua Penulis</option>
                            @foreach($authors as $author)
                                <option value="{{ $author->username }}" 
                                        @selected(request('author') == $author->username)>
                                    {{ $author->name }} ({{ $author->posts_count }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Sorting --}}
                    <div class="flex-1 sm:flex-none">
                        <select name="sort" onchange="this.form.submit()" 
                                class="w-full sm:w-48 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                            <option value="latest" @selected(request('sort', 'latest') == 'latest')>Terbaru</option>
                            <option value="oldest" @selected(request('sort') == 'oldest')>Terlama</option>
                            <option value="popular" @selected(request('sort') == 'popular')>Populer</option>
                            <option value="title_asc" @selected(request('sort') == 'title_asc')>Judul A-Z</option>
                            <option value="title_desc" @selected(request('sort') == 'title_desc')>Judul Z-A</option>
                        </select>
                    </div>

                    {{-- Tombol Reset --}}
                    @if(request()->hasAny(['search', 'category', 'sort', 'author']))
                        <div class="flex-1 sm:flex-none">
                            <a href="{{ route('posts.index') }}" 
                               class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600 transition-colors whitespace-nowrap">
                                Reset Filter
                            </a>
                        </div>
                    @endif
                </form>
            </div>

            {{-- INFO HASIL PENCARIAN --}}
            @if(request()->hasAny(['search', 'category', 'sort', 'author']))
                <div class="p-4 mb-6 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400" role="alert">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                        <span>
                            <strong>{{ $posts->total() }}</strong> post ditemukan
                        </span>
                    </div>
                    
                    @if(request()->hasAny(['search', 'category', 'author']))
                        <div class="mt-3 flex flex-wrap gap-2">
                            @if(request('search'))
                                <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}" 
                                   class="inline-flex items-center px-2.5 py-1 text-xs bg-blue-100 text-blue-800 rounded-full hover:bg-blue-200 dark:bg-blue-900 dark:text-blue-300 dark:hover:bg-blue-800 transition-colors">
                                    Hapus pencarian: {{ request('search') }}
                                    <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </a>
                            @endif
                            @if(request('category'))
                                <a href="{{ request()->fullUrlWithQuery(['category' => null]) }}" 
                                   class="inline-flex items-center px-2.5 py-1 text-xs bg-blue-100 text-blue-800 rounded-full hover:bg-blue-200 dark:bg-blue-900 dark:text-blue-300 dark:hover:bg-blue-800 transition-colors">
                                    Hapus kategori
                                    <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </a>
                            @endif
                            @if(request('author'))
                                <a href="{{ request()->fullUrlWithQuery(['author' => null]) }}" 
                                   class="inline-flex items-center px-2.5 py-1 text-xs bg-blue-100 text-blue-800 rounded-full hover:bg-blue-200 dark:bg-blue-900 dark:text-blue-300 dark:hover:bg-blue-800 transition-colors">
                                    Hapus penulis
                                    <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            @endif
        </div>
        
        {{-- BAGIAN DAFTAR POSTINGAN (GRID) --}}
        <div class="pb-8 lg:pb-4">
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @forelse ($posts as $post)
                
                    {{-- ✅ KARTU POSTINGAN - DIPERBAIKI UNTUK VISIBILITY --}}
                    <article class="group bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl shadow-sm hover:shadow-lg overflow-hidden transition-all duration-300 hover:-translate-y-1 h-full flex flex-col">
                        
                        {{-- CONTAINER GAMBAR --}}
                        <a href="{{ route('posts.show', $post->slug) }}" class="block relative overflow-hidden bg-gray-100 dark:bg-gray-900 w-full aspect-video">
                            
                            {{-- GAMBAR UTAMA --}}
                            @if ($post->featured_image && Storage::exists($post->featured_image))
                                <img src="{{ Storage::url($post->featured_image) }}" 
                                     alt="{{ $post->title }}" 
                                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                                     loading="lazy">
                            @else
                                {{-- Fallback Image --}}
                                <div class="w-full h-full flex flex-col items-center justify-center bg-gray-200 dark:bg-gray-700 text-gray-400 dark:text-gray-600">
                                    <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif

                            {{-- OVERLAY GRADASI (Hover Effect) --}}
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end">
                                <div class="p-4 w-full transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                                    <span class="inline-flex items-center gap-2 text-white text-sm font-bold">
                                        Lihat Selengkapnya
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                    </span>
                                </div>
                            </div>

                            {{-- KATEGORI BADGE --}}
                            @if($post->category)
                                <div class="absolute top-3 left-3">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold shadow-sm {{ $post->category->color_classes ?? 'bg-blue-600 text-white' }}">
                                        {{ $post->category->name }}
                                    </span>
                                </div>
                            @endif
                        </a>

                        {{-- KONTEN TEKS --}}
                        <div class="p-5 flex flex-col flex-grow">
                            {{-- Meta Data --}}
                            <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400 mb-3">
                                <span class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    {{ $post->created_at->format('d M Y') }}
                                </span>
                                @if($post->user)
                                    <span class="flex items-center gap-1 truncate max-w-[150px]">
                                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                        {{ $post->user->name }}
                                    </span>
                                @endif
                            </div>

                            {{-- Judul --}}
                            <a href="{{ route('posts.show', $post->slug) }}">
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors line-clamp-2" title="{{ $post->title }}">
                                    {{ $post->title }}
                                </h3>
                            </a>

                            {{-- Excerpt / Ringkasan --}}
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 flex-grow line-clamp-3">
                                {{ Str::limit($post->excerpt ? $post->excerpt : strip_tags($post->body), 150, '...') }}
                            </p>

                        </div>
                    </article>

                @empty
                    <div class="lg:col-span-3 text-center py-16">
                        <svg class="w-24 h-24 mx-auto text-gray-300 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h3 class="text-2xl font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            @if(request()->hasAny(['search', 'category', 'author']))
                                Tidak Ada Postingan Ditemukan
                            @else
                                Belum Ada Postingan
                            @endif
                        </h3>
                        <p class="text-gray-500 dark:text-gray-400 mb-6 max-w-md mx-auto">
                            Silakan kembali lagi nanti atau coba kata kunci pencarian lain.
                        </p>
                        @if(request()->hasAny(['search', 'category', 'author']))
                            <a href="{{ route('posts.index') }}" 
                               class="inline-flex items-center px-5 py-3 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                Lihat Semua Postingan
                            </a>
                        @endif
                    </div>
                @endforelse
            </div>
        </div>

        {{-- PAGINASI --}}
        @if ($posts->hasPages())
            <div class="mb-8 mt-4">
                {{ $posts->links() }}
            </div>
        @endif

    </div>

</x-layout>