@props(['post'])

<article class="bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700 overflow-hidden flex flex-col group h-full">
    
    {{-- GAMBAR --}}
    <a href="{{ route('posts.show', $post->slug) }}" class="block overflow-hidden relative h-40">
        @if ($post->featured_image && Storage::exists($post->featured_image))
            <img src="{{ Storage::url($post->featured_image) }}" 
                 alt="Gambar untuk {{ $post->title }}" 
                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300 ease-in-out"
                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
            
            {{-- Fallback jika gambar error --}}
            <div class="w-full h-full hidden items-center justify-center bg-gray-100 dark:bg-gray-700">
                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
        @else
            {{-- Placeholder standar --}}
            <div class="w-full h-full flex items-center justify-center bg-gray-100 dark:bg-gray-700">
                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
        @endif
    </a>

    {{-- KONTEN --}}
    <div class="p-4 flex flex-col flex-grow">
        <div class="flex-grow">
            {{-- Meta Header --}}
            <div class="flex justify-between items-center mb-3 text-gray-500 dark:text-gray-400">
                @if ($post->category)
                    {{-- PERUBAHAN: Link kategori dihapus, hanya menampilkan nama --}}
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
                         onerror="this.src='https://ui-avatars.com/api/?name=User&background=random&color=fff'"/>
                    
                    {{-- PERUBAHAN: Link author dihapus, style hover dihilangkan --}}
                    <span class="text-sm text-gray-700 dark:text-gray-300 font-medium truncate max-w-[100px]">
                        {{ $post->user->name }}
                    </span>
                @else
                    <span class="text-sm text-gray-500 dark:text-gray-400">Anonim</span>
                @endif
            </div>
            
            <a href="{{ route('posts.show', $post->slug) }}" 
               class="inline-flex items-center text-sm font-medium text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition-colors">
                Baca Selengkapnya
                <svg class="ml-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </a>
        </div>
    </div>
</article>