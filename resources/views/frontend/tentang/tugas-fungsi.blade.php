<x-layout>
    <x-slot:title>{{ $title ?? 'Tugas dan Fungsi' }}</x-slot:title>

    {{-- CSS Khusus untuk Efek 3D Responsif --}}
    @push('styles')
    <style>
        /* Default: Mobile (Flat / Tidak ada rotasi) */
        .tf-card-3d-left, 
        .tf-card-3d-right {
            transform: none;
            transition: transform 0.5s ease, box-shadow 0.5s ease;
        }

        /* Desktop (md ke atas): Terapkan efek 3D */
        @media (min-width: 768px) {
            .tf-card-3d-left {
                transform: rotateY(-10deg) rotateX(5deg);
            }
            .tf-card-3d-right {
                transform: rotateY(10deg) rotateX(5deg);
            }
            
            /* Hover Effect: Kembali datar & Zoom sedikit */
            .group:hover .tf-card-3d-left,
            .group:hover .tf-card-3d-right {
                transform: rotateY(0deg) rotateX(0deg) scale(1.02);
                z-index: 10;
            }
        }
    </style>
    @endpush

    {{-- WRAPPER UTAMA --}}
    <div class="px-4 sm:px-6 lg:px-8 py-8 sm:py-12 lg:py-16 space-y-12 md:space-y-20">
        
        {{-- HEADER HALAMAN --}}
        <div class="text-center max-w-3xl mx-auto">
            <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white tracking-tight">
                {{ $title }}
            </h1>
            <p class="mt-4 text-base sm:text-lg text-gray-500 dark:text-gray-400 leading-relaxed">
                Mandat dan peran utama Lembaga Penyiaran Publik TVRI Stasiun D.I. Yogyakarta.
            </p>
        </div>

        {{-- ========================== --}}
        {{-- CARD 1: TUGAS --}}
        {{-- Layout: Gambar Kiri (Desktop) / Atas (Mobile) --}}
        {{-- ========================== --}}
        <div class="group bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-xl transition-shadow duration-300">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-0">
                
                {{-- 1. GAMBAR --}}
                <div class="md:col-span-2 relative aspect-[4/3] md:aspect-auto md:min-h-[400px] bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-900 dark:to-gray-800 overflow-visible p-6 sm:p-8 flex items-center justify-center">
                    
                    {{-- 3D Wrapper --}}
                    <div class="relative w-full max-w-sm md:max-w-full" style="perspective: 1000px;">
                        <div class="relative bg-white dark:bg-gray-700 rounded-xl shadow-2xl overflow-hidden tf-card-3d-left">
                            @if($tugas->isNotEmpty() && $tugas->first()->image)
                                <img class="w-full h-full object-cover transition-transform duration-700" 
                                     src="{{ Storage::url($tugas->first()->image) }}" 
                                     alt="Tugas TVRI D.I. Yogyakarta">
                            @else
                                {{-- Placeholder Icon --}}
                                <div class="aspect-[4/3] flex items-center justify-center bg-gray-100 dark:bg-gray-800 text-gray-300 dark:text-gray-600">
                                    <svg class="w-20 h-20" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd"/>
                                        <path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z"/>
                                    </svg>
                                </div>
                            @endif
                            {{-- Inner Overlay --}}
                            <div class="absolute inset-0 ring-1 ring-inset ring-black/5 dark:ring-white/10 rounded-xl pointer-events-none"></div>
                        </div>
                    </div>
                </div>

                {{-- 2. TEKS --}}
                <div class="md:col-span-3 p-6 sm:p-8 lg:p-12 flex flex-col justify-center bg-white dark:bg-gray-800">
                    <h2 class="mb-6 text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white leading-tight">
                        Tugas Kami
                    </h2>
                    
                    @if($tugas->count() > 0)
                        <div class="prose prose-base sm:prose-lg dark:prose-invert text-gray-600 dark:text-gray-400 max-w-none">
                            @foreach($tugas as $item)
                                <div class="mb-4 last:mb-0">
                                    {{-- Render HTML dengan benar --}}
                                    {!! clean($item->content) !!}
                                </div>
                            @endforeach
                        </div>
                    @else
                        {{-- Empty State --}}
                        <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-700/50 border border-dashed border-gray-200 dark:border-gray-600 text-center">
                            <p class="text-gray-500 dark:text-gray-400 italic text-sm">Data Tugas belum ditambahkan.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- ========================== --}}
        {{-- CARD 2: FUNGSI --}}
        {{-- Layout: Gambar Kanan (Desktop) / Atas (Mobile) --}}
        {{-- ========================== --}}
        <div class="group bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-xl transition-shadow duration-300">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-0">
                
                {{-- 1. GAMBAR --}}
                {{-- Mobile: Urutan HTML pertama = Tampil paling atas --}}
                {{-- Desktop: `md:order-last` = Pindah ke kolom kanan --}}
                <div class="md:col-span-2 md:order-last relative aspect-[4/3] md:aspect-auto md:min-h-[400px] bg-gradient-to-br from-green-50 to-emerald-100 dark:from-gray-900 dark:to-gray-800 overflow-visible p-6 sm:p-8 flex items-center justify-center">
                    
                    {{-- 3D Wrapper --}}
                    <div class="relative w-full max-w-sm md:max-w-full" style="perspective: 1000px;">
                        <div class="relative bg-white dark:bg-gray-700 rounded-xl shadow-2xl overflow-hidden tf-card-3d-right">
                            @if($fungsi->isNotEmpty() && $fungsi->first()->image)
                                <img class="w-full h-full object-cover transition-transform duration-700" 
                                     src="{{ Storage::url($fungsi->first()->image) }}" 
                                     alt="Fungsi TVRI D.I. Yogyakarta">
                            @else
                                {{-- Placeholder Icon --}}
                                <div class="aspect-[4/3] flex items-center justify-center bg-gray-100 dark:bg-gray-800 text-gray-300 dark:text-gray-600">
                                    <svg class="w-20 h-20" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"/>
                                    </svg>
                                </div>
                            @endif
                            {{-- Inner Overlay --}}
                            <div class="absolute inset-0 ring-1 ring-inset ring-black/5 dark:ring-white/10 rounded-xl pointer-events-none"></div>
                        </div>
                    </div>
                </div>

                {{-- 2. TEKS --}}
                {{-- Desktop: `md:order-first` = Pindah ke kolom kiri --}}
                <div class="md:col-span-3 md:order-first p-6 sm:p-8 lg:p-12 flex flex-col justify-center bg-white dark:bg-gray-800">
                    <h2 class="mb-6 text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white leading-tight">
                        Fungsi Kami
                    </h2>
                    
                    @if($fungsi->count() > 0)
                        <div class="prose prose-base sm:prose-lg dark:prose-invert text-gray-600 dark:text-gray-400 max-w-none">
                            @foreach($fungsi as $item)
                                <div class="flex gap-4 mb-4 last:mb-0">
                                    {{-- Icon Check untuk List --}}
                                    <div class="flex-shrink-0 mt-1">
                                        <div class="flex items-center justify-center w-6 h-6 rounded-full bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-400 ring-2 ring-white dark:ring-gray-800 shadow-sm">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        {{-- Render HTML --}}
                                        <div class="text-gray-700 dark:text-gray-300 leading-relaxed">
                                            {!! clean($item->content) !!}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        {{-- Empty State --}}
                        <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-700/50 border border-dashed border-gray-200 dark:border-gray-600 text-center">
                            <p class="text-gray-500 dark:text-gray-400 italic text-sm">Data Fungsi belum ditambahkan.</p>
                        </div>
                    @endif
                </div>

            </div>
        </div>

    </div>
</x-layout>