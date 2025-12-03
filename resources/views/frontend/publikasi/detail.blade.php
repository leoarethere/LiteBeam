<x-layout>
    <x-slot:title>{{ $title ?? 'Detail Penyiaran' }}</x-slot:title>

    {{-- ✅ STRUCTURED DATA UNTUK SEO --}}
    @if($broadcast)
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "{{ $broadcast->youtubeEmbedUrl ? 'VideoObject' : 'BroadcastEvent' }}",
        "name": "{{ addslashes($broadcast->title) }}",
        "description": "{{ addslashes($broadcast->synopsis ?? 'Program penyiaran') }}",
        @if($broadcast->youtubeEmbedUrl)
        "embedUrl": "{{ $broadcast->youtubeEmbedUrl }}",
        "thumbnailUrl": "{{ $broadcast->poster ? Storage::url($broadcast->poster) : '' }}",
        @endif
        "datePublished": "{{ $broadcast->published_at?->toIso8601String() ?? $broadcast->created_at->toIso8601String() }}",
        @if($broadcast->broadcastCategory)
        "genre": "{{ $broadcast->broadcastCategory->name }}",
        @endif
        "publisher": {
            "@type": "Organization",
            "name": "{{ config('app.name', 'Laravel') }}"
        },
        "eventStatus": "{{ $broadcast->is_active ? 'https://schema.org/EventScheduled' : 'https://schema.org/EventMovedOnline' }}" 
    }
    </script>
    @endif

    <main class="pt-0 pb-0 lg:pt-0 lg:pb-0 bg-white dark:bg-gray-900 antialiased">
        <div class="mt-0 px-4 sm:px-6 lg:px-8">

            {{-- ARTIKEL KONTEN --}}
            <article class="mx-auto w-full max-2xl format format-sm sm:format-base lg:format-lg format-blue dark:format-invert">
                
                {{-- HEADER --}}
                <header class="mb-6 not-format">
                    <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
                        
                        {{-- Judul --}}
                        <div class="flex-1">
                            <h1 class="text-3xl font-bold text-gray-900 lg:text-4xl dark:text-white mb-2">
                                {{ $broadcast->title }}
                            </h1>
                            
                            {{-- Kategori Badges --}}
                            @if($broadcast->broadcastCategory)
                            <a href="{{ route('broadcasts.index', ['category' => $broadcast->broadcastCategory->slug]) }}" 
                               class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $broadcast->broadcastCategory->color_classes }} hover:opacity-80 transition-opacity">
                                {{ $broadcast->broadcastCategory->name }}
                            </a>
                            @endif
                        </div>

                        {{-- 🟢 UPDATE: Meta Info (Status + Tanggal) --}}
                        <div class="flex-shrink-0 flex flex-col md:items-end gap-2 mt-2">
                            
                            {{-- Badge Status --}}
                            <div>
                                @if($broadcast->is_active)
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 border border-green-200 dark:border-green-800">
                                        <span class="relative flex h-2 w-2">
                                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                          <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                                        </span>
                                        PROGRAM ON AIR
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400 border border-gray-200 dark:border-gray-700">
                                        PROGRAM SELESAI
                                    </span>
                                @endif
                            </div>

                            {{-- Tanggal --}}
                            <div class="text-sm text-gray-500 dark:text-gray-400 text-right">
                                <span class="block text-xs uppercase tracking-wide opacity-70">Dipublikasikan</span>
                                <span class="font-medium text-gray-900 dark:text-white">
                                    {{ $broadcast->published_at ? $broadcast->published_at->format('d M Y') : $broadcast->created_at->format('d M Y') }}
                                </span>
                            </div>
                        </div>

                    </div>
                </header>

                {{-- MEDIA: YOUTUBE / POSTER --}}
                @if ($broadcast->youtubeEmbedUrl)
                    <div class="my-8 not-format">
                        <div class="relative w-full aspect-video rounded-xl shadow-xl overflow-hidden border border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-800">
                            <iframe class="absolute top-0 left-0 w-full h-full" 
                                    src="{{ $broadcast->youtubeEmbedUrl }}" 
                                    title="YouTube video player for {{ $broadcast->title }}" 
                                    frameborder="0" 
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                                    referrerpolicy="strict-origin-when-cross-origin" 
                                    allowfullscreen>
                            </iframe>
                        </div>
                    </div>
                @elseif ($broadcast->poster)
                    <figure class="mb-6 flex justify-center">
                        <div class="w-full max-w-md overflow-hidden rounded-lg shadow-lg bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                            <img src="{{ Storage::url($broadcast->poster) }}" 
                                 alt="Poster {{ $broadcast->title }}" 
                                 class="w-full h-auto object-cover"
                                 style="aspect-ratio: 3 / 4;">
                        </div>
                    </figure>
                @endif

                {{-- SINOPSIS (TETAP SAMA) --}}
                @if ($broadcast->synopsis)
                <div class="my-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 uppercase tracking-wide">
                        Sinopsis
                    </h2>
                    <div class="prose prose-lg dark:prose-invert max-w-none 
                                prose-p:text-gray-700 dark:prose-p:text-gray-300 prose-p:leading-relaxed">
                        {!! nl2br(e($broadcast->synopsis)) !!}
                    </div>
                </div>
                @endif

                {{-- FOOTER: TOMBOL SHARE & KEMBALI (TETAP SAMA) --}}
                <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700 flex flex-col sm:flex-row justify-between items-center gap-4">
                    <a href="{{ route('broadcasts.index') }}" class="inline-flex items-center gap-2 px-5 py-3 bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white text-sm font-medium rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition duration-150 ease-in-out">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali ke Penyiaran
                    </a>

                    <div class="flex items-center gap-3">
                        <span class="text-sm text-gray-500 dark:text-gray-400">Bagikan:</span>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('broadcasts.show', $broadcast->slug)) }}&text={{ urlencode($broadcast->title) }}" target="_blank" class="p-2 rounded-full bg-blue-400 text-white hover:bg-blue-500 transition-colors" aria-label="Share on Twitter">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"></path></svg>
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('broadcasts.show', $broadcast->slug)) }}" target="_blank" class="p-2 rounded-full bg-blue-600 text-white hover:bg-blue-700 transition-colors" aria-label="Share on Facebook">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"></path></svg>
                        </a>
                        <a href="https://wa.me/?text={{ urlencode($broadcast->title . ' - ' . route('broadcasts.show', $broadcast->slug)) }}" target="_blank" class="p-2 rounded-full bg-green-500 text-white hover:bg-green-600 transition-colors" aria-label="Share on WhatsApp">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"></path></svg>
                        </a>
                    </div>
                </div>

            </article>
        </div>
    </main>
</x-layout>