{{-- fileName: navbar.blade.php --}}
{{-- ✅ MODIFIKASI: Double navbar dengan efek scroll --}}

<header 
    x-data="{ 
        scrolled: false,
        init() {
            window.addEventListener('scroll', () => {
                this.scrolled = window.scrollY > 20;
            });
        }
    }"
    :class="{ '-translate-y-10': scrolled, 'translate-y-0': !scrolled }"
    class="fixed top-0 w-full z-50 transition-transform duration-300 ease-in-out"
>

    {{-- ====================================================================== --}}
    {{-- BAGIAN 1: TOP BAR (Warna Biru Gelap - Hilang saat scroll)              --}}
    {{-- ====================================================================== --}}
    <div class="h-10 bg-blue-900 text-white text-xs font-medium relative z-50 border-b border-blue-800">
        <div class="container mx-auto px-4 sm:px-6 xl:px-8 h-full flex justify-between items-center">
            
            {{-- Kiri: Tanggal / Info --}}
            <div class="hidden sm:flex items-center gap-4">
                <span class="flex items-center gap-2">
                    <i data-feather="calendar" class="w-3 h-3"></i>
                    {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
                </span>
                <span>|</span>
                <a href="/penyiaran" class="flex items-center gap-2 hover:text-blue-200 transition">
                    <i data-feather="tv" class="w-3 h-3"></i>
                    <span>Live Streaming TVRI</span>
                </a>
            </div>

            {{-- Kanan: Kontak & Sosial Media Dinamis --}}
            <div class="flex items-center gap-3 ml-auto">
                <span class="hidden sm:inline text-white">Kontak Kami:</span>
                <div class="flex gap-3 items-center">
                    <span class="hidden sm:inline text-white-100">(0274) 514402</span>
                    <span class="hidden sm:inline"> | </span>
                    <span class="hidden sm:inline text-white">Ikuti Kami:</span>
                    
                    {{-- ✅ IKON SOSIAL MEDIA DINAMIS --}}
                    <div class="flex gap-3">
                        
                        {{-- Facebook --}}
                        @if($socialMedia->facebook)
                            <a href="{{ $socialMedia->facebook }}" target="_blank" class="hover:text-blue-300 transition" title="Facebook">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" /></svg>
                            </a>
                        @endif

                        {{-- X (Twitter) --}}
                        @if($socialMedia->twitter)
                            <a href="{{ $socialMedia->twitter }}" target="_blank" class="hover:text-blue-300 transition" title="X (Twitter)">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M13.6823 10.6218L20.2391 3H18.6854L12.9921 9.61788L8.44486 3H3.2002L10.0765 13.0074L3.2002 21H4.75404L10.7663 14.0113L15.5685 21H20.8131L13.6819 10.6218H13.6823ZM11.5541 13.0956L10.8574 12.0991L5.31391 4.16971H7.70053L12.1742 10.5689L12.8709 11.5655L18.6861 19.8835H16.2995L11.5541 13.096V13.0956Z" /></svg>
                            </a>
                        @endif

                        {{-- Instagram --}}
                        @if($socialMedia->instagram)
                            <a href="{{ $socialMedia->instagram }}" target="_blank" class="hover:text-blue-300 transition" title="Instagram">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.468.99c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" /></svg>
                            </a>
                        @endif

                        {{-- YouTube --}}
                        @if($socialMedia->youtube)
                            <a href="{{ $socialMedia->youtube }}" target="_blank" class="hover:text-blue-300 transition" title="YouTube">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M19.812 5.418c.861.23 1.538.907 1.768 1.768C21.998 8.746 22 12 22 12s0 3.255-.418 4.814a2.504 2.504 0 0 1-1.768 1.768c-1.56.419-7.814.419-7.814.419s-6.255 0-7.814-.419a2.505 2.505 0 0 1-1.768-1.768C2 15.255 2 12 2 12s0-3.255.417-4.814a2.507 2.507 0 0 1 1.768-1.768C5.744 5 11.998 5 11.998 5s6.255 0 7.814.418ZM15.194 12 10 15V9l5.194 3Z" clip-rule="evenodd" /></svg>
                            </a>
                        @endif

                        {{-- TikTok --}}
                        @if($socialMedia->tiktok)
                            <a href="{{ $socialMedia->tiktok }}" target="_blank" class="hover:text-blue-300 transition" title="TikTok">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.35-1.17.82-1.5 1.47-.27.53-.39 1.15-.33 1.75.26 1.9 2.07 3.32 4 3.07 1.86-.24 3.27-1.85 3.27-3.74.02-4.27.01-8.54.01-12.81 1.36 1.09 1.61 2.8 1.73 4.45h4.09c-.06-1.86-.79-3.64-2.07-5.02-1.32-1.45-3.21-2.22-5.11-2.43V.02z" clip-rule="evenodd" /></svg>
                            </a>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ====================================================================== --}}
    {{-- BAGIAN 2: MAIN NAVBAR (Menu Utama - Tetap terlihat saat scroll)        --}}
    {{-- ====================================================================== --}}
    <nav class="bg-white/75 dark:bg-gray-800/55 backdrop-blur-lg fixed w-full z-50 border-b border-gray-200 dark:border-gray-700 transition-colors duration-300 shadow-lg"
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
                    <a href="/" class="flex items-center gap-2">
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
                        @php $isPublikasiActive = request()->is('penyiaran*', 'jadwal-acara*'); @endphp
                        <div class="relative" @mouseenter="openMenu('publikasi')" @mouseleave="closeMenu()">
                            <button 
                                @click="openDropdown = openDropdown === 'publikasi' ? null : 'publikasi'" 
                                class="group flex items-center gap-2 rounded-lg px-4 py-3 text-base font-medium transition-all duration-200 {{ $isPublikasiActive ? 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white shadow-lg' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
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
                                        <path d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    <span>Penyiaran</span>
                                </a>
                                <a href="/jadwal-acara" class="flex items-center gap-3 px-4 py-2 text-sm transition-colors duration-200 {{ request()->is('jadwal-acara*') ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
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
                                    <path d="M7 11.5V14m0-2.5v-6a1.5 1.5 0 113 0m-3 6a1.5 1.5 0 00-3 0v2a7.5 7.5 0 0015 0v-5a1.5 1.5 0 00-3 0m-6-3V11m0-5.5v-1a1.5 1.5 0 013 0v1m0 0V11m0-5.5a1.5 1.5 0 013 0v3m0 0V11" />
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
                                        <path d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                                    </svg>
                                    <span>Informasi PPID</span>
                                </a>
                                <a href="/info-rb" class="flex items-center gap-3 px-4 py-2 text-sm transition-colors duration-200 {{ request()->is('info-rb*') ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                    <span>Informasi RB</span>
                                </a>
                                <a href="/info-magang" class="flex items-center gap-3 px-4 py-2 text-sm transition-colors duration-200 {{ request()->is('info-magang*') ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    <span>Informasi Magang / PKL</span>
                                </a>
                                <a href="/info-kunjungan" class="flex items-center gap-3 px-4 py-2 text-sm transition-colors duration-200 {{ request()->is('info-kunjungan*') ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span>Informasi Kunjungan</span>
                                </a>
                            </div>
                        </div>

                        <a href="/posts" class="group flex items-center gap-2 rounded-lg px-4 py-3 text-base font-medium transition-all duration-200 {{ request()->is('posts*') ? 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white shadow-lg' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                            </svg>
                            <span>Postingan</span>
                        </a>
                        
                        {{-- Dropdown Tentang --}}
                        @php $isTentangActive = request()->is('sejarah*', 'visi-misi*', 'prestasi*', 'tugas-fungsi*', 'himne-tvri*'); @endphp
                        <div class="relative" @mouseenter="openMenu('tentang')" @mouseleave="closeMenu()">
                            <button 
                                @click="openDropdown = openDropdown === 'tentang' ? null : 'tentang'" 
                                class="group flex items-center gap-2 rounded-lg px-4 py-3 text-base font-medium transition-all duration-200 {{ $isTentangActive ? 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white shadow-lg' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
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
                                        <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>Sejarah</span>
                                </a>
                                <a href="/visi-misi" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium transition-colors duration-200 {{ request()->is('visi-misi*') ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>Visi dan Misi</span>
                                </a>
                                <a href="/tugas-fungsi" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium transition-colors duration-200 {{ request()->is('tugas-fungsi*') ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    <span>Tugas dan Fungsi</span>
                                </a>
                                <a href="/prestasi" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium transition-colors duration-200 {{ request()->is('prestasi*') ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M12 8.5v7m0-7V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
                                    </svg>
                                    <span>Prestasi</span>
                                </a>
                                <a href="/himne-tvri" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium transition-colors duration-200 {{ request()->is('himne-tvri*') ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
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
                    @php $isPublikasiMobileActive = request()->is('penyiaran*', 'jadwal-acara*'); @endphp
                    <div>
                        <button @click="openDropdown = openDropdown === 'publikasi-mobile' ? null : 'publikasi-mobile'" 
                                class="w-full flex items-center justify-between rounded-lg px-4 py-3 text-base font-medium transition-all duration-200 {{ $isPublikasiMobileActive ? 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
                            <span class="flex items-center gap-3">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
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
                                    <path d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <span>Penyiaran</span>
                            </a>
                            <a href="/jadwal-acara" class="flex items-center gap-3 rounded-lg px-4 py-2 text-sm font-medium transition-colors duration-200 {{ request()->is('jadwal-acara*') ? 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
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
                                    <path d="M7 11.5V14m0-2.5v-6a1.5 1.5 0 113 0m-3 6a1.5 1.5 0 00-3 0v2a7.5 7.5 0 0015 0v-5a1.5 1.5 0 00-3 0m-6-3V11m0-5.5v-1a1.5 1.5 0 013 0v1m0 0V11m0-5.5a1.5 1.5 0 013 0v3m0 0V11" />
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
                                    <path d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                                </svg>
                                <span>Informasi PPID</span>
                            </a>
                            <a href="/info-rb" class="flex items-center gap-3 rounded-lg px-4 py-2 text-sm font-medium transition-colors duration-200 {{ request()->is('info-rb*') ? 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                                <span>Informasi RB</span>
                            </a>
                            <a href="/info-magang" class="flex items-center gap-3 rounded-lg px-4 py-2 text-sm font-medium transition-colors duration-200 {{ request()->is('info-magang*') ? 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <span>Informasi Magang / PKL</span>
                            </a>
                            <a href="/info-kunjungan" class="flex items-center gap-3 rounded-lg px-4 py-2 text-sm font-medium transition-colors duration-200 {{ request()->is('info-kunjungan*') ? 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span>Informasi Kunjungan</span>
                            </a>
                        </div>
                    </div>

                    <a href="/posts" class="flex items-center gap-3 rounded-lg px-4 py-3 text-base font-medium transition-all duration-200 {{ request()->is('posts*') ? 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                        </svg>
                        <span>Postingan</span>
                    </a>

                    {{-- Dropdown Tentang Mobile --}}
                    @php $isTentangMobileActive = request()->is('sejarah*', 'visi-misi*', 'prestasi*', 'tugas-fungsi*', 'himne-tvri*'); @endphp
                    <div>
                        <button @click="openDropdown = openDropdown === 'tentang-mobile' ? null : 'tentang-mobile'" 
                                class="w-full flex items-center justify-between rounded-lg px-4 py-3 text-base font-medium transition-all duration-200 {{ $isTentangMobileActive ? 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
                            <span class="flex items-center gap-3">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
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
                                    <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>Sejarah</span>
                            </a>
                            <a href="/visi-misi" class="flex items-center gap-3 rounded-lg px-4 py-2 text-sm font-medium transition-colors duration-200 {{ request()->is('visi-misi*') ? 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>Visi dan Misi</span>
                            </a>
                            <a href="/tugas-fungsi" class="flex items-center gap-3 rounded-lg px-4 py-2 text-sm font-medium transition-colors duration-200 {{ request()->is('tugas-fungsi*') ? 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <span>Tugas dan Fungsi</span>
                            </a>
                            <a href="/prestasi" class="flex items-center gap-3 rounded-lg px-4 py-2 text-sm font-medium transition-colors duration-200 {{ request()->is('prestasi*') ? 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 8.5v7m0-7V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
                                </svg>
                                <span>Prestasi</span>
                            </a>
                            <a href="/himne-tvri" class="flex items-center gap-3 rounded-lg px-4 py-2 text-sm font-medium transition-colors duration-200 {{ request()->is('himne-tvri*') ? 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                </svg>
                                <span>Himne TVRI</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>