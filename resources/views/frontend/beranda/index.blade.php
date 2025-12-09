<x-layout>
    <x-slot:title>{{ $title ?? 'Beranda' }}</x-slot:title>

    {{-- ========================================== --}}
    {{-- 1. HERO CAROUSEL (BANNER UTAMA)            --}}
    {{-- ========================================== --}}
    {{-- Cek apakah variabel ada dan tidak kosong --}}
    @if(isset($heroSlides) && count($heroSlides) > 0)
        <div class="py-2 px-4 sm:px-6 lg:px-8">
            <div class="mx-auto">
                <x-hero-carousel :slides="$heroSlides" />
            </div>
        </div>
    @endif

    {{-- ========================================== --}}
    {{-- 2. PROGRAM ACARA (SLIDER)                  --}}
    {{-- ========================================== --}}
    @if(isset($featuredBroadcasts) && $featuredBroadcasts->isNotEmpty())
    <section class="py-8 bg-white dark:bg-gray-900 border-b border-gray-100 dark:border-gray-800">
        <div class="mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-end justify-between mb-8">
                <div>
                    <span class="text-blue-600 dark:text-blue-400 font-bold tracking-wider uppercase text-sm">Hiburan & Edukasi</span>
                    <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900 dark:text-white mt-1">Program Unggulan</h2>
                </div>
                <a href="{{ route('broadcasts.index') }}" class="group flex items-center text-sm font-semibold text-blue-600 hover:text-blue-700 dark:text-blue-400 transition-colors">
                    Lihat Semua
                    <svg class="w-4 h-4 ml-1 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                </a>
            </div>

            {{-- Slider Container --}}
            <div class="relative group">
                <div class="flex overflow-x-auto gap-6 pb-8 snap-x snap-mandatory scrollbar-hide -mx-4 px-4 sm:mx-0 sm:px-0">
                    @foreach($featuredBroadcasts as $program)
                        <a href="{{ route('broadcasts.show', $program->slug) }}" class="snap-center shrink-0 w-[200px] sm:w-[240px] flex-none relative overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-2 group/card ring-1 ring-gray-200 dark:ring-gray-700 rounded-lg">
                            {{-- Poster --}}
                            <div class="aspect-[3/4] bg-gray-200 dark:bg-gray-800 relative overflow-hidden">
                                @if($program->poster)
                                    <img src="{{ Storage::url($program->poster) }}" alt="{{ $program->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover/card:scale-110" loading="lazy">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                        <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-transparent to-transparent opacity-60 group-hover/card:opacity-90 transition-opacity"></div>
                                <div class="absolute top-3 left-3">
                                    <span class="px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide text-white bg-blue-600/90 backdrop-blur-sm rounded-md shadow-sm">
                                        {{ $program->broadcastCategory->name ?? 'Program' }}
                                    </span>
                                </div>
                            </div>
                            {{-- Content --}}
                            <div class="absolute bottom-0 left-0 right-0 p-4 text-white transform translate-y-2 group-hover/card:translate-y-0 transition-transform">
                                <h3 class="font-bold text-lg leading-tight mb-1 line-clamp-2">{{ $program->title }}</h3>
                                <p class="text-xs text-gray-300 line-clamp-1 opacity-0 group-hover/card:opacity-100 transition-opacity">Klik untuk detail</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- ========================================== --}}
    {{-- 3. JADWAL ACARA (TIMELINE VIEW)            --}}
    {{-- ========================================== --}}
    <section class="py-12">
        <div class="mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-8 lg:gap-12">
                
                {{-- Kolom Kiri: Judul & Live Streaming CTA --}}
                <div class="lg:w-1/3">
                    <span class="text-blue-600 dark:text-blue-400 font-bold tracking-wider uppercase text-xs md:text-sm mb-2 block">Jadwal Acara</span>
                    <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900 dark:text-white mb-4">Jangan Lewatkan<br>Acara Favoritmu</h2>
                    <p class="text-gray-600 dark:text-gray-300 mb-6 leading-relaxed text-sm md:text-base">
                        Simak jadwal acara TVRI D.I. Yogyakarta hari ini, <strong>{{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}</strong>.
                    </p>

                    <div class="p-6 bg-gradient-to-br from-blue-700 to-indigo-800 rounded-2xl text-white shadow-lg relative overflow-hidden group">
                        {{-- Decorative Blob --}}
                        <div class="absolute -right-6 -top-6 w-32 h-32 bg-white/10 rounded-full blur-2xl group-hover:bg-white/20 transition-all duration-500"></div>
                        
                        <div class="relative z-10">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="relative flex h-2.5 w-2.5">
                                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                  <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-red-500"></span>
                                </span>
                                <span class="text-xs font-bold tracking-wider uppercase text-red-100">Live Streaming</span>
                            </div>
                            <h3 class="text-lg md:text-xl font-bold mb-4 leading-tight">Nonton TVRI Jogja Sekarang</h3>
                            <a href="{{ route('streaming') }}" class="inline-flex w-full justify-center items-center gap-2 px-4 py-3 bg-white text-blue-800 font-bold rounded-xl hover:bg-blue-50 transition-colors shadow-sm text-sm">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" /><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                Tonton Streaming
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Kanan: List Jadwal --}}
                <div class="lg:w-2/3">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden flex flex-col h-full">
                        <div class="px-5 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center bg-gray-50/50 dark:bg-gray-700/30">
                            <h3 class="font-bold text-gray-900 dark:text-white text-sm md:text-base">Rundown Hari Ini</h3>
                            <a href="{{ route('publikasi.jadwal') }}" class="text-xs font-bold text-blue-600 hover:text-blue-700 dark:text-blue-400">Lihat Semua Hari &rarr;</a>
                        </div>
                        
                        <div class="divide-y divide-gray-100 dark:divide-gray-700 overflow-y-auto scrollbar-thin scrollbar-thumb-gray-200 dark:scrollbar-thumb-gray-600" style="max-height: 400px;">
                            @if(isset($todaySchedules) && $todaySchedules->isNotEmpty())
                                @foreach($todaySchedules as $schedule)
                                    @php
                                        // 1. Setup Waktu & Variabel
                                        $currentTime = \Carbon\Carbon::now();
                                        $startTime = \Carbon\Carbon::parse($schedule->start_time);
                                        
                                        // 2. Cek Logika Status (Current, Past, Future)
                                        // Pastikan variabel $currentProgram ada sebelum mengakses propertinya
                                        $isCurrent = isset($currentProgram) && $currentProgram && $currentProgram->id === $schedule->id;
                                        
                                        // Sudah lewat jika waktu mulai < sekarang DAN bukan yang sedang tayang
                                        $isPast = $startTime->lessThan($currentTime) && !$isCurrent;

                                        // 3. Tentukan Kelas CSS Berdasarkan Status
                                        if ($isCurrent) {
                                            // Highlight & Sticky untuk acara saat ini
                                            $rowClass = 'bg-blue-50 dark:bg-blue-900/20 sticky top-0 z-10 border-l-4 border-blue-600 shadow-sm';
                                            $timeClass = 'text-blue-700 dark:text-blue-400 font-bold text-base';
                                            $titleClass = 'text-blue-900 dark:text-white';
                                            $dotClass = 'bg-blue-600 ring-4 ring-blue-100 dark:ring-blue-900 animate-pulse';
                                        } elseif ($isPast) {
                                            // Redupkan (Dimmed) untuk acara yang sudah lewat
                                            $rowClass = 'opacity-60 grayscale-[0.5] hover:opacity-100 transition-opacity bg-gray-50/50 dark:bg-gray-800/50';
                                            $timeClass = 'text-gray-400 line-through decoration-gray-400 text-xs';
                                            $titleClass = 'text-gray-600 dark:text-gray-400';
                                            $dotClass = 'bg-gray-300 dark:bg-gray-600';
                                        } else {
                                            // Normal untuk acara akan datang
                                            $rowClass = 'hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors';
                                            $timeClass = 'text-gray-900 dark:text-white font-medium text-sm';
                                            $titleClass = 'text-gray-900 dark:text-white';
                                            $dotClass = 'bg-white border-2 border-gray-300 dark:border-gray-500';
                                        }
                                    @endphp

                                    <div class="p-4 flex items-center gap-4 {{ $rowClass }}">
                                        {{-- Jam Tayang --}}
                                        <div class="w-16 text-right flex-shrink-0">
                                            <span class="block {{ $timeClass }}">{{ $startTime->format('H:i') }}</span>
                                            @if($isPast)
                                                <span class="text-[10px] text-gray-400 block">Selesai</span>
                                            @endif
                                        </div>
                                        
                                        {{-- Garis / Dot --}}
                                        <div class="relative flex flex-col items-center justify-center">
                                            <div class="w-3 h-3 rounded-full {{ $dotClass }}"></div>
                                        </div>

                                        {{-- Info Program --}}
                                        <div class="flex-1 min-w-0">
                                            <h4 class="font-bold truncate {{ $titleClass }}">{{ $schedule->title }}</h4>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                                                {{ $schedule->broadcastCategory->name ?? 'Program TVRI' }}
                                            </p>
                                        </div>
                                        
                                        {{-- Indikator On Air --}}
                                        @if($isCurrent)
                                            <div class="flex-shrink-0">
                                                <span class="px-2 py-1 bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400 text-[10px] font-bold uppercase rounded-md animate-pulse whitespace-nowrap flex items-center gap-1">
                                                    <span class="w-1.5 h-1.5 bg-red-600 rounded-full"></span> ON AIR
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            @else
                                <div class="flex flex-col items-center justify-center h-48 text-center text-gray-500 dark:text-gray-400">
                                    <svg class="w-10 h-10 mb-3 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <p class="text-sm">Belum ada jadwal yang dirilis untuk hari ini.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ========================================== --}}
    {{-- 4. INFORMASI PUBLIK (GRID 4 KARTU)         --}}
    {{-- ========================================== --}}
    <section class="pt-8 bg-white dark:bg-gray-900">
        <div class="mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-10">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white">Layanan & Informasi Publik</h2>
                <p class="mt-2 text-sm md:text-base text-gray-600 dark:text-gray-400">Transparansi dan akuntabilitas untuk pelayanan yang lebih baik.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
                
                {{-- Card 1: PPID --}}
                <a href="{{ route('ppid.index') }}" class="group relative p-6 bg-gray-50 dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 hover:border-blue-200 dark:hover:border-blue-800 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                    <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" /></svg>
                    </div>
                    <h3 class="text-base font-bold text-gray-900 dark:text-white mb-2">PPID</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 line-clamp-2">Layanan permohonan informasi dan dokumentasi publik.</p>
                    <span class="text-xs font-bold text-blue-600 dark:text-blue-400 uppercase tracking-wide flex items-center gap-1">Lihat <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg></span>
                </a>

                {{-- Card 2: Reformasi Birokrasi --}}
                <a href="{{ route('info-rb.index') }}" class="group relative p-6 bg-gray-50 dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 hover:border-green-200 dark:hover:border-green-800 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                    <div class="w-10 h-10 bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 rounded-lg flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <h3 class="text-base font-bold text-gray-900 dark:text-white mb-2">Reformasi Birokrasi</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 line-clamp-2">Tata kelola pemerintahan yang bersih dan akuntabel.</p>
                    <span class="text-xs font-bold text-green-600 dark:text-green-400 uppercase tracking-wide flex items-center gap-1">Cek <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg></span>
                </a>

                {{-- Card 3: Magang --}}
                <a href="{{ route('info-magang.index') }}" class="group relative p-6 bg-gray-50 dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 hover:border-purple-200 dark:hover:border-purple-800 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                    <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 rounded-lg flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                    </div>
                    <h3 class="text-base font-bold text-gray-900 dark:text-white mb-2">Magang / PKL</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 line-clamp-2">Peluang pengembangan karir bagi pelajar dan mahasiswa.</p>
                    <span class="text-xs font-bold text-purple-600 dark:text-purple-400 uppercase tracking-wide flex items-center gap-1">Info <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg></span>
                </a>

                {{-- Card 4: Kunjungan --}}
                <a href="{{ route('info-kunjungan.index') }}" class="group relative p-6 bg-gray-50 dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 hover:border-orange-200 dark:hover:border-orange-800 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                    <div class="w-10 h-10 bg-orange-100 dark:bg-orange-900/30 text-orange-600 dark:text-orange-400 rounded-lg flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                    </div>
                    <h3 class="text-base font-bold text-gray-900 dark:text-white mb-2">Kunjungan Industri</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 line-clamp-2">Prosedur kunjungan studi banding dan tamu dinas.</p>
                    <span class="text-xs font-bold text-orange-600 dark:text-orange-400 uppercase tracking-wide flex items-center gap-1">Tata Cara <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg></span>
                </a>

            </div>
        </div>
    </section>

    {{-- ========================================== --}}
    {{-- 5. POSTINGAN TERBARU (GRID)                --}}
    {{-- ========================================== --}}
    @if(isset($latestPosts) && $latestPosts->isNotEmpty())
    <section class="py-12">
        <div class="mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white">Postingan Terbaru</h2>
                <a href="{{ route('posts.index') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-700 dark:text-blue-400 transition-colors">Semua Postingan &rarr;</a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                @foreach($latestPosts as $post)
                <article class="flex flex-col h-full group bg-white dark:bg-gray-800 rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100 dark:border-gray-700 hover:-translate-y-1">
                    <a href="{{ route('posts.show', $post->slug) }}" class="block overflow-hidden relative aspect-video">
                        @if($post->featured_image)
                            <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                        @else
                            <div class="w-full h-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                <svg class="w-10 h-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" /></svg>
                            </div>
                        @endif
                        
                        @if($post->category)
                            <span class="absolute top-3 left-3 px-2.5 py-1 text-xs font-bold bg-white/95 dark:bg-black/80 backdrop-blur-sm text-gray-900 dark:text-white rounded-md shadow-sm">
                                {{ $post->category->name }}
                            </span>
                        @endif
                    </a>
                    
                    <div class="flex-1 p-5 flex flex-col">
                        <div class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400 mb-2">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            <time>{{ $post->created_at->format('d M Y') }}</time>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2 leading-snug group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                            <a href="{{ route('posts.show', $post->slug) }}">{{ Str::limit($post->title, 60) }}</a>
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-300 line-clamp-2 mb-4 flex-grow">
                            {{ Str::limit(strip_tags($post->body), 90) }}
                        </p>
                        <a href="{{ route('posts.show', $post->slug) }}" class="text-sm font-semibold text-blue-600 dark:text-blue-400 hover:underline">Baca Selengkapnya</a>
                    </div>
                </article>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ========================================== --}}
    {{-- 6. VISI & MISI (COMPACT FEATURE SECTION)   --}}
    {{-- ========================================== --}}
    <section class="py-8 bg-white dark:bg-gray-900">
        <div class="mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Container Berwarna (Boxed Layout) --}}
            <div class="relative rounded-3xl overflow-hidden bg-blue-900 shadow-2xl">
                
                {{-- Background Image & Overlay --}}
                <div class="absolute inset-0">
                    <img src="https://images.unsplash.com/photo-1518552686702-8610fe628859?q=80&w=2070&auto=format&fit=crop" 
                         alt="Background TVRI" 
                         class="w-full h-full object-cover opacity-20 mix-blend-overlay">
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-950 via-blue-900/90 to-blue-800/80"></div>
                </div>

                {{-- Content --}}
                <div class="relative z-10 p-8 md:p-12 lg:p-16">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
                        
                        {{-- Kolom Kiri: Teks Visi --}}
                        <div class="text-center lg:text-left">
                            <h2 class="text-2xl md:text-4xl font-extrabold text-white mb-6 leading-tight">
                                Menjadi Lembaga Penyiaran Publik Kelas Dunia
                            </h2>
                            <p class="text-base md:text-lg text-blue-100 leading-relaxed mb-8 opacity-90">
                                "Memotivasi dan memberdayakan masyarakat melalui program informasi, pendidikan, dan hiburan yang sehat serta perekat sosial."
                            </p>
                            
                            <div class="flex flex-wrap justify-center lg:justify-start gap-4">
                                <a href="{{ route('visi-misi') }}" class="inline-flex items-center justify-center px-6 py-3 text-sm font-bold text-blue-900 bg-white rounded-xl hover:bg-blue-50 transition-colors shadow-lg group">
                                    Lihat Misi Kami
                                    <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                                </a>
                                <a href="{{ route('sejarah') }}" class="inline-flex items-center justify-center px-6 py-3 text-sm font-bold text-white bg-transparent border border-blue-400/50 rounded-xl hover:bg-blue-800/50 transition-colors">
                                    Sejarah TVRI Jogja
                                    <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                                </a>
                            </div>
                        </div>

                        {{-- Kolom Kanan: Visual / Highlights --}}
                        <div class="hidden lg:block relative">
                            {{-- Decorative Background Blob --}}
                            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-blue-500 rounded-full blur-3xl opacity-20 animate-pulse"></div>

                            <div class="grid grid-cols-2 gap-4">
                                {{-- Card 1 --}}
                                <div class="bg-white/10 backdrop-blur-md border border-white/10 p-5 rounded-2xl transform translate-y-4">
                                    <div class="w-10 h-10 bg-blue-500/20 rounded-lg flex items-center justify-center mb-3 text-blue-200">
                                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                                    </div>
                                    <h4 class="text-white font-bold mb-1">Informatif</h4>
                                    <p class="text-xs text-blue-200">Menyajikan berita aktual dan terpercaya.</p>
                                </div>

                                {{-- Card 2 --}}
                                <div class="bg-white/10 backdrop-blur-md border border-white/10 p-5 rounded-2xl">
                                    <div class="w-10 h-10 bg-green-500/20 rounded-lg flex items-center justify-center mb-3 text-green-200">
                                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                                    </div>
                                    <h4 class="text-white font-bold mb-1">Edukatif</h4>
                                    <p class="text-xs text-blue-200">Konten pendidikan yang mencerdaskan.</p>
                                </div>

                                {{-- Card 3 --}}
                                <div class="bg-white/10 backdrop-blur-md border border-white/10 p-5 rounded-2xl transform translate-y-4">
                                    <div class="w-10 h-10 bg-purple-500/20 rounded-lg flex items-center justify-center mb-3 text-purple-200">
                                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    </div>
                                    <h4 class="text-white font-bold mb-1">Menghibur</h4>
                                    <p class="text-xs text-blue-200">Hiburan sehat untuk seluruh keluarga.</p>
                                </div>

                                {{-- Card 4 --}}
                                <div class="bg-white/10 backdrop-blur-md border border-white/10 p-5 rounded-2xl">
                                    <div class="w-10 h-10 bg-orange-500/20 rounded-lg flex items-center justify-center mb-3 text-orange-200">
                                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                    </div>
                                    <h4 class="text-white font-bold mb-1">Perekat Sosial</h4>
                                    <p class="text-xs text-blue-200">Menjaga persatuan dan budaya bangsa.</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</x-layout>