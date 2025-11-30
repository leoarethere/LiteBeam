<x-layout>
    <x-slot:title>{{ $title ?? 'Detail Postingan' }}</x-slot:title>

    {{-- Structured Data SEO --}}
    @if($post)
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "BlogPosting",
        "headline": "{{ addslashes($post->title) }}",
        "datePublished": "{{ $post->published_at?->toIso8601String() ?? $post->created_at->toIso8601String() }}",
        "image": "{{ $post->featured_image ? Storage::url($post->featured_image) : '' }}"
    }
    </script>
    @endif

    <main class="pt-0 pb-0 lg:pt-0 lg:pb-0 bg-white dark:bg-gray-900 antialiased">
        <div class="mt-0 px-4 sm:px-6 lg:px-8">
            
            @if(!$post)
                <div class="text-center py-16">
                    <h2 class="text-2xl font-bold text-red-800">Postingan Tidak Ditemukan</h2>
                    <a href="{{ route('posts.index') }}" class="text-blue-600 hover:underline">Kembali</a>
                </div>
            @else

            <article class="mx-auto w-full max-2xl format format-sm sm:format-base lg:format-lg format-blue dark:format-invert">
                <header class="mb-4 lg:mb-6 not-format">
                    <div class="flex justify-between items-center mb-5 text-gray-500">
                        @if ($post->category)
                            <span class="{{ $post->category->color_classes ?? 'bg-gray-100 text-gray-800' }} text-xs font-medium px-2.5 py-0.5 rounded">
                                {{ $post->category->name }}
                            </span>
                        @endif
                        <span class="text-sm">{{ $post->created_at->diffForHumans() }}</span>
                    </div>

                    <h1 class="mb-4 text-3xl font-bold text-gray-900 dark:text-white">
                        {{ $post->title }}
                    </h1>

                    {{-- Featured Image --}}
                    @if ($post->featured_image)
                    <figure class="mb-6">
                        <img src="{{ Storage::url($post->featured_image) }}" class="w-full rounded-lg shadow-lg" alt="{{ $post->title }}">
                    </figure>
                    @endif

                    {{-- Author Info (Tanpa Link) --}}
                    @if ($post->user)
                    <div class="flex items-center justify-between mb-6 pb-6 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center space-x-4">
                            <img class="w-12 h-12 rounded-full" src="{{ $post->user->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($post->user->name) }}" alt="Avatar">
                            <div>
                                <span class="font-semibold text-gray-900 dark:text-white">{{ $post->user->name }}</span>
                                <p class="text-sm text-gray-500">{{ $post->user->bio ?? 'Writer' }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </header>

                {{-- ✅ LINK POSTINGAN ASLI (TETAP DIPERTAHANKAN) --}}
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

                {{-- Konten Utama --}}
                <div class="prose prose-lg dark:prose-invert max-w-none">
                    {!! $post->body !!}
                </div>

                {{-- Navigasi Bawah --}}
                <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('posts.index') }}" class="inline-flex items-center gap-2 px-5 py-3 bg-gray-100 hover:bg-gray-200 text-gray-900 rounded-lg transition">
                        &larr; Kembali ke Semua Postingan
                    </a>
                </div>
            </article>
            @endif
        </div>
    </main>
</x-layout>