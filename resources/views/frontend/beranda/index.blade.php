<x-layout>
    <x-slot:title>{{ $title ?? 'Beranda' }}</x-slot:title>

    {{-- ========================================== --}}
    {{-- 1. HERO CAROUSEL (BANNER UTAMA)            --}}
    {{-- ========================================== --}}
    <div class="px-4 sm:px-6 lg:px-8 pt-6 pb-12">
        <x-hero-carousel :slides="$heroSlides" />
    </div>

    {{-- ========================================== --}}
    {{-- 2. PROGRAM ACARA / PENYIARAN (SLIDER)      --}}
    {{-- ========================================== --}}
    @if($featuredBroadcasts->isNotEmpty())
    <section class="py-12 bg-white dark:bg-gray-900 border-b border-gray-100 dark:border-gray-800">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-end justify-between mb-8">
                <div>
                    <span class="text-blue-600 dark:text-blue-400 font-bold tracking-wider uppercase text-sm">Hiburan & Edukasi</span>
                    <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white mt-1">Program Unggulan</h2>
                </div>
                <a href="{{ route('broadcasts.index') }}" class="group flex items-center text-sm font-semibold text-blue-600 hover:text-blue-700 dark:text-blue-400 transition-colors">
                    Lihat Semua
                    <svg class="w-4 h-4 ml-1 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                </a>
            </div>

            {{-- Horizontal Scroll Container --}}
            <div class="relative group">
                <div class="flex overflow-x-auto gap-6 pb-8 snap-x snap-mandatory scrollbar-hide">
                    @foreach($featuredBroadcasts as $program)
                        <a href="{{ route('broadcasts.show', $program->slug) }}" class="snap-center shrink-0 w-[200px] sm:w-[240px] flex-none relative rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-2 group/card">
                            {{-- Poster Image --}}
                            <div class="aspect-[3/4] bg-gray-200 dark:bg-gray-800 relative overflow-hidden">
                                @if($program->poster)
                                    <img src="{{ Storage::url($program->poster) }}" alt="{{ $program->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover/card:scale-110">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                        <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    </div>
                                @endif
                                
                                {{-- Overlay Gradient --}}
                                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent opacity-60 group-hover/card:opacity-90 transition-opacity"></div>
                                
                                {{-- Kategori Badge --}}
                                <div class="absolute top-3 left-3">
                                    <span class="px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide text-white bg-blue-600/90 backdrop-blur-sm rounded-md shadow-sm">
                                        {{ $program->broadcastCategory->name ?? 'Program' }}
                                    </span>
                                </div>
                            </div>

                            {{-- Content --}}
                            <div class="absolute bottom-0 left-0 right-0 p-4 text-white transform translate-y-2 group-hover/card:translate-y-0 transition-transform">
                                <h3 class="font-bold text-lg leading-tight mb-1 line-clamp-2">{{ $program->title }}</h3>
                                <p class="text-xs text-gray-300 line-clamp-1 opacity-0 group-hover/card:opacity-100 transition-opacity delay-75">Klik untuk detail tayangan</p>
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
    <section class="py-16 bg-gray-50 dark:bg-gray-800/50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-12">
                
                {{-- Kiri: Judul & Live Streaming CTA --}}
                <div class="lg:w-1/3">
                    <span class="text-red-600 dark:text-red-400 font-bold tracking-wider uppercase text-sm mb-2 block">Jadwal Tayang</span>
                    <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-6">Jangan Lewatkan<br>Acara Favoritmu</h2>
                    <p class="text-gray-600 dark:text-gray-300 mb-8 leading-relaxed">
                        Simak jadwal acara TVRI Yogyakarta hari ini, <strong>{{ now()->translatedFormat('l, d M Y') }}</strong>. Nikmati beragam konten budaya, berita, dan hiburan.
                    </p>

                    <div class="p-6 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl text-white shadow-xl relative overflow-hidden group">
                        <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/10 rounded-full blur-3xl group-hover:bg-white/20 transition-all"></div>
                        
                        <div class="relative z-10">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="relative flex h-3 w-3">
                                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                  <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                                </span>
                                <span class="text-xs font-bold tracking-wider uppercase">Live Streaming</span>
                            </div>
                            <h3 class="text-xl font-bold mb-4">Nonton TVRI Jogja Sekarang</h3>
                            <a href="{{ route('broadcasts.index') }}" class="inline-flex w-full justify-center items-center gap-2 px-4 py-3 bg-white text-blue-700 font-bold rounded-xl hover:bg-blue-50 transition-colors">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" /><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                Streaming
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Kanan: List Jadwal --}}
                <div class="lg:w-2/3">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-700/30 flex justify-between items-center">
                            <h3 class="font-bold text-gray-900 dark:text-white">Rundown Hari Ini</h3>
                            <a href="{{ route('publikasi.jadwal') }}" class="text-xs font-medium text-blue-600 hover:text-blue-700 dark:text-blue-400">Lihat Semua Hari &rarr;</a>
                        </div>
                        
                        <div class="divide-y divide-gray-100 dark:divide-gray-700 max-h-[500px] overflow-y-auto scrollbar-thin scrollbar-thumb-gray-200 dark:scrollbar-thumb-gray-600">
                            @forelse($todaySchedules as $schedule)
                                @php
                                    // Cek apakah ini acara yang sedang tayang
                                    $isCurrent = $currentProgram && $currentProgram->id === $schedule->id;
                                    $rowClass = $isCurrent ? 'bg-blue-50/50 dark:bg-blue-900/10' : 'hover:bg-gray-50 dark:hover:bg-gray-700/50';
                                    $timeClass = $isCurrent ? 'text-blue-700 dark:text-blue-400 font-bold' : 'text-gray-500 dark:text-gray-400 font-medium';
                                @endphp
                                <div class="p-4 flex items-center gap-4 transition-colors {{ $rowClass }}">
                                    <div class="w-16 text-right flex-shrink-0">
                                        <span class="block text-sm {{ $timeClass }}">{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}</span>
                                    </div>
                                    
                                    {{-- Garis Timeline --}}
                                    <div class="relative flex flex-col items-center h-full">
                                        <div class="w-2.5 h-2.5 rounded-full {{ $isCurrent ? 'bg-blue-500 ring-4 ring-blue-100 dark:ring-blue-900' : 'bg-gray-300 dark:bg-gray-600' }}"></div>
                                    </div>

                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-sm font-bold text-gray-900 dark:text-white truncate">{{ $schedule->title }}</h4>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                                            {{ $schedule->broadcastCategory->name ?? 'Program TVRI' }}
                                        </p>
                                    </div>
                                    
                                    @if($isCurrent)
                                        <span class="px-2 py-1 bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400 text-[10px] font-bold uppercase rounded-md animate-pulse">
                                            On Air
                                        </span>
                                    @endif
                                </div>
                            @empty
                                <div class="p-8 text-center text-gray-500 dark:text-gray-400 text-sm">
                                    Belum ada jadwal yang dirilis untuk hari ini.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ========================================== --}}
    {{-- 4. INFORMASI PUBLIK (PPID & RB)            --}}
    {{-- ========================================== --}}
    <section class="py-16 bg-white dark:bg-gray-900">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-10">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Layanan Informasi Publik</h2>
                <p class="mt-2 text-gray-600 dark:text-gray-400">Transparansi dan akuntabilitas untuk pelayanan yang lebih baik.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                {{-- Card PPID --}}
                <a href="{{ route('ppid.index') }}" class="group relative overflow-hidden rounded-2xl bg-gray-50 dark:bg-gray-800 p-8 border border-gray-100 dark:border-gray-700 hover:border-blue-200 dark:hover:border-blue-800 transition-all hover:shadow-lg">
                    <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                        <svg class="w-32 h-32 text-blue-600" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
                    </div>
                    <div class="relative z-10 flex flex-col h-full">
                        <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-xl flex items-center justify-center mb-6">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" /></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">PPID</h3>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-6 flex-grow">
                            Pejabat Pengelola Informasi dan Dokumentasi. Akses informasi publik secara mudah dan transparan.
                        </p>
                        <span class="inline-flex items-center text-sm font-semibold text-blue-600 dark:text-blue-400 group-hover:translate-x-1 transition-transform">
                            Ajukan Permohonan <svg class="w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                        </span>
                    </div>
                </a>

                {{-- Card Reformasi Birokrasi --}}
                <a href="{{ route('info-rb.index') }}" class="group relative overflow-hidden rounded-2xl bg-gray-50 dark:bg-gray-800 p-8 border border-gray-100 dark:border-gray-700 hover:border-green-200 dark:hover:border-green-800 transition-all hover:shadow-lg">
                    <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                        <svg class="w-32 h-32 text-green-600" fill="currentColor" viewBox="0 0 24 24"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm-2 16l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z"/></svg>
                    </div>
                    <div class="relative z-10 flex flex-col h-full">
                        <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 rounded-xl flex items-center justify-center mb-6">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Reformasi Birokrasi</h3>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-6 flex-grow">
                            Informasi mengenai tata kelola pemerintahan yang bersih, efektif, demokratis, dan terpercaya.
                        </p>
                        <span class="inline-flex items-center text-sm font-semibold text-green-600 dark:text-green-400 group-hover:translate-x-1 transition-transform">
                            Lihat Dokumen <svg class="w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                        </span>
                    </div>
                </a>
            </div>
        </div>
    </section>

    {{-- ========================================== --}}
    {{-- 5. POSTINGAN TERBARU (GRID)                --}}
    {{-- ========================================== --}}
    <section class="py-16 bg-gray-50 dark:bg-gray-800/20">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Berita Terkini</h2>
                <a href="{{ route('posts.index') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-700 dark:text-blue-400">Arsip Berita &rarr;</a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($latestPosts as $post)
                <article class="flex flex-col h-full group bg-white dark:bg-gray-800 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-all border border-gray-100 dark:border-gray-700">
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

    {{-- ========================================== --}}
    {{-- 6. VISI & MISI (VISUAL TEASER)             --}}
    {{-- ========================================== --}}
    <section class="relative bg-blue-900 py-24 px-4 sm:px-6 lg:px-8 overflow-hidden">
        {{-- Parallax Background Image --}}
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1518552686702-8610fe628859?q=80&w=2070&auto=format&fit=crop" 
                 alt="Background TVRI" 
                 class="w-full h-full object-cover opacity-20 transform scale-110">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-900/90 to-blue-900/40"></div>
        </div>

        <div class="relative z-10 container mx-auto flex flex-col md:flex-row items-center justify-between gap-10">
            <div class="md:w-1/2 text-white">
                <h2 class="text-3xl sm:text-4xl font-extrabold mb-4 tracking-tight">Visi Kami</h2>
                <p class="text-lg text-blue-100 leading-relaxed mb-8">
                    "Menjadi Lembaga Penyiaran Publik kelas dunia yang memotivasi dan memberdayakan melalui program informasi, pendidikan, dan hiburan yang sehat."
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('visi-misi') }}" class="px-6 py-3 bg-white text-blue-900 font-bold rounded-lg hover:bg-blue-50 transition-colors shadow-lg">
                        Lihat Misi Lengkap
                    </a>
                    <a href="{{ route('sejarah') }}" class="px-6 py-3 bg-transparent border-2 border-white text-white font-bold rounded-lg hover:bg-white hover:text-blue-900 transition-colors">
                        Tentang TVRI Jogja
                    </a>
                </div>
            </div>
            
            {{-- Decorative Element --}}
            <div class="md:w-5/12 hidden md:block">
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-4 mt-8">
                        <div class="h-32 bg-white/10 backdrop-blur-sm rounded-2xl w-full"></div>
                        <div class="h-48 bg-white/20 backdrop-blur-sm rounded-2xl w-full"></div>
                    </div>
                    <div class="space-y-4">
                        <div class="h-48 bg-white/20 backdrop-blur-sm rounded-2xl w-full"></div>
                        <div class="h-32 bg-white/10 backdrop-blur-sm rounded-2xl w-full"></div>
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