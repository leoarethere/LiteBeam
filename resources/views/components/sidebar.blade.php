<aside 
    class="fixed top-0 left-0 z-40 h-screen bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 transition-all duration-500 ease-[cubic-bezier(0.34,1.56,0.64,1)]"
    :class="{
        'w-64 translate-x-0': isSidebarOpen,
        'w-64 -translate-x-full': !isSidebarOpen,
        'md:translate-x-0 md:w-64': isSidebarOpen,
        'md:translate-x-0 md:w-20': !isSidebarOpen
    }"
    style="padding-top: 4rem;">
    
    {{-- Sidebar Content --}}
    <div class="overflow-y-auto py-5 px-3 h-full">
        <ul class="space-y-2">
            {{-- Dashboard --}}
            <x-sidebar-item href="{{ url('/dashboard') }}" :active="request()->is('dashboard')" index="0">
                <x-slot:icon>
                    <svg class="w-6 h-6 flex-shrink-0 transition-transform duration-200 group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                </x-slot:icon>
                Dashboard
            </x-sidebar-item>

            {{-- Informasi --}}
            <x-sidebar-item href="/info-publikasi" :active="request()->is('info-publikasi*')" index="1">
                <x-slot:icon>
                    <svg class="w-6 h-6 flex-shrink-0 transition-transform duration-200 group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </x-slot:icon>
                Informasi
            </x-sidebar-item>

            {{-- Penyiaran --}}
            <x-sidebar-item href="/penyiaran" :active="request()->is('penyiaran*')" index="2">
                <x-slot:icon>
                    <svg class="w-6 h-6 flex-shrink-0 transition-transform duration-200 group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>
                </x-slot:icon>
                Penyiaran
            </x-sidebar-item>

            {{-- Postingan --}}
            <x-sidebar-item href="/dashboard/posts" :active="request()->is('dashboard/posts*')" index="3">
                <x-slot:icon>
                    <svg class="w-6 h-6 flex-shrink-0 transition-transform duration-200 group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                </x-slot:icon>
                Postingan
            </x-sidebar-item>
            
            {{-- PERUBAHAN 1: TAMBAHKAN MENU BANNER CAROUSEL --}}
            <x-sidebar-item href="{{ route('banners.index') }}" :active="request()->is('dashboard/banners*')" index="4">
                <x-slot:icon>
                    <svg class="w-6 h-6 flex-shrink-0 transition-transform duration-200 group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l-1.586-1.586a2 2 0 00-2.828 0L6 14m6-6l.01.01" />
                    </svg>
                </x-slot:icon>
                Banner Carousel
            </x-sidebar-item>
        </ul>

        {{-- Divider --}}
        <div class="my-4 border-t border-gray-200 dark:border-gray-700"></div>

        {{-- Additional Menu Section --}}
        <ul class="space-y-2">
            {{-- PERUBAHAN 2: SESUAIKAN INDEX PADA MENU SETTINGS --}}
            <x-sidebar-item href="/settings" :active="request()->is('settings*')" index="5">
                <x-slot:icon>
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </x-slot:icon>
                Settings
            </x-sidebar-item>
        </ul>

        {{-- Toggle Button di Bottom --}}
        <div class="absolute bottom-6 left-0 right-0 px-3">
            <button 
                @click="isSidebarOpen = !isSidebarOpen"
                class="hidden md:flex w-full items-center p-3 text-sm font-medium text-gray-500 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-all duration-200 group"
                :class="{ 'justify-center': !isSidebarOpen }">
                <svg class="w-5 h-5 flex-shrink-0 transition-transform duration-200 group-hover:scale-110" 
                     :class="{ 'rotate-180': !isSidebarOpen }"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                </svg>
                <span class="ml-3 transition-opacity duration-200" 
                      x-show="isSidebarOpen"
                      x-transition:enter="transition ease-out duration-200"
                      x-transition:enter-start="opacity-0"
                      x-transition:enter-end="opacity-100"
                      x-transition:leave="transition ease-in duration-150"
                      x-transition:leave-start="opacity-100"
                      x-transition:leave-end="opacity-0">
                    Collapse
                </span>
            </button>
        </div>
    </div>
</aside>