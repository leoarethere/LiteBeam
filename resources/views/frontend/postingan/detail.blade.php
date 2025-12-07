<x-layout>
    {{-- Slot Title --}}
    <x-slot:title>{{ $post->meta_title ?? $post->title }}</x-slot:title>

    {{-- [PERBAIKAN] Slot Meta Description --}}
    <x-slot:meta_description>
        {{ $post->meta_description ?? Str::limit(strip_tags($post->body), 150) }}
    </x-slot:meta_description>

    {{-- SEO Structured Data --}}
    @if($post)
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "BlogPosting",
        "headline": "{{ addslashes($post->title) }}",
        "description": "{{ addslashes(Str::limit(strip_tags($post->body), 160)) }}",
        "datePublished": "{{ $post->published_at?->toIso8601String() ?? $post->created_at->toIso8601String() }}",
        "author": {
            "@type": "Person",
            "name": "{{ $post->user->name ?? 'Admin' }}"
        },
        "image": "{{ $post->featured_image ? Storage::url($post->featured_image) : '' }}"
    }
    </script>
    @endif

    <div class="px-4 sm:px-6 lg:px-8 py-8 lg:py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <article class="mx-auto w-full max-w-4xl bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
            
            {{-- BREADCRUMB --}}
            <div class="px-6 sm:px-10 pt-8 pb-4">
                <nav class="flex text-sm text-gray-500 dark:text-gray-400 overflow-x-auto whitespace-nowrap scrollbar-hide" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-2">
                        <li class="inline-flex items-center">
                            <a href="{{ route('home') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                Beranda
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/></svg>
                                <a href="{{ route('posts.index') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                    Berita
                                </a>
                            </div>
                        </li>
                        @if($post->category)
                        <li>
                            <div class="flex items-center">
                                <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/></svg>
                                <a href="{{ route('posts.index', ['category' => $post->category->slug]) }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                    {{ $post->category->name }}
                                </a>
                            </div>
                        </li>
                        @endif
                    </ol>
                </nav>
            </div>

            {{-- HEADER ARTIKEL --}}
            <header class="px-6 sm:px-10 pb-8">
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-gray-900 dark:text-white leading-tight mb-6">
                    {{ $post->title }}
                </h1>

                <div class="flex flex-wrap items-center gap-4 sm:gap-6 pt-4 border-t border-gray-100 dark:border-gray-700">
                    {{-- Author --}}
                    @if ($post->user)
                    <div class="flex items-center gap-3">
                        <img class="w-10 h-10 rounded-full ring-2 ring-gray-100 dark:ring-gray-700" 
                             src="{{ $post->user->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($post->user->name).'&background=random&color=fff' }}" 
                             alt="{{ $post->user->name }}">
                        <div>
                            <p class="text-sm font-bold text-gray-900 dark:text-white">
                                {{ $post->user->name }}
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                Penulis
                            </p>
                        </div>
                    </div>
                    @endif

                    {{-- Tanggal --}}
                    <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <time datetime="{{ $post->created_at->toIso8601String() }}">
                            {{ $post->created_at->format('d F Y, H:i') }} WIB
                        </time>
                    </div>
                </div>
            </header>

            {{-- FEATURED IMAGE --}}
            @if ($post->featured_image && Storage::exists($post->featured_image))
                <figure class="relative w-full aspect-video sm:aspect-[16/9] bg-gray-100 dark:bg-gray-900">
                    <img src="{{ Storage::url($post->featured_image) }}" 
                         alt="{{ $post->title }}" 
                         class="w-full h-full object-cover">
                </figure>
            @endif

            {{-- KONTEN UTAMA --}}
            <div class="px-6 sm:px-10 py-10">
                
                {{-- Tombol Download Aset (Jika ada) --}}
                @if ($post->link_postingan)
                    <div class="mb-8 not-format">
                        <a href="{{ $post->link_postingan }}" target="_blank" rel="noopener noreferrer"
                           class="inline-flex items-center gap-2 px-5 py-3 bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300 text-sm font-bold rounded-xl border border-blue-100 dark:border-blue-800 hover:bg-blue-100 dark:hover:bg-blue-900/40 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            Unduh Lampiran / Sumber
                        </a>
                    </div>
                @endif

                {{-- Artikel Body --}}
                <div class="prose prose-lg prose-blue dark:prose-invert max-w-none 
                            prose-headings:font-bold prose-headings:tracking-tight 
                            prose-a:text-blue-600 dark:prose-a:text-blue-400 hover:prose-a:text-blue-700
                            prose-img:rounded-2xl prose-img:shadow-md
                            text-gray-700 dark:text-gray-300 leading-relaxed">
                    {!! clean($post->body) !!}
                </div>
            </div>

            {{-- FOOTER & SHARE --}}
            <div class="px-6 sm:px-10 py-8 bg-gray-50 dark:bg-gray-700/20 border-t border-gray-100 dark:border-gray-700 flex flex-col sm:flex-row justify-between items-center gap-6">
                
                {{-- Tombol Kembali (Desain Baru) --}}
                <a href="{{ route('posts.index') }}" 
                   class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:text-blue-600 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Semua Postingan
                </a>

                {{-- Social Share --}}
                <div class="flex items-center gap-3">
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400 mr-2">Bagikan:</span>
                    
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" class="p-2 rounded-full bg-blue-600 text-white hover:bg-blue-700 transition-colors shadow-sm" title="Facebook">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"></path></svg>
                    </a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($post->title) }}" target="_blank" class="p-2 rounded-full bg-sky-500 text-white hover:bg-sky-600 transition-colors shadow-sm" title="Twitter">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"></path></svg>
                    </a>
                    <a href="https://wa.me/?text={{ urlencode($post->title . ' ' . request()->url()) }}" target="_blank" class="p-2 rounded-full bg-green-500 text-white hover:bg-green-600 transition-colors shadow-sm" title="WhatsApp">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"></path></svg>
                    </a>
                </div>
            </div>

        </article>
    </div>
</x-layout>