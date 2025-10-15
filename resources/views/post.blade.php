<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <main class="pt-8 pb-16 lg:pt-16 lg:pb-24 bg-white dark:bg-gray-900 antialiased">
        <div class="flex justify-between px-4 mx-auto max-w-screen-xl">
            <article class="mx-auto w-full max-w-8xl format format-sm sm:format-base lg:format-lg format-blue dark:format-invert">

                <header class="mb-4 lg:mb-6 not-format">
                    {{-- META KATEGORI & TANGGAL --}}
                    <div class="flex justify-between items-center mb-5 text-gray-500">
                        <span class="{{ $post->category->color_classes }} text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded dark:text-primary-900">
                            <a href="/posts?category={{ $post->category->slug }}" class="hover:underline font-medium">
                                {{ $post->category->name }}
                            </a>
                        </span>
                        <span class="text-sm">
                            {{ $post->created_at->diffForHumans() }}
                        </span>
                    </div>

                    {{-- JUDUL UTAMA POST --}}
                    <h1 class="mb-4 text-3xl font-extrabold leading-tight text-gray-900 lg:mb-6 lg:text-4xl dark:text-white">
                        {{ $post->title }}
                    </h1>

                    {{-- INFORMASI PENULIS --}}
                    <div class="flex items-center space-x-4 mb-6">
                        <img class="w-10 h-10 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode($post->author->name) }}" alt="{{ $post->author->name }}'s avatar" />
                        <div>
                            <a href="/posts?author={{ $post->author->username }}"  class="font-medium dark:text-white hover:underline">
                                {{ $post->author->name }}
                            </a>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $post->author->bio ?? 'Content Writer' }}</p>
                        </div>
                    </div>
                </header>

                {{-- KONTEN UTAMA POST --}}
                <div class="prose dark:prose-invert max-w-none">
                    {!! $post->body !!}
                </div>

                {{-- TOMBOL KEMBALI --}}
                <div class="mt-8">
                    <a href="/posts" class="inline-block px-5 py-3 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition duration-150 ease-in-out">
                        &laquo; Kembali ke Semua Postingan
                    </a>
                </div>

            </article>
        </div>
    </main>
</x-layout>