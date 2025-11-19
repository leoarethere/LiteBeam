<x-layout>
    <x-slot:title>{{ $title ?? 'Detail Postingan' }}</x-slot:title>

    {{-- ✅ STRUCTURED DATA UNTUK SEO --}}
    @if($post)
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "BlogPosting",
        "headline": "{{ addslashes($post->title) }}",
        "description": "{{ addslashes($post->excerpt ?? Str::limit(strip_tags($post->body), 160)) }}",
        "author": {
            "@type": "Person",
            "name": "{{ addslashes($post->user->name ?? 'Unknown Author') }}"
        },
        "datePublished": "{{ $post->published_at?->toIso8601String() ?? $post->created_at->toIso8601String() }}",
        "dateModified": "{{ $post->updated_at->toIso8601String() }}",
        "image": "{{ $post->featured_image ? Storage::url($post->featured_image) : '' }}",
        "publisher": {
            "@type": "Organization",
            "name": "{{ config('app.name', 'Laravel') }}"
        },
        "mainEntityOfPage": {
            "@type": "WebPage",
            "@id": "{{ route('posts.show', $post->slug) }}"
        }
    }
    </script>
    @endif

    <main class="pt-0 pb-0 lg:pt-0 lg:pb-0 bg-white dark:bg-gray-900 antialiased">
        {{-- ✅ LOADING STATE - SUDAH DIPERBAIKI --}}
        <div id="loading-indicator" class="fixed inset-0 bg-white dark:bg-gray-900 flex items-center justify-center z-50 transition-opacity duration-300 opacity-0 pointer-events-none">
            <div class="text-center">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto"></div>
                <p class="mt-4 text-gray-600 dark:text-gray-400">Memuat postingan...</p>
            </div>
        </div>

        <div class="mt-0 px-4 sm:px-6 lg:px-8 py-8">
            {{-- ✅ ERROR HANDLING: JIKA POST TIDAK DITEMUKAN --}}
            @if(!$post)
            <div class="mx-auto w-full max-w-2xl text-center py-16">
                <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-8">
                    <svg class="w-16 h-16 text-red-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                    <h2 class="text-2xl font-bold text-red-800 dark:text-red-200 mb-2">Postingan Tidak Ditemukan</h2>
                    <p class="text-red-600 dark:text-red-300 mb-6">Maaf, postingan yang Anda cari tidak tersedia atau telah dihapus.</p>
                    <a href="{{ route('posts.index') }}" class="inline-flex items-center px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors duration-200">
                        Kembali ke Semua Postingan
                    </a>
                </div>
            </div>
            @else
            <article class="mx-auto w-full max-2xl format format-sm sm:format-base lg:format-lg format-blue dark:format-invert">
                <header class="mb-4 lg:mb-6 not-format">
                    {{-- META KATEGORI & TANGGAL --}}
                    <div class="flex justify-between items-center mb-5 text-gray-500">
                        @if ($post->category && $post->category->name)
                        <span class="{{ $post->category->color_classes ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }} text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded">
                            <a href="{{ route('categories.show', $post->category) }}" class="hover:underline font-medium">
                                {{ $post->category->name }}
                            </a>
                        </span>
                        @else
                        <span class="bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded">
                            Tanpa Kategori
                        </span>
                        @endif
                        <span class="text-sm">
                            {{ $post->created_at?->diffForHumans() ?? 'Tanggal tidak tersedia' }}
                        </span>
                    </div>

                    {{-- JUDUL UTAMA POST --}}
                    <h1 class="mb-4 text-3xl font-extrabold leading-tight text-gray-900 lg:mb-6 lg:text-4xl dark:text-white">
                        {{ $post->title ?? 'Judul Tidak Tersedia' }}
                    </h1>

                    {{-- ✅ FEATURED IMAGE DENGAN LAZY LOADING & ERROR HANDLING --}}
                    @if ($post->featured_image)
                    <figure class="mb-6">
                        <div class="w-full overflow-hidden rounded-lg shadow-lg bg-gray-100 dark:bg-gray-800 relative">
                            {{-- Loading placeholder --}}
                            <div class="absolute inset-0 bg-gray-200 dark:bg-gray-700 animate-pulse flex items-center justify-center" id="image-loading-{{ $post->id }}">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            
                            <img 
                                src="{{ Storage::url($post->featured_image) }}" 
                                alt="Gambar untuk {{ $post->title ?? 'Postingan' }}" 
                                class="w-full h-auto object-scale-down max-h-[500px] mx-auto transition-opacity duration-300 opacity-0"
                                loading="lazy"
                                onload="this.classList.remove('opacity-0'); document.getElementById('image-loading-{{ $post->id }}').style.display='none';"
                                onerror="this.style.display='none'; document.getElementById('image-loading-{{ $post->id }}').innerHTML='<div class=\'text-center text-gray-500 dark:text-gray-400 py-8\'><svg class=\'w-12 h-12 mx-auto\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z\'></path></svg><p class=\'mt-2 text-sm\'>Gagal memuat gambar</p></div>';"
                            >
                        </div>
                        @if ($post->excerpt)
                        <figcaption class="mt-3 text-sm text-center text-gray-500 dark:text-gray-400">
                            {{ Str::limit($post->excerpt, 100) }}
                        </figcaption>
                        @endif
                    </figure>
                    @endif

                    {{-- INFORMASI PENULIS DENGAN ERROR HANDLING --}}
                    @if ($post->user)
                    <div class="flex items-center justify-between mb-6 pb-6 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center space-x-4">
                            <img 
                                class="w-12 h-12 rounded-full ring-2 ring-gray-200 dark:ring-gray-700" 
                                src="{{ $post->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($post->user->name ?? 'User') . '&background=random&color=fff' }}" 
                                alt="{{ $post->user->name ?? 'Penulis' }}'s avatar"
                                loading="lazy"
                                onerror="this.src='https://ui-avatars.com/api/?name=User&background=random&color=fff'"
                            />
                            <div>
                                <a href="{{ route('authors.show', $post->user) }}" class="font-semibold text-gray-900 dark:text-white hover:underline">
                                    {{ $post->user->name ?? 'Penulis Tidak Dikenal' }}
                                </a>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $post->user->bio ?? 'Content Writer' }}
                                </p>
                            </div>
                        </div>

                        {{-- INFO TAMBAHAN --}}
                        <div class="hidden sm:flex flex-col items-end text-sm text-gray-500 dark:text-gray-400">
                            <span>📅 {{ $post->published_at ? $post->published_at->format('d M Y') : ($post->created_at?->format('d M Y') ?? 'Tanggal tidak tersedia') }}</span>
                            @php
                                $wordCount = $post->body ? str_word_count(strip_tags($post->body)) : 0;
                                $readingTime = $wordCount > 0 ? max(1, ceil($wordCount / 200)) : 1;
                            @endphp
                            <span>⏱️ {{ $readingTime }} menit baca</span>
                        </div>
                    </div>
                    @else
                    <div class="flex items-center justify-between mb-6 pb-6 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center space-x-4">
                            <img 
                                class="w-12 h-12 rounded-full ring-2 ring-gray-200 dark:ring-gray-700" 
                                src="https://ui-avatars.com/api/?name=Anonymous&background=random&color=fff" 
                                alt="Anonymous avatar"
                                loading="lazy"
                            />
                            <div>
                                <span class="font-semibold text-gray-900 dark:text-white">Anonymous</span>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Penulis tidak tersedia</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </header>

                {{-- LINK POSTINGAN ASLI --}}
                @if ($post->link_postingan)
                <div class="not-format mb-6">
                    <a href="{{ $post->link_postingan }}"
                    target="_blank" rel="noopener noreferrer"
                    class="inline-flex items-center gap-2 px-5 py-3 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                        <span>Kunjungi Sumber Asli</span>
                    </a>
                </div>
                @endif

                {{-- KONTEN UTAMA POST --}}
                <div class="prose prose-lg dark:prose-invert max-w-none 
                            prose-headings:font-bold prose-headings:text-gray-900 dark:prose-headings:text-white
                            prose-p:text-gray-700 dark:prose-p:text-gray-300 prose-p:leading-relaxed
                            prose-a:text-blue-600 dark:prose-a:text-blue-400 prose-a:no-underline hover:prose-a:underline
                            prose-img:rounded-lg prose-img:shadow-lg
                            prose-strong:text-gray-900 dark:prose-strong:text-white
                            prose-code:text-pink-600 dark:prose-code:text-pink-400 prose-code:bg-gray-100 dark:prose-code:bg-gray-800 prose-code:px-1 prose-code:rounded
                            prose-pre:bg-gray-900 dark:prose-pre:bg-gray-950
                            prose-blockquote:border-l-4 prose-blockquote:border-blue-500 prose-blockquote:bg-blue-50 dark:prose-blockquote:bg-blue-900/10 prose-blockquote:py-1 prose-blockquote:px-4">
                    @if($post->body)
                        {!! $post->body !!}
                    @else
                        <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                            <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <p>Konten tidak tersedia untuk postingan ini.</p>
                        </div>
                    @endif
                </div>

                {{-- TAGS DENGAN ERROR HANDLING --}}
                @if (!empty($post->tags) && is_string($post->tags))
                <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">Tags:</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach(explode(',', $post->tags) as $tag)
                            @if(trim($tag))
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                #{{ trim($tag) }}
                            </span>
                            @endif
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- TOMBOL NAVIGASI --}}
                <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700 flex flex-col sm:flex-row justify-between items-center gap-4">
                    <a href="{{ route('posts.index') }}" class="inline-flex items-center gap-2 px-5 py-3 bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white text-sm font-medium rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition duration-150 ease-in-out">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali ke Semua Postingan
                    </a>

                    {{-- SHARE BUTTONS --}}
                    <div class="flex items-center gap-3">
                        <span class="text-sm text-gray-500 dark:text-gray-400">Bagikan:</span>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('posts.show', $post->slug)) }}&text={{ urlencode($post->title) }}" target="_blank" class="p-2 rounded-full bg-blue-400 text-white hover:bg-blue-500 transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"></path>
                            </svg>
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('posts.show', $post->slug)) }}" target="_blank" class="p-2 rounded-full bg-blue-600 text-white hover:bg-blue-700 transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"></path>
                            </svg>
                        </a>
                        <a href="https://wa.me/?text={{ urlencode(($post->title ?? 'Postingan') . ' - ' . route('posts.show', $post->slug)) }}" target="_blank" class="p-2 rounded-full bg-green-500 text-white hover:bg-green-600 transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </article>
            @endif
        </div>
    </main>

    {{-- ✅ SCRIPT UNTUK LOADING STATES - SUDAH DIPERBAIKI --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loadingIndicator = document.getElementById('loading-indicator');
            
            // Tampilkan loading indicator saat halaman mulai load
            if (loadingIndicator) {
                // tampilkan overlay dengan menghapus kelas yang membuatnya transparan/ tidak bisa diinteraksi
                loadingIndicator.classList.remove('opacity-0');
                loadingIndicator.classList.remove('pointer-events-none');
                
                // Sembunyikan loading indicator ketika halaman selesai load
                window.addEventListener('load', function() {
                    setTimeout(() => {
                        // kembalikan status tersembunyi dengan menambahkan kembali kelas opacity dan pointer-events
                        loadingIndicator.classList.add('opacity-0');
                        loadingIndicator.classList.add('pointer-events-none');
                    }, 500);
                });
            }

            // Handle error pada semua gambar
            document.querySelectorAll('img').forEach(img => {
                img.addEventListener('error', function() {
                    this.style.display = 'none';
                    const parent = this.parentElement;
                    if (parent && parent.querySelector('[id^="image-loading"]')) {
                        const loadingElement = parent.querySelector('[id^="image-loading"]');
                        loadingElement.innerHTML = `
                            <div class="text-center text-gray-500 dark:text-gray-400 py-8">
                                <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                <p class="mt-2 text-sm">Gagal memuat gambar</p>
                            </div>
                        `;
                    } else if (parent) {
                        const errorDiv = document.createElement('div');
                        errorDiv.className = 'text-center text-gray-500 dark:text-gray-400 py-4';
                        errorDiv.innerHTML = `
                            <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                            <p class="text-sm">Gambar tidak dapat dimuat</p>
                        `;
                        parent.appendChild(errorDiv);
                    }
                });
            });
        });
    </script>
</x-layout>