<aside 
    class="fixed top-0 left-0 z-40 h-screen bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 transition-all duration-500 ease-[cubic-bezier(0.34,1.56,0.64,1)] md:translate-x-0 will-change-transform"
    x-data="{ 
        dropdowns: {
            publikasi: {{ request()->is('dashboard/broadcasts*', 'dashboard/pola-acara*', 'dashboard/jadwal-acara*') ? 'true' : 'false' }},
            layanan: {{ request()->is('dashboard/ppid*', 'dashboard/info-rb*', 'dashboard/info-magang*', 'dashboard/info-kunjungan*') ? 'true' : 'false' }},
            kerjasama: {{ request()->is('dashboard/kerjasama-siaran*', 'dashboard/kerjasama-non-siaran*') ? 'true' : 'false' }},
            tentang: {{ request()->is('dashboard/sejarah*', 'dashboard/visi-misi*', 'dashboard/prestasi*', 'dashboard/tugas-fungsi*', 'dashboard/unit-kerja*', 'dashboard/himne-tvri*') ? 'true' : 'false' }}
        }
    }"
    x-init="
        $watch('isSidebarOpen', value => {
            if (!value) {
                // Tutup semua dropdown ketika sidebar dikecilkan
                dropdowns.publikasi = false;
                dropdowns.layanan = false;
                dropdowns.kerjasama = false;
                dropdowns.tentang = false;
            }
        })
    "
    :class="isSidebarOpen 
        ? 'translate-x-0 w-64' 
        : '-translate-x-full md:w-20' "
    style="padding-top: 4.5rem;">

    {{-- Sidebar Content --}}
    <div class="flex flex-col h-full scrollbar-hide">

        {{-- Scrollable Menu Area --}}
        <div class="flex-1 overflow-y-auto overflow-x-hidden py-5 px-3 scrollbar-hide">

            {{-- Menu Items --}}
            <ul class="space-y-2">

                {{-- Dashboard --}}
                <x-sidebar-item href="{{ url('/dashboard') }}" :active="request()->is('dashboard')" index="0">
                    <x-slot:icon>
                        <svg class="w-6 h-6 flex-shrink-0 transition-transform duration-200 group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                    </x-slot:icon>
                    Dashboard
                </x-sidebar-item>

                {{-- Dropdown Publikasi --}}
                @php 
                    $isPublikasiActive = request()->is('dashboard/broadcasts*', 'dashboard/pola-acara*', 'dashboard/jadwal-acara*'); 
                @endphp
                
                <li class="relative group"
                    @mouseenter.outside="if (!isSidebarOpen) dropdowns.publikasi = true"
                    @mouseleave.outside="if (!isSidebarOpen) dropdowns.publikasi = false">
                    <button 
                        @click.prevent="if (isSidebarOpen) dropdowns.publikasi = !dropdowns.publikasi"
                        class="flex items-center w-full p-2 text-base font-medium rounded-lg transition-all duration-200"
                        :class="{ 
                            'justify-center': !isSidebarOpen,
                            'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white': {{ $isPublikasiActive ? 'true' : 'false' }},
                            'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700': {{ !$isPublikasiActive ? 'true' : 'false' }}
                        }">
                        <svg class="w-6 h-6 flex-shrink-0 transition-transform duration-200 group-hover:scale-110" 
                             :class="{
                                'text-gray-900 dark:text-white': {{ $isPublikasiActive ? 'true' : 'false' }},
                                'text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white': {{ !$isPublikasiActive ? 'true' : 'false' }}
                             }"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polygon points="23 7 16 12 23 17 23 7"></polygon>
                            <rect x="1" y="5" width="15" height="14" rx="2" ry="2"></rect>
                        </svg>
                        <span class="ml-3 flex-1 text-left whitespace-nowrap" 
                              x-show="isSidebarOpen"
                              x-transition:enter="transition ease-out duration-200"
                              x-transition:enter-start="opacity-0"
                              x-transition:enter-end="opacity-100">
                            Publikasi
                        </span>
                        <svg class="w-4 h-4 ml-auto transition-transform duration-300" 
                             :class="{ 'rotate-90': dropdowns.publikasi }" 
                             x-show="isSidebarOpen" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </button>

                    <ul x-show="dropdowns.publikasi" 
                        x-transition:enter="transition-all ease-out duration-300"
                        x-transition:enter-start="max-h-0 opacity-0"
                        x-transition:enter-end="max-h-96 opacity-100"
                        x-transition:leave="transition-all ease-in duration-200"
                        x-transition:leave-start="max-h-96 opacity-100"
                        x-transition:leave-end="max-h-0 opacity-0"
                        :class="isSidebarOpen 
                            ? 'pl-11 mt-1 space-y-1 overflow-hidden' 
                            : 'absolute top-0 left-full ml-2 w-56 p-2 bg-white dark:bg-gray-800 rounded-lg shadow-xl border dark:border-gray-700 space-y-1 z-50'
                        "
                        x-cloak>
                        
                        <li>
                            {{-- Menggunakan route() agar lebih aman dan
                            mengecek 'broadcasts*' agar link-nya aktif --}}
                            <a href="{{ route('dashboard.broadcasts.index') }}" 
                            class="flex items-center gap-3 py-2 px-3 text-base rounded-md transition-colors duration-200"
                            :class="{
                                'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white font-medium': {{ request()->is('dashboard/broadcasts*') ? 'true' : 'false' }},
                                'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white': {{ !request()->is('dashboard/broadcasts*') ? 'true' : 'false' }}
                            }">
                                <svg class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M4 11a9 9 0 0 1 9 9"></path><path d="M4 4a16 16 0 0 1 16 16"></path><circle cx="5" cy="19" r="1"></circle>
                                </svg>
                                Penyiaran
                            </a>
                        </li>
                        <li>
                            <a href="/dashboard/pola-acara" 
                               class="flex items-center gap-3 py-2 px-3 text-base rounded-md transition-colors duration-200"
                               :class="{
                                   'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white font-medium': {{ request()->is('dashboard/pola-acara*') ? 'true' : 'false' }},
                                   'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white': {{ !request()->is('dashboard/pola-acara*') ? 'true' : 'false' }}
                               }">
                                <svg class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line>
                                </svg>
                                Pola Acara
                            </a>
                        </li>
                        <li>
                            <a href="/dashboard/jadwal-acara" 
                               class="flex items-center gap-3 py-2 px-3 text-base rounded-md transition-colors duration-200"
                               :class="{
                                   'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white font-medium': {{ request()->is('dashboard/jadwal-acara*') ? 'true' : 'false' }},
                                   'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white': {{ !request()->is('dashboard/jadwal-acara*') ? 'true' : 'false' }}
                               }">
                                <svg class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline>
                                </svg>
                                Jadwal Acara
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Dropdown Layanan --}}
                @php 
                    $isLayananActive = request()->is('dashboard/ppid*', 'dashboard/info-rb*', 'dashboard/info-magang*', 'dashboard/info-kunjungan*'); 
                @endphp
                <li class="relative group"
                    @mouseenter.outside="if (!isSidebarOpen) dropdowns.layanan = true"
                    @mouseleave.outside="if (!isSidebarOpen) dropdowns.layanan = false">
                    <button 
                        @click.prevent="if (isSidebarOpen) dropdowns.layanan = !dropdowns.layanan"
                        class="flex items-center w-full p-2 text-base font-medium rounded-lg transition-all duration-200"
                        :class="{ 
                            'justify-center': !isSidebarOpen,
                            'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white': {{ $isLayananActive ? 'true' : 'false' }},
                            'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700': {{ !$isLayananActive ? 'true' : 'false' }}
                        }">
                        <svg class="w-6 h-6 flex-shrink-0 transition-transform duration-200 group-hover:scale-110" 
                             :class="{
                                'text-gray-900 dark:text-white': {{ $isLayananActive ? 'true' : 'false' }},
                                'text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white': {{ !$isLayananActive ? 'true' : 'false' }}
                             }"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                        </svg>
                        <span class="ml-3 flex-1 text-left whitespace-nowrap" 
                              x-show="isSidebarOpen"
                              x-transition:enter="transition ease-out duration-200"
                              x-transition:enter-start="opacity-0"
                              x-transition:enter-end="opacity-100">
                            Layanan
                        </span>
                        <svg class="w-4 h-4 ml-auto transition-transform duration-300" 
                             :class="{ 'rotate-90': dropdowns.layanan }" 
                             x-show="isSidebarOpen" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </button>

                    <ul x-show="dropdowns.layanan" 
                        x-transition:enter="transition-all ease-out duration-300"
                        x-transition:enter-start="max-h-0 opacity-0"
                        x-transition:enter-end="max-h-96 opacity-100"
                        x-transition:leave="transition-all ease-in duration-200"
                        x-transition:leave-start="max-h-96 opacity-100"
                        x-transition:leave-end="max-h-0 opacity-0"
                        :class="isSidebarOpen 
                            ? 'pl-11 mt-1 space-y-1 overflow-hidden' 
                            : 'absolute top-0 left-full ml-2 w-56 p-2 bg-white dark:bg-gray-800 rounded-lg shadow-xl border dark:border-gray-700 space-y-1 z-50'
                        "
                        x-cloak>
                        
                        <li>
                            <a href="/dashboard/ppid" 
                               class="flex items-center gap-3 py-2 px-3 text-base rounded-md transition-colors duration-200"
                               :class="{
                                   'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white font-medium': {{ request()->is('dashboard/ppid*') ? 'true' : 'false' }},
                                   'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white': {{ !request()->is('dashboard/ppid*') ? 'true' : 'false' }}
                               }">
                                <svg class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 1a3 3 0 0 0-3 3v8a3 3 0 0 0 6 0V4a3 3 0 0 0-3-3z"></path><path d="M19 10v2a7 7 0 0 1-14 0v-2"></path><line x1="12" y1="19" x2="12" y2="23"></line><line x1="8" y1="23" x2="16" y2="23"></line>
                                </svg>
                                PPID
                            </a>
                        </li>
                        <li>
                            <a href="/dashboard/info-rb" 
                               class="flex items-center gap-3 py-2 px-3 text-base rounded-md transition-colors duration-200"
                               :class="{
                                   'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white font-medium': {{ request()->is('dashboard/info-rb*') ? 'true' : 'false' }},
                                   'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white': {{ !request()->is('dashboard/info-rb*') ? 'true' : 'false' }}
                               }">
                                <svg class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                                </svg>
                                Informasi RB
                            </a>
                        </li>
                        <li>
                            <a href="/dashboard/info-magang" 
                               class="flex items-center gap-3 py-2 px-3 text-base rounded-md transition-colors duration-200"
                               :class="{
                                   'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white font-medium': {{ request()->is('dashboard/info-magang*') ? 'true' : 'false' }},
                                   'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white': {{ !request()->is('dashboard/info-magang*') ? 'true' : 'false' }}
                               }">
                                <svg class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                                </svg>
                                Info Magang / PKL
                            </a>
                        </li>
                        <li>
                            <a href="/dashboard/info-kunjungan" 
                               class="flex items-center gap-3 py-2 px-3 text-base rounded-md transition-colors duration-200"
                               :class="{
                                   'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white font-medium': {{ request()->is('dashboard/info-kunjungan*') ? 'true' : 'false' }},
                                   'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white': {{ !request()->is('dashboard/info-kunjungan*') ? 'true' : 'false' }}
                               }">
                                <svg class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle>
                                </svg>
                                Info Kunjungan
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Dropdown Kerjasama --}}
                @php 
                    $isKerjasamaActive = request()->is('dashboard/kerjasama-siaran*', 'dashboard/kerjasama-non-siaran*'); 
                @endphp
                <li class="relative group"
                    @mouseenter.outside="if (!isSidebarOpen) dropdowns.kerjasama = true"
                    @mouseleave.outside="if (!isSidebarOpen) dropdowns.kerjasama = false">
                    <button 
                        @click.prevent="if (isSidebarOpen) dropdowns.kerjasama = !dropdowns.kerjasama"
                        class="flex items-center w-full p-2 text-base font-medium rounded-lg transition-all duration-200"
                        :class="{ 
                            'justify-center': !isSidebarOpen,
                            'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white': {{ $isKerjasamaActive ? 'true' : 'false' }},
                            'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700': {{ !$isKerjasamaActive ? 'true' : 'false' }}
                        }">
                        <svg class="w-6 h-6 flex-shrink-0 transition-transform duration-200 group-hover:scale-110" 
                             :class="{
                                'text-gray-900 dark:text-white': {{ $isKerjasamaActive ? 'true' : 'false' }},
                                'text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white': {{ !$isKerjasamaActive ? 'true' : 'false' }}
                             }"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                        <span class="ml-3 flex-1 text-left whitespace-nowrap" 
                              x-show="isSidebarOpen"
                              x-transition:enter="transition ease-out duration-200"
                              x-transition:enter-start="opacity-0"
                              x-transition:enter-end="opacity-100">
                            Kerjasama
                        </span>
                        <svg class="w-4 h-4 ml-auto transition-transform duration-300" 
                             :class="{ 'rotate-90': dropdowns.kerjasama }" 
                             x-show="isSidebarOpen" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </button>

                    <ul x-show="dropdowns.kerjasama" 
                        x-transition:enter="transition-all ease-out duration-300"
                        x-transition:enter-start="max-h-0 opacity-0"
                        x-transition:enter-end="max-h-96 opacity-100"
                        x-transition:leave="transition-all ease-in duration-200"
                        x-transition:leave-start="max-h-96 opacity-100"
                        x-transition:leave-end="max-h-0 opacity-0"
                        :class="isSidebarOpen 
                            ? 'pl-11 mt-1 space-y-1 overflow-hidden' 
                            : 'absolute top-0 left-full ml-2 w-56 p-2 bg-white dark:bg-gray-800 rounded-lg shadow-xl border dark:border-gray-700 space-y-1 z-50'
                        "
                        x-cloak>
                        
                        <li>
                            <a href="/dashboard/kerjasama-siaran" 
                               class="flex items-center gap-3 py-2 px-3 text-base rounded-md transition-colors duration-200"
                               :class="{
                                   'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white font-medium': {{ request()->is('dashboard/kerjasama-siaran*') ? 'true' : 'false' }},
                                   'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white': {{ !request()->is('dashboard/kerjasama-siaran*') ? 'true' : 'false' }}
                               }">
                                <svg class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 1a3 3 0 0 0-3 3v8a3 3 0 0 0 6 0V4a3 3 0 0 0-3-3z"></path><path d="M19 10v2a7 7 0 0 1-14 0v-2"></path><line x1="12" y1="19" x2="12" y2="23"></line><line x1="8" y1="23" x2="16" y2="23"></line>
                                </svg>
                                Siaran
                            </a>
                        </li>
                        <li>
                            <a href="/dashboard/kerjasama-non-siaran" 
                               class="flex items-center gap-3 py-2 px-3 text-base rounded-md transition-colors duration-200"
                               :class="{
                                   'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white font-medium': {{ request()->is('dashboard/kerjasama-non-siaran*') ? 'true' : 'false' }},
                                   'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white': {{ !request()->is('dashboard/kerjasama-non-siaran*') ? 'true' : 'false' }}
                               }">
                                <svg class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                                </svg>
                                Non-Siaran
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Postingan --}}
                <x-sidebar-item href="/dashboard/posts" :active="request()->is('dashboard/posts*')" index="1">
                    <x-slot:icon>
                        <svg class="w-6 h-6 flex-shrink-0 transition-transform duration-200 group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline>
                        </svg>
                    </x-slot:icon>
                    Postingan
                </x-sidebar-item>

                {{-- Dropdown Tentang --}}
                @php 
                    $isTentangActive = request()->is('dashboard/sejarah*', 'dashboard/visi-misi*', 'dashboard/prestasi*', 'dashboard/tugas-fungsi*', 'dashboard/unit-kerja*', 'dashboard/himne-tvri*'); 
                @endphp
                <li class="relative group"
                    @mouseenter.outside="if (!isSidebarOpen) dropdowns.tentang = true"
                    @mouseleave.outside="if (!isSidebarOpen) dropdowns.tentang = false">
                    <button 
                        @click.prevent="if (isSidebarOpen) dropdowns.tentang = !dropdowns.tentang"
                        class="flex items-center w-full p-2 text-base font-medium rounded-lg transition-all duration-200"
                        :class="{ 
                            'justify-center': !isSidebarOpen,
                            'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white': {{ $isTentangActive ? 'true' : 'false' }},
                            'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700': {{ !$isTentangActive ? 'true' : 'false' }}
                        }">
                        <svg class="w-6 h-6 flex-shrink-0 transition-transform duration-200 group-hover:scale-110" 
                             :class="{
                                'text-gray-900 dark:text-white': {{ $isTentangActive ? 'true' : 'false' }},
                                'text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white': {{ !$isTentangActive ? 'true' : 'false' }}
                             }"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line>
                        </svg>
                        <span class="ml-3 flex-1 text-left whitespace-nowrap" 
                              x-show="isSidebarOpen"
                              x-transition:enter="transition ease-out duration-200"
                              x-transition:enter-start="opacity-0"
                              x-transition:enter-end="opacity-100">
                            Tentang
                        </span>
                        <svg class="w-4 h-4 ml-auto transition-transform duration-300" 
                             :class="{ 'rotate-90': dropdowns.tentang }" 
                             x-show="isSidebarOpen" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </button>

                    <ul x-show="dropdowns.tentang" 
                        x-transition:enter="transition-all ease-out duration-300"
                        x-transition:enter-start="max-h-0 opacity-0"
                        x-transition:enter-end="max-h-96 opacity-100"
                        x-transition:leave="transition-all ease-in duration-200"
                        x-transition:leave-start="max-h-96 opacity-100"
                        x-transition:leave-end="max-h-0 opacity-0"
                        :class="isSidebarOpen 
                            ? 'pl-11 mt-1 space-y-1 overflow-hidden' 
                            : 'absolute top-0 left-full ml-2 w-56 p-2 bg-white dark:bg-gray-800 rounded-lg shadow-xl border dark:border-gray-700 space-y-1 z-50'
                        "
                        x-cloak>
                        
                        <li>
                            <a href="/dashboard/sejarah" 
                               class="flex items-center gap-3 py-2 px-3 text-base rounded-md transition-colors duration-200"
                               :class="{
                                   'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white font-medium': {{ request()->is('dashboard/sejarah*') ? 'true' : 'false' }},
                                   'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white': {{ !request()->is('dashboard/sejarah*') ? 'true' : 'false' }}
                               }">
                                <svg class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                                </svg>
                                Sejarah
                            </a>
                        </li>
                        <li>
                            <a href="/dashboard/visi-misi" 
                               class="flex items-center gap-3 py-2 px-3 text-base rounded-md transition-colors duration-200"
                               :class="{
                                   'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white font-medium': {{ request()->is('dashboard/visi-misi*') ? 'true' : 'false' }},
                                   'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white': {{ !request()->is('dashboard/visi-misi*') ? 'true' : 'false' }}
                               }">
                                <svg class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>
                                </svg>
                                Visi dan Misi
                            </a>
                        </li>
                        <li>
                            <a href="/dashboard/tugas-fungsi" 
                               class="flex items-center gap-3 py-2 px-3 text-base rounded-md transition-colors duration-200"
                               :class="{
                                   'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white font-medium': {{ request()->is('dashboard/tugas-fungsi*') ? 'true' : 'false' }},
                                   'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white': {{ !request()->is('dashboard/tugas-fungsi*') ? 'true' : 'false' }}
                               }">
                                <svg class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                                </svg>
                                Tugas dan Fungsi
                            </a>
                        </li>
                        <li>
                            <a href="/dashboard/unit-kerja" 
                               class="flex items-center gap-3 py-2 px-3 text-base rounded-md transition-colors duration-200"
                               :class="{
                                   'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white font-medium': {{ request()->is('dashboard/unit-kerja*') ? 'true' : 'false' }},
                                   'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white': {{ !request()->is('dashboard/unit-kerja*') ? 'true' : 'false' }}
                               }">
                                <svg class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect>
                                </svg>
                                Unit Kerja
                            </a>
                        </li>
                        <li>
                            <a href="/dashboard/prestasi" 
                               class="flex items-center gap-3 py-2 px-3 text-base rounded-md transition-colors duration-200"
                               :class="{
                                   'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white font-medium': {{ request()->is('dashboard/prestasi*') ? 'true' : 'false' }},
                                   'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white': {{ !request()->is('dashboard/prestasi*') ? 'true' : 'false' }}
                               }">
                                <svg class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="8" r="7"></circle><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline>
                                </svg>
                                Prestasi
                            </a>
                        </li>
                        <li>
                            <a href="/dashboard/himne-tvri" 
                               class="flex items-center gap-3 py-2 px-3 text-base rounded-md transition-colors duration-200"
                               :class="{
                                   'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white font-medium': {{ request()->is('dashboard/himne-tvri*') ? 'true' : 'false' }},
                                   'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white': {{ !request()->is('dashboard/himne-tvri*') ? 'true' : 'false' }}
                               }">
                                <svg class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M9 18V5l12-2v13"></path><circle cx="6" cy="18" r="3"></circle><circle cx="18" cy="16" r="3"></circle>
                                </svg>
                                Himne TVRI
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
            
            {{-- Divider pemisah sebelum menu Banner --}}
            <hr class="my-6 border-t border-gray-300 dark:border-gray-600" />

            {{-- Menu Banner --}}
            <ul class="mt-2">
                <x-sidebar-item href="{{ url('/dashboard/banners') }}" :active="request()->is('dashboard/banners*')" index="2">
                    <x-slot:icon>
                        <svg class="w-6 h-6 flex-shrink-0 transition-transform duration-200 group-hover:scale-110" 
                             fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline>
                        </svg>
                    </x-slot:icon>
                    Banner Carousel
                </x-sidebar-item>
            </ul>
        </div>

        {{-- Sidebar Footer --}}
        <div class="p-3 border-t border-gray-200 dark:border-gray-700 scrollbar-hide">
            <div class="flex items-center justify-between">
                <button 
                    @click="isSidebarOpen = !isSidebarOpen"
                    class="hidden md:flex w-full items-center p-3 text-sm font-medium text-gray-500 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-all duration-200 group"
                    :class="{ 'justify-center': !isSidebarOpen }">
                    
                    <svg class="w-5 h-5 flex-shrink-0 transition-transform duration-300 group-hover:scale-110" 
                         :class="{ 'rotate-180': !isSidebarOpen }"
                         fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="11 17 6 12 11 7"></polyline><polyline points="18 17 13 12 18 7"></polyline>
                    </svg>

                    <span class="ml-3 transition-opacity duration-300"
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
    </div>
</aside>