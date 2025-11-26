@props(['post'])

<article class="bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700 overflow-hidden flex flex-col group h-full">
    
    {{-- GAMBAR dengan Responsive Images --}}
    <a href="{{ route('posts.show', $post->slug) }}" class="block overflow-hidden relative h-40">
        <x-responsive-image 
            :path="$post->featured_image" 
            :alt="$post->title"
            sizes="(max-width: 640px) 100vw, (max-width: 1024px) 50vw, 33vw"
            loading="lazy"
            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300 ease-in-out"
        />
    </a>

    {{-- KONTEN --}}
    <div class="p-4 flex flex-col flex-grow">
        <div class="flex-grow">
            {{-- Meta Header --}}
            <div class="flex justify-between items-center mb-3 text-gray-500 dark:text-gray-400">
                @if ($post->category)
                    <span class="text-xs font-medium inline-flex items-center px-2 py-0.5 rounded {{ $post->category->color_classes ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                        {{ $post->category->name }}
                    </span>
                @endif
                <span class="text-xs">{{ $post->created_at->diffForHumans() }}</span>
            </div>

            {{-- Judul --}}
            <h2 class="mb-2 text-xl font-bold text-gray-900 dark:text-white leading-tight line-clamp-2 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                <a href="{{ route('posts.show', $post->slug) }}">{{ $post->title }}</a>
            </h2>

            {{-- Excerpt --}}
            <p class="mb-3 text-gray-600 dark:text-gray-300 text-sm leading-relaxed line-clamp-2">
                {{ $post->excerpt ?? Str::limit(strip_tags($post->body), 120) }}
            </p>
        </div>
        
        {{-- Footer --}}
        <div class="flex justify-between items-center mt-auto pt-3 border-t border-gray-100 dark:border-gray-700">
            <div class="flex items-center space-x-2">
                @if ($post->user)
                    <img class="w-6 h-6 rounded-full" 
                         src="https://ui-avatars.com/api/?name={{ urlencode($post->user->name) }}&background=random&color=fff" 
                         alt="{{ $post->user->name }}" 
                         loading="lazy"
                         onerror="this.src='https://ui-avatars.com/api/?name=User&background=random&color=fff'"/>
                    
                    <span class="text-sm text-gray-700 dark:text-gray-300 font-medium truncate max-w-[100px]">
                        {{ $post->user->name }}
                    </span>
                @else
                    <span class="text-sm text-gray-500 dark:text-gray-400">Anonim</span>
                @endif
            </div>
            
            <a href="{{ route('posts.show', $post->slug) }}" 
               class="inline-flex items-center text-sm font-medium text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition-colors">
                Baca
                <svg class="ml-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </a>
        </div>
    </div>
</article>