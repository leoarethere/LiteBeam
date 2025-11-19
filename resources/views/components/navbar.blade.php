{{-- fileName: navbar.blade.php --}}
{{-- ✅ IMPROVISASI: Menyamakan efek transparan untuk mode terang dan gelap --}}
<nav class="bg-white dark:bg-gray-800 backdrop-blur-sm fixed w-full top-0 z-50 border-b border-gray-200 dark:border-gray-700 transition-colors duration-300 shadow-lg"
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
    
    {{-- ✅ PERBAIKAN: Container disesuaikan. Menggunakan 'mx-auto' agar tetap di tengah --}}
    <div class="container mx-auto px-4 sm:px-6 xl:px-8">
        <div class="relative flex h-[72px] items-center justify-between">
            
            {{-- Bagian Kiri: Logo --}}
            <div class="flex-shrink-0">
                <a href="/" class="flex items-center gap-3">
                    <img src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=500" 
                         alt="Your Company" 
                         class="h-10 w-10 sm:h-12 sm:w-12" />
                    <span class="text-gray-900 dark:text-white font-bold text-xl sm:text-2xl whitespace-nowrap">Yogyakarta</span>
                </a>
            </div>

            {{-- Bagian Kanan: Navigasi Desktop & Theme Toggle --}}
            {{-- 🔴 PERUBAHAN PENTING: Mengganti 'hidden lg:flex' menjadi 'hidden xl:flex' --}}
            {{-- Ini akan menyembunyikan menu desktop LEBIH CEPAT jika layar menyempit (misal kena sidebar) --}}
            <div class="hidden xl:flex items-center">
                <div class="flex items-center space-x-1">
                    {{-- Nav Links Desktop --}}
                    <a href="/" class="group flex items-center gap-2 rounded-lg px-4 py-3 text-base font-medium transition-all duration-200 {{ request()->is('/') ? 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white shadow-lg' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                        <span>Home</span>
                    </a>

                    {{-- Dropdown Publikasi --}}
                    @php $isPublikasiActive = request()->is('penyiaran*', 'pola-acara*', 'jadwal-acara*'); @endphp
                    <div class="relative" @mouseenter="openMenu('publikasi')" @mouseleave="closeMenu()">
                        <button 
                            @click="openDropdown = openDropdown === 'publikasi' ? null : 'publikasi'" 
                            class="group flex items-center gap-2 rounded-lg px-4 py-3 text-base font-medium transition-all duration-200 {{ $isPublikasiActive ? 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white shadow-lg' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polygon points="23 7 16 12 23 17 23 7"></polygon>
                                <rect x="1" y="5" width="15" height="14" rx="2" ry="2"></rect>
                            </svg>
                            <span>Publikasi</span>
                            <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': openDropdown === 'publikasi' }" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </button>
                        <div x-show="openDropdown === 'publikasi'" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 translate-y-1"
                             class="absolute mt-2 w-56 bg-white dark:bg-gray-800 rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 z-20 py-1" style="display: none;">
                            
                            <a href="/penyiaran" class="flex items-center gap-3 px-4 py-2 text-sm transition-colors duration-200 {{ request()->is('penyiaran*') ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M4 11a9 9 0 0 1 9 9"></path><path d="M4 4a16 16 0 0 1 16 16"></path><circle cx="5" cy="19" r="1"></circle>
                                </svg>
                                <span>Penyiaran</span>
                            </a>
                            <a href="/pola-acara" class="flex items-center gap-3 px-4 py-2 text-sm transition-colors duration-200 {{ request()->is('pola-acara*') ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line>
                                </svg>
                                <span>Pola Acara</span>
                            </a>
                            <a href="/jadwal-acara" class="flex items-center gap-3 px-4 py-2 text-sm transition-colors duration-200 {{ request()->is('jadwal-acara*') ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline>
                                </svg>
                                <span>Jadwal Acara</span>
                            </a>
                        </div>
                    </div>

                    {{-- Dropdown Layanan --}}
                    @php $isLayananActive = request()->is('ppid*', 'info-rb*', 'info-magang*', 'info-kunjungan*'); @endphp
                    <div class="relative" @mouseenter="openMenu('layanan')" @mouseleave="closeMenu()">
                        <button 
                            @click="openDropdown = openDropdown === 'layanan' ? null : 'layanan'" 
                            class="group flex items-center gap-2 rounded-lg px-4 py-3 text-base font-medium transition-all duration-200 {{ $isLayananActive ? 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white shadow-lg' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                            </svg>
                            <span>Layanan</span>
                            <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': openDropdown === 'layanan' }" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </button>
                        <div x-show="openDropdown === 'layanan'"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 translate-y-1"
                             class="absolute mt-2 w-56 bg-white dark:bg-gray-800 rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 z-20 py-1" style="display: none;">
                            
                            <a href="/ppid" class="flex items-center gap-3 px-4 py-2 text-sm transition-colors duration-200 {{ request()->is('ppid*') ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 1a3 3 0 0 0-3 3v8a3 3 0 0 0 6 0V4a3 3 0 0 0-3-3z"></path><path d="M19 10v2a7 7 0 0 1-14 0v-2"></path><line x1="12" y1="19" x2="12" y2="23"></line><line x1="8" y1="23" x2="16" y2="23"></line>
                                </svg>
                                <span>PPID</span>
                            </a>
                            <a href="/info-rb" class="flex items-center gap-3 px-4 py-2 text-sm transition-colors duration-200 {{ request()->is('info-rb*') ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                                </svg>
                                <span>Informasi RB</span>
                            </a>
                            <a href="/info-magang" class="flex items-center gap-3 px-4 py-2 text-sm transition-colors duration-200 {{ request()->is('info-magang*') ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                                </svg>
                                <span>Info Magang / PKL</span>
                            </a>
                            <a href="/info-kunjungan" class="flex items-center gap-3 px-4 py-2 text-sm transition-colors duration-200 {{ request()->is('info-kunjungan*') ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle>
                                </svg>
                                <span>Info Kunjungan</span>
                            </a>
                        </div>
                    </div>

                    {{-- Dropdown Kerjasama --}}
                    @php $isKerjasamaActive = request()->is('kerjasama-siaran*', 'kerjasama-non-siaran*'); @endphp
                    <div class="relative" @mouseenter="openMenu('kerjasama')" @mouseleave="closeMenu()">
                        <button 
                            @click="openDropdown = openDropdown === 'kerjasama' ? null : 'kerjasama'" 
                            class="group flex items-center gap-2 rounded-lg px-4 py-3 text-base font-medium transition-all duration-200 {{ $isKerjasamaActive ? 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white shadow-lg' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                            <span>Kerjasama</span>
                            <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': openDropdown === 'kerjasama' }" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </button>
                        <div x-show="openDropdown === 'kerjasama'"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 translate-y-1"
                             class="absolute mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 z-20 py-1" style="display: none;">
                            
                            <a href="/kerjasama-siaran" class="flex items-center gap-3 px-4 py-2 text-sm transition-colors duration-200 {{ request()->is('kerjasama-siaran*') ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 1a3 3 0 0 0-3 3v8a3 3 0 0 0 6 0V4a3 3 0 0 0-3-3z"></path><path d="M19 10v2a7 7 0 0 1-14 0v-2"></path><line x1="12" y1="19" x2="12" y2="23"></line><line x1="8" y1="23" x2="16" y2="23"></line>
                                </svg>
                                <span>Siaran</span>
                            </a>
                            <a href="/kerjasama-non-siaran" class="flex items-center gap-3 px-4 py-2 text-sm transition-colors duration-200 {{ request()->is('kerjasama-non-siaran*') ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                                </svg>
                                <span>Non-Siaran</span>
                            </a>
                        </div>
                    </div>

                    <a href="/posts" class="group flex items-center gap-2 rounded-lg px-4 py-3 text-base font-medium transition-all duration-200 {{ request()->is('posts*') ? 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white shadow-lg' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline>
                        </svg>
                        <span>Postingan</span>
                    </a>
                    
                    {{-- Dropdown Tentang --}}
                    @php $isTentangActive = request()->is('sejarah*', 'visi-misi*', 'prestasi*', 'tugas-fungsi*', 'unit-kerja*', 'himne-tvri*'); @endphp
                    <div class="relative" @mouseenter="openMenu('tentang')" @mouseleave="closeMenu()">
                        <button 
                            @click="openDropdown = openDropdown === 'tentang' ? null : 'tentang'" 
                            class="group flex items-center gap-2 rounded-lg px-4 py-3 text-base font-medium transition-all duration-200 {{ $isTentangActive ? 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white shadow-lg' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line>
                            </svg>
                            <span>Tentang</span>
                            <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': openDropdown === 'tentang' }" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </button>
                        
                        <div x-show="openDropdown === 'tentang'"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-95"
                            class="absolute left-0 mt-2 w-56 origin-top-left rounded-lg bg-white dark:bg-gray-800 shadow-lg ring-1 ring-black ring-opacity-5 z-50 py-1"
                            style="display: none;">
                            
                            <a href="/sejarah" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium transition-colors duration-200 {{ request()->is('sejarah*') ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                                </svg>
                                <span>Sejarah</span>
                            </a>
                            <a href="/visi-misi" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium transition-colors duration-200 {{ request()->is('visi-misi*') ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>
                                </svg>
                                <span>Visi dan Misi</span>
                            </a>
                            <a href="/tugas-fungsi" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium transition-colors duration-200 {{ request()->is('tugas-fungsi*') ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                                </svg>
                                <span>Tugas dan Fungsi</span>
                            </a>
                            <a href="/unit-kerja" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium transition-colors duration-200 {{ request()->is('unit-kerja*') ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect>
                                </svg>
                                <span>Unit Kerja</span>
                            </a>
                            <a href="/prestasi" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium transition-colors duration-200 {{ request()->is('prestasi*') ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="8" r="7"></circle><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline>
                                </svg>
                                <span>Prestasi</span>
                            </a>
                            <a href="/himne-tvri" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium transition-colors duration-200 {{ request()->is('himne-tvri*') ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M9 18V5l12-2v13"></path><circle cx="6" cy="18" r="3"></circle><circle cx="18" cy="16" r="3"></circle>
                                </svg>
                                <span>Himne TVRI</span>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Theme Toggle untuk Desktop --}}
                <div class="ml-2 border-l border-gray-200 dark:border-gray-700 pl-2">
                    <x-theme-toggle />
                </div>
            </div>

            {{-- Bagian Kanan: Menu Mobile & Theme Toggle --}}
            <div class="flex items-center xl:hidden">
                {{-- Theme Toggle untuk Mobile --}}
                <x-theme-toggle />

                {{-- Tombol Menu Hamburger --}}
                <div class="flex-shrink-0 ml-2">
                    <button @click="isMobileMenuOpen = !isMobileMenuOpen" 
                            type="button" 
                            class="w-12 h-12 flex items-center justify-center rounded-lg p-3 
                                text-gray-700 dark:text-gray-200 
                                bg-gray-200 dark:bg-gray-800 
                                hover:bg-gray-300 dark:hover:bg-gray-700 
                                border border-gray-300 dark:border-gray-600 shadow-lg 
                                transition-colors duration-300 ease-in-out focus:outline-none">
                        
                        <span class="sr-only">Toggle menu</span>
                        
                        {{-- Icon Menu (Hamburger) --}}
                        <svg class="h-6 w-6" :class="{ 'hidden': isMobileMenuOpen, 'block': !isMobileMenuOpen }" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line>
                        </svg>
                        
                        {{-- Icon Close (X) --}}
                        <svg class="h-6 w-6" :class="{ 'block': isMobileMenuOpen, 'hidden': !isMobileMenuOpen }" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                </div>
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
         {{-- 🔴 PERUBAHAN PENTING: Mengganti 'lg:hidden' menjadi 'xl:hidden' --}}
         class="xl:hidden border-t border-gray-200 dark:border-gray-700/50 bg-white/75 dark:bg-gray-800/55 backdrop-blur-lg"
         style="display: none;">
        <div class="px-4 pt-4 pb-3">
            <div class="flex flex-col space-y-2">
                {{-- Nav Links Mobile --}}
                <a href="/" class="flex items-center gap-3 rounded-lg px-4 py-3 text-base font-medium transition-all duration-200 {{ request()->is('/') ? 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                    </svg>
                    <span>Home</span>
                </a>

                {{-- Dropdown Publikasi Mobile --}}
                @php $isPublikasiMobileActive = request()->is('penyiaran*', 'pola-acara*', 'jadwal-acara*'); @endphp
                <div>
                    <button @click="openDropdown = openDropdown === 'publikasi-mobile' ? null : 'publikasi-mobile'" 
                            class="w-full flex items-center justify-between rounded-lg px-4 py-3 text-base font-medium transition-all duration-200 {{ $isPublikasiMobileActive ? 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
                        <span class="flex items-center gap-3">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polygon points="23 7 16 12 23 17 23 7"></polygon>
                                <rect x="1" y="5" width="15" height="14" rx="2" ry="2"></rect>
                            </svg>
                            <span>Publikasi</span>
                        </span>
                        <svg class="w-5 h-5 transform transition-transform duration-200" :class="{'rotate-180': openDropdown === 'publikasi-mobile'}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </button>
                    <div x-show="openDropdown === 'publikasi-mobile'" x-collapse class="pl-8 pt-2 space-y-2">
                        <a href="/penyiaran" class="flex items-center gap-3 rounded-lg px-4 py-2 text-sm font-medium transition-colors duration-200 {{ request()->is('penyiaran*') ? 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 11a9 9 0 0 1 9 9"></path><path d="M4 4a16 16 0 0 1 16 16"></path><circle cx="5" cy="19" r="1"></circle>
                            </svg>
                            <span>Penyiaran</span>
                        </a>
                        <a href="/pola-acara" class="flex items-center gap-3 rounded-lg px-4 py-2 text-sm font-medium transition-colors duration-200 {{ request()->is('pola-acara*') ? 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                            <span>Pola Acara</span>
                        </a>
                        <a href="/jadwal-acara" class="flex items-center gap-3 rounded-lg px-4 py-2 text-sm font-medium transition-colors duration-200 {{ request()->is('jadwal-acara*') ? 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                            <span>Jadwal Acara</span>
                        </a>
                    </div>
                </div>

                {{-- Dropdown Layanan Mobile --}}
                @php $isLayananMobileActive = request()->is('ppid*', 'info-rb*', 'info-magang*', 'info-kunjungan*'); @endphp
                <div>
                    <button @click="openDropdown = openDropdown === 'layanan-mobile' ? null : 'layanan-mobile'" 
                            class="w-full flex items-center justify-between rounded-lg px-4 py-3 text-base font-medium transition-all duration-200 {{ $isLayananMobileActive ? 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
                        <span class="flex items-center gap-3">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                            </svg>
                            <span>Layanan</span>
                        </span>
                        <svg class="w-5 h-5 transform transition-transform duration-200" :class="{'rotate-180': openDropdown === 'layanan-mobile'}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </button>
                    <div x-show="openDropdown === 'layanan-mobile'" x-collapse class="pl-8 pt-2 space-y-2">
                        <a href="/ppid" class="flex items-center gap-3 rounded-lg px-4 py-2 text-sm font-medium transition-colors duration-200 {{ request()->is('ppid*') ? 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 1a3 3 0 0 0-3 3v8a3 3 0 0 0 6 0V4a3 3 0 0 0-3-3z"></path><path d="M19 10v2a7 7 0 0 1-14 0v-2"></path><line x1="12" y1="19" x2="12" y2="23"></line><line x1="8" y1="23" x2="16" y2="23"></line>
                            </svg>
                            <span>PPID</span>
                        </a>
                        <a href="/info-rb" class="flex items-center gap-3 rounded-lg px-4 py-2 text-sm font-medium transition-colors duration-200 {{ request()->is('info-rb*') ? 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                            </svg>
                            <span>Informasi RB</span>
                        </a>
                        <a href="/info-magang" class="flex items-center gap-3 rounded-lg px-4 py-2 text-sm font-medium transition-colors duration-200 {{ request()->is('info-magang*') ? 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                            </svg>
                            <span>Info Magang / PKL</span>
                        </a>
                        <a href="/info-kunjungan" class="flex items-center gap-3 rounded-lg px-4 py-2 text-sm font-medium transition-colors duration-200 {{ request()->is('info-kunjungan*') ? 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle>
                            </svg>
                            <span>Info Kunjungan</span>
                        </a>
                    </div>
                </div>

                {{-- Dropdown Kerjasama Mobile --}}
                @php $isKerjasamaMobileActive = request()->is('kerjasama-siaran*', 'kerjasama-non-siaran*'); @endphp
                <div>
                    <button 
                        @click="openDropdown = openDropdown === 'kerjasama-mobile' ? null : 'kerjasama-mobile'" 
                        class="w-full flex items-center justify-between rounded-lg px-4 py-3 text-base font-medium transition-all duration-200 {{ $isKerjasamaMobileActive ? 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
                        <span class="flex items-center gap-3">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                            <span>Kerjasama</span>
                        </span>
                        <svg class="w-5 h-5 transform transition-transform duration-200" :class="{'rotate-180': openDropdown === 'kerjasama-mobile'}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </button>
                    <div x-show="openDropdown === 'kerjasama-mobile'" x-collapse class="pl-8 pt-2 space-y-2">
                        <a href="/kerjasama-siaran" class="flex items-center gap-3 rounded-lg px-4 py-2 text-sm font-medium transition-colors duration-200 {{ request()->is('kerjasama-siaran*') ? 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 1a3 3 0 0 0-3 3v8a3 3 0 0 0 6 0V4a3 3 0 0 0-3-3z"></path><path d="M19 10v2a7 7 0 0 1-14 0v-2"></path><line x1="12" y1="19" x2="12" y2="23"></line><line x1="8" y1="23" x2="16" y2="23"></line>
                            </svg>
                            <span>Siaran</span>
                        </a>
                        <a href="/kerjasama-non-siaran" class="flex items-center gap-3 rounded-lg px-4 py-2 text-sm font-medium transition-colors duration-200 {{ request()->is('kerjasama-non-siaran*') ? 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                            </svg>
                            <span>Non-Siaran</span>
                        </a>
                    </div>
                </div>

                <a href="/posts" class="flex items-center gap-3 rounded-lg px-4 py-3 text-base font-medium transition-all duration-200 {{ request()->is('posts*') ? 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline>
                    </svg>
                    <span>Postingan</span>
                </a>

                {{-- Dropdown Tentang Mobile --}}
                @php $isTentangMobileActive = request()->is('sejarah*', 'visi-misi*', 'prestasi*', 'tugas-fungsi*', 'unit-kerja*', 'himne-tvri*'); @endphp
                <div>
                    <button @click="openDropdown = openDropdown === 'tentang-mobile' ? null : 'tentang-mobile'" 
                            class="w-full flex items-center justify-between rounded-lg px-4 py-3 text-base font-medium transition-all duration-200 {{ $isTentangMobileActive ? 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
                        <span class="flex items-center gap-3">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line>
                            </svg>
                            <span>Tentang</span>
                        </span>
                        <svg class="w-5 h-5 transform transition-transform duration-200" :class="{'rotate-180': openDropdown === 'tentang-mobile'}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </button>
                    <div x-show="openDropdown === 'tentang-mobile'" x-collapse class="pl-8 pt-2 space-y-2">
                        <a href="/sejarah" class="flex items-center gap-3 rounded-lg px-4 py-2 text-sm font-medium transition-colors duration-200 {{ request()->is('sejarah*') ? 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                            </svg>
                            <span>Sejarah</span>
                        </a>
                        <a href="/visi-misi" class="flex items-center gap-3 rounded-lg px-4 py-2 text-sm font-medium transition-colors duration-200 {{ request()->is('visi-misi*') ? 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>
                            </svg>
                            <span>Visi dan Misi</span>
                        </a>
                        <a href="/tugas-fungsi" class="flex items-center gap-3 rounded-lg px-4 py-2 text-sm font-medium transition-colors duration-200 {{ request()->is('tugas-fungsi*') ? 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                            </svg>
                            <span>Tugas dan Fungsi</span>
                        </a>
                        <a href="/unit-kerja" class="flex items-center gap-3 rounded-lg px-4 py-2 text-sm font-medium transition-colors duration-200 {{ request()->is('unit-kerja*') ? 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect>
                            </svg>
                            <span>Unit Kerja</span>
                        </a>
                        <a href="/prestasi" class="flex items-center gap-3 rounded-lg px-4 py-2 text-sm font-medium transition-colors duration-200 {{ request()->is('prestasi*') ? 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="8" r="7"></circle><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline>
                            </svg>
                            <span>Prestasi</span>
                        </a>
                        <a href="/himne-tvri" class="flex items-center gap-3 rounded-lg px-4 py-2 text-sm font-medium transition-colors duration-200 {{ request()->is('himne-tvri*') ? 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 18V5l12-2v13"></path><circle cx="6" cy="18" r="3"></circle><circle cx="18" cy="16" r="3"></circle>
                            </svg>
                            <span>Himne TVRI</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>