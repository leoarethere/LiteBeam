{{-- ✅ IMPROVISASI: Menyamakan efek transparan untuk mode terang dan gelap seperti frontend --}}
<nav class="bg-white dark:bg-gray-800 fixed w-full top-0 z-50 border-b border-gray-200 dark:border-gray-700 transition-colors duration-300 shadow-lg"
     x-data="{
         isMobileMenuOpen: false,
         openDropdown: null,
         timeoutId: null,
         openMenu(name) {
             clearTimeout(this.timeoutId);
             this.openDropdown = name;
         },
         closeMenu() {
             this.timeoutId = setTimeout(() => {
                 this.openDropdown = null;
             }, 300); // ⏱ Delay 300ms sebelum menutup
         }
     }">
    
    {{-- ✅ PERBAIKAN: Layout container dengan padding yang sama seperti frontend --}}
    <div class="px-4 sm:px-4 lg:px-4">
        <div class="relative flex h-[72px] items-center justify-between">
            
            {{-- Bagian Kiri: Logo & Toggle Sidebar --}}
            <div class="flex items-center space-x-0">
                {{-- Toggle Sidebar untuk Mobile --}}
                <button 
                    @click="isSidebarOpen = !isSidebarOpen"
                    class="md:hidden p-2 text-gray-600 dark:text-gray-400 rounded-lg cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white focus:outline-none focus:ring-2 focus:ring-gray-100 dark:focus:ring-gray-700 transition-colors duration-200">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                    </svg>
                </button>

                {{-- Logo & Brand --}}
                <a href="{{ url('/') }}" class="flex items-center gap-2">
                    {{-- 1. Logo Gelap (Tampil di Light Mode, Hilang di Dark Mode) --}}
                    <img src="{{ asset('img/logolight.png') }}" 
                        class="h-9 md:h-12 w-auto block dark:hidden" 
                        alt="LiteBeam Logo Dark" />

                    {{-- 2. Logo Terang (Hilang di Light Mode, Tampil di Dark Mode) --}}
                    <img src="{{ asset('img/logodark.png') }}" 
                        class="h-9 md:h-12 w-auto hidden dark:block" 
                        alt="LiteBeam Logo Light" />

                    <span class="text-gray-900 dark:text-white font-bold text-xl sm:text-2xl whitespace-nowrap">
                        Yogyakarta
                    </span>
                </a>
            </div>

            {{-- Bagian Kanan: Menu Desktop & User Controls --}}
            <div class="hidden lg:flex items-center space-x-4">
                {{-- Quick Actions --}}
                <div class="flex items-center space-x-1">
                    {{-- Theme Toggle untuk Desktop --}}
                    <div>
                        <x-theme-toggle />
                    </div>
                </div>

                {{-- User Dropdown --}}
                <div class="relative" @mouseenter="openMenu('user')" @mouseleave="closeMenu()">
                    <button 
                        @click="openDropdown = openDropdown === 'user' ? null : 'user'" 
                        class="group flex items-center gap-2 rounded-lg px-4 py-3 text-base font-medium transition-all duration-200 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white">
                        <img class="w-8 h-8 rounded-full" 
                             src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=random&color=fff" 
                             alt="{{ auth()->user()->name }}" />
                        <span class="hidden sm:block">{{ auth()->user()->name }}</span>
                        <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': openDropdown === 'user' }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    
                    {{-- Dropdown Menu --}}
                    <div x-show="openDropdown === 'user'"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 translate-y-1"
                         class="absolute right-0 mt-2 w-56 bg-white dark:bg-gray-800 rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 z-20 py-1" style="display: none;">
                        
                        {{-- User Info --}}
                        <div class="py-3 px-4 border-b border-gray-100 dark:border-gray-600">
                            <span class="block text-sm font-semibold text-gray-900 dark:text-white">{{ auth()->user()->name }}</span>
                            <span class="block text-sm text-gray-500 truncate dark:text-gray-400">{{ auth()->user()->email }}</span>
                        </div>

                        {{-- Logout --}}
                        <ul class="py-1 border-t border-gray-100 dark:border-gray-600">
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    {{-- ✅ PERBAIKAN KONSISTENSI: Menggunakan flex dan gap-2 (sebelumnya inline mr-2) --}}
                                    <button type="submit" 
                                        class="w-full text-left flex items-center gap-2 px-4 py-2 text-sm transition-colors duration-200 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        Sign out
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Bagian Kanan: Menu Mobile --}}
            <div class="flex items-center lg:hidden space-x-2">
                {{-- Theme Toggle untuk Mobile --}}
                <div class="ml-2 border-l border-gray-200 dark:border-gray-700 pl-2">
                    <x-theme-toggle />
                </div>
                {{-- Mobile Menu Toggle --}}
                <button @click="isMobileMenuOpen = !isMobileMenuOpen" 
                        type="button" 
                        class="inline-flex items-center justify-center rounded-lg p-2.5 text-gray-500 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500 transition-colors duration-200">
                    <span class="sr-only">Toggle menu</span>
                    <svg class="h-6 w-6" :class="{ 'hidden': isMobileMenuOpen, 'block': !isMobileMenuOpen }" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                    <svg class="h-6 w-6" :class="{ 'block': isMobileMenuOpen, 'hidden': !isMobileMenuOpen }" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Menu Mobile --}}
    {{-- ✅ IMPROVISASI: Menyamakan efek transparan untuk menu mobile --}}
    <div x-show="isMobileMenuOpen" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-1"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-1"
         class="lg:hidden border-t border-gray-200 dark:border-gray-700/50 bg-white/75 dark:bg-gray-800/55 backdrop-blur-lg"
         style="display: none;">
        <div class="px-4 pt-4 pb-3">
            {{-- User Info Mobile --}}
            <div class="flex items-center space-x-3 mb-4 pb-4 border-b border-gray-200 dark:border-gray-600">
                <img class="w-10 h-10 rounded-full" 
                     src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=random&color=fff" 
                     alt="{{ auth()->user()->name }}" />
                <div>
                    <span class="block text-sm font-semibold text-gray-900 dark:text-white">{{ auth()->user()->name }}</span>
                    <span class="block text-sm text-gray-500 dark:text-gray-400">{{ auth()->user()->email }}</span>
                </div>
            </div>

            {{-- Mobile Menu Items --}}
            <div class="flex flex-col space-y-2">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    {{-- ✅ PERBAIKAN KONSISTENSI: Menggunakan gap-3 (sebelumnya mr-3) --}}
                    <button type="submit" 
                        class="w-full flex items-center gap-3 rounded-lg px-4 py-3 text-base font-medium transition-all duration-200 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Sign out
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>