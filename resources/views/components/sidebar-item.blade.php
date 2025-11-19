@props(['href', 'active' => false, 'index' => 0])

<li>
    <a href="{{ $href }}"
       :class="{ 'justify-center': !isSidebarOpen }"
       @class([
           'flex items-center p-2 text-base font-medium rounded-lg group',
           // Terapkan class ini jika link sedang AKTIF
           'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' => $active,
           // Terapkan class ini jika link TIDAK AKTIF
           'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' => !$active,
       ])>

        {{-- Ikon --}}
        <div @class([
            'flex-shrink-0 transition-transform duration-200 group-hover:scale-110',
            // Class untuk ikon saat AKTIF
            'text-gray-900 dark:text-white' => $active,
            // Class untuk ikon saat TIDAK AKTIF
            'text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white' => !$active,
        ])>
            {{ $icon }}
        </div>

        {{-- Teks --}}
        <div x-show="isSidebarOpen"
             x-transition:enter="transition-all ease-out duration-200"
             :style="`transition-delay: ${({{ $index }} * 50) + 50}ms`"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             class="flex-1 ml-3 whitespace-nowrap">
            {{ $slot }}
        </div>
    </a>
</li>