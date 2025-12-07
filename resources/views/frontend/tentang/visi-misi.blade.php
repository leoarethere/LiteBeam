<x-layout>
    <x-slot:title>{{ $title ?? 'Visi dan Misi' }}</x-slot:title>

    {{-- CSS Khusus untuk Efek 3D Responsif --}}
    @push('styles')
    <style>
        /* Default: Mobile (Flat / Tidak ada rotasi) */
        .vm-card-3d-left, 
        .vm-card-3d-right {
            transform: none;
            transition: transform 0.5s ease, box-shadow 0.5s ease;
        }

        /* Desktop (md ke atas): Terapkan efek 3D */
        @media (min-width: 768px) {
            .vm-card-3d-left {
                transform: rotateY(-10deg) rotateX(5deg);
            }
            .vm-card-3d-right {
                transform: rotateY(10deg) rotateX(5deg);
            }
            
            /* Hover Effect: Kembali ke posisi datar (sedikit zoom) */
            .group:hover .vm-card-3d-left,
            .group:hover .vm-card-3d-right {
                transform: rotateY(0deg) rotateX(0deg) scale(1.02);
                z-index: 10;
            }
        }
    </style>
    @endpush

    <div class="px-4 sm:px-6 lg:px-8 py-8 sm:py-12 lg:py-16 space-y-12 md:space-y-20">
        
        {{-- HEADLINE --}}
        <div class="text-center max-w-3xl mx-auto">
            <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white tracking-tight">
                {{ $title }}
            </h1>
            <p class="mt-4 text-base sm:text-lg text-gray-500 dark:text-gray-400 leading-relaxed">
                Arah dan tujuan utama Lembaga Penyiaran Publik TVRI Stasiun D.I. Yogyakarta.
            </p>
        </div>

        {{-- ========================== --}}
        {{-- BAGIAN 1: VISI (Layout Ganjil/Kiri) --}}
        {{-- ========================== --}}
        <div class="group bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-xl transition-shadow duration-300">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-0">
                
                {{-- GAMBAR VISI --}}
                <div class="md:col-span-2 relative aspect-[4/3] md:aspect-auto md:min-h-[400px] bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-900 dark:to-gray-800 overflow-visible p-6 sm:p-8 flex items-center justify-center">
                    
                    {{-- Wrapper 3D --}}
                    <div class="relative w-full max-w-sm md:max-w-full" style="perspective: 1000px;">
                        <div class="relative bg-white dark:bg-gray-700 rounded-xl shadow-2xl overflow-hidden vm-card-3d-left">
                            @if($visis->isNotEmpty() && $visis->first()->image)
                                <img class="w-full h-full object-cover transition-transform duration-700" 
                                     src="{{ Storage::url($visis->first()->image) }}" 
                                     alt="Visi TVRI Yogyakarta">
                            @else
                                {{-- Placeholder Icon --}}
                                <div class="aspect-[4/3] flex items-center justify-center bg-gray-100 dark:bg-gray-800 text-gray-300 dark:text-gray-600">
                                    <svg class="w-20 h-20" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            @endif
                            
                            {{-- Inner Border Overlay --}}
                            <div class="absolute inset-0 ring-1 ring-inset ring-black/5 dark:ring-white/10 rounded-xl pointer-events-none"></div>
                        </div>
                    </div>
                </div>

                {{-- TEKS VISI --}}
                <div class="md:col-span-3 p-6 sm:p-8 lg:p-12 flex flex-col justify-center bg-white dark:bg-gray-800">
                    <h2 class="mb-6 text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white leading-tight">
                        Visi Kami
                    </h2>

                    <div class="prose prose-base sm:prose-lg dark:prose-invert text-gray-600 dark:text-gray-400 max-w-none">
                        @forelse($visis as $visi)
                            <div class="mb-6 last:mb-0 relative pl-6">
                                {{-- Decorative Quote Line --}}
                                <div class="absolute left-0 top-1 bottom-1 w-1 bg-blue-500 rounded-full"></div>
                                {{-- PERBAIKAN: Gunakan {!! !!} dan div agar HTML render --}}
                                <div class="text-gray-800 dark:text-gray-200 font-medium text-lg italic leading-relaxed">
                                    {!! clean($visi->content) !!}
                                </div>
                            </div>
                        @empty
                            <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-700/50 border border-dashed border-gray-200 dark:border-gray-600 text-center">
                                <p class="text-gray-500 dark:text-gray-400 italic text-sm">Data Visi belum tersedia.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>

        {{-- ========================== --}}
        {{-- BAGIAN 2: MISI (Layout Genap/Kanan) --}}
        {{-- ========================== --}}
        <div class="group bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-xl transition-shadow duration-300">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-0">
                
                {{-- GAMBAR MISI --}}
                <div class="md:col-span-2 md:order-last relative aspect-[4/3] md:aspect-auto md:min-h-[400px] bg-gradient-to-br from-purple-50 to-pink-100 dark:from-gray-900 dark:to-gray-800 overflow-visible p-6 sm:p-8 flex items-center justify-center">
                    
                    {{-- Wrapper 3D --}}
                    <div class="relative w-full max-w-sm md:max-w-full" style="perspective: 1000px;">
                        <div class="relative bg-white dark:bg-gray-700 rounded-xl shadow-2xl overflow-hidden vm-card-3d-right">
                            @if($misis->isNotEmpty() && $misis->first()->image)
                                <img class="w-full h-full object-cover transition-transform duration-700" 
                                     src="{{ Storage::url($misis->first()->image) }}" 
                                     alt="Misi TVRI Yogyakarta">
                            @else
                                <div class="aspect-[4/3] flex items-center justify-center bg-gray-100 dark:bg-gray-800 text-gray-300 dark:text-gray-600">
                                    <svg class="w-20 h-20" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                                    </svg>
                                </div>
                            @endif
                            <div class="absolute inset-0 ring-1 ring-inset ring-black/5 dark:ring-white/10 rounded-xl pointer-events-none"></div>
                        </div>
                    </div>
                </div>

                {{-- TEKS MISI --}}
                <div class="md:col-span-3 md:order-first p-6 sm:p-8 lg:p-12 flex flex-col justify-center bg-white dark:bg-gray-800">
                    <h2 class="mb-6 text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white leading-tight">
                        Misi Kami
                    </h2>

                    <div class="prose prose-base sm:prose-lg dark:prose-invert text-gray-600 dark:text-gray-400 max-w-none">
                        @forelse($misis as $misi)
                            <div class="flex gap-4 mb-4 last:mb-0">
                                <div class="flex-1">
                                    {{-- PERBAIKAN UTAMA: Gunakan {!! !!} untuk merender HTML dari database --}}
                                    {{-- Gunakan div (bukan p) agar valid karena di dalamnya mungkin ada block element seperti <ul> atau <ol> --}}
                                    <div class="text-gray-700 dark:text-gray-300 leading-relaxed">
                                        {!! clean($misi->content) !!}
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-700/50 border border-dashed border-gray-200 dark:border-gray-600 text-center">
                                <p class="text-gray-500 dark:text-gray-400 italic text-sm">Data Misi belum tersedia.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>

    </div>
</x-layout>