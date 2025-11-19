<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    {{-- KONTENER UTAMA --}}
    <div class="px-4 sm:px-6 lg:px-8">

        {{-- BAGIAN HERO & PENCARIAN BARU --}}
        <x-hero-posts />
        
        {{-- ✅ PERBAIKAN: BAGIAN FILTER DAN SORTING YANG LEBIH BAIK --}}
        <div class="my-6 pt-2 border-t border-gray-200 dark:border-gray-700">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mt-4 mb-4">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                    Semua Postingan
                </h2>
                
                {{-- FORM FILTER DAN SORTING YANG DIPERBAIKI --}}
                <form method="GET" action="{{ route('posts.index') }}" 
                      class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                    {{-- Input tersembunyi untuk menjaga parameter yang sudah ada --}}
                    @if (request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif
                    @if (request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                    @if (request('author'))
                        <input type="hidden" name="author" value="{{ request('author') }}">
                    @endif

                    {{-- ✅ PERBAIKAN: FILTER KATEGORI dengan lebar yang cukup --}}
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

                    {{-- ✅ PERBAIKAN: SORTING dengan lebar yang cukup --}}
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

                    {{-- ✅ PERBAIKAN: TOMBOL RESET dengan penyesuaian layout --}}
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

            {{-- PESAN HASIL FILTER --}}
            @if(request()->hasAny(['search', 'category', 'sort', 'author']))
                <div class="p-4 mb-6 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400" role="alert">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                        <span>
                            <strong>{{ $posts->total() }}</strong> post ditemukan
                            @if(request('search'))
                                untuk pencarian '<strong>{{ request('search') }}</strong>'
                            @endif
                            @if(request('category'))
                                @php
                                    $categoryName = \App\Models\Category::where('slug', request('category'))->first()->name ?? request('category');
                                @endphp
                                dalam kategori '<strong>{{ $categoryName }}</strong>'
                            @endif
                            @if(request('author'))
                                @php
                                    $authorName = \App\Models\User::where('username', request('author'))->first()->name ?? request('author');
                                @endphp
                                oleh penulis '<strong>{{ $authorName }}</strong>'
                            @endif
                            @if(request('sort') && request('sort') != 'latest')
                                @php
                                    $sortLabels = [
                                        'oldest' => 'terlama',
                                        'popular' => 'populer', 
                                        'title_asc' => 'judul A-Z',
                                        'title_desc' => 'judul Z-A'
                                    ];
                                @endphp
                                , diurutkan berdasarkan <strong>{{ $sortLabels[request('sort')] ?? request('sort') }}</strong>
                            @endif
                        </span>
                    </div>
                </div>
            @endif
        </div>
        
        {{-- BAGIAN DAFTAR POSTINGAN --}}
        <div class="pb-8 lg:pb-4">
            {{-- GRID POSTINGAN --}}
            <div class="grid gap-8 lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1">
                @forelse ($posts as $post)
                    <x-post-card :post="$post" />
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
                            @if(request()->hasAny(['search', 'category', 'author']))
                                Coba gunakan kata kunci lain atau hapus filter untuk melihat semua postingan.
                            @else
                                Silakan kembali lagi nanti untuk melihat postingan terbaru.
                            @endif
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
            <div class="mb-8">
                {{ $posts->links() }}
            </div>
        @endif

    </div> {{-- PENUTUP KONTENER UTAMA --}}

</x-layout>