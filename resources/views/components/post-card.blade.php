@props(['post'])

<article class="p-6 bg-gray-800 rounded-lg border border-gray-700 shadow-md">
    <div class="flex justify-between items-center mb-5 text-gray-400">
        <span class="text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded bg-primary-900 text-primary-300">
            <a href="/category/{{ $post->category->slug }}" class="hover:underline font-medium">
                {{ $post->category->name }}
            </a>
        </span>
        <span class="text-sm">{{ $post->created_at->diffForHumans() }}</span>
    </div>

    <h2 class="hover:underline mb-2 text-2xl font-bold tracking-tight text-white">
        <a href="/posts/{{ $post->slug }}">{{ $post->title }}</a>
    </h2>

    <p class="mb-5 font-light text-gray-400">
        {{ $post->excerpt ?? Str::limit(strip_tags($post->body), 150) }}
    </p>

    <div class="flex justify-between items-center">
        <div class="flex items-center space-x-4">
            <img class="w-7 h-7 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode($post->author->name) }}&background=random" alt="{{ $post->author->name }}'s avatar" />
            <span class="font-medium text-white">
                <a href="/author/{{ $post->author->username }}" class="hover:underline">
                    {{ $post->author->name }}
                </a>
            </span>
        </div>
        
        <a href="/posts/{{ $post->slug }}" class="inline-flex items-center font-medium text-primary-500 hover:underline">
            Baca selengkapnya
            <svg class="ml-2 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
            </svg>
        </a>
    </div>
</article>