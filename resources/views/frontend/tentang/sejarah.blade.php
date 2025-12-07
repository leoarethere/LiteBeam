<x-layout>
    <x-slot:title>{{ $title ?? 'Sejarah' }}</x-slot:title>

    {{-- CSS Khusus untuk Efek 3D Responsif --}}
    @push('styles')
    <style>
        /* Default: Mobile (Flat / Tidak ada rotasi) */
        .history-card-3d-left, 
        .history-card-3d-right {
            transform: none;
            transition: transform 0.5s ease, box-shadow 0.5s ease;
        }

        /* Desktop (md ke atas): Terapkan efek 3D */
        @media (min-width: 768px) {
            .history-card-3d-left {
                transform: rotateY(-10deg) rotateX(5deg);
            }
            .history-card-3d-right {
                transform: rotateY(10deg) rotateX(5deg);
            }
            
            /* Hover Effect: Kembali ke posisi datar (sedikit zoom) */
            .group:hover .history-card-3d-left,
            .group:hover .history-card-3d-right {
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
                Menelusuri jejak langkah perjalanan dan perkembangan kami melayani negeri.
            </p>
        </div>

        {{-- DAFTAR SEJARAH --}}
        <div class="space-y-12 md:space-y-16">
            @forelse($histories as $history)
                
                {{-- CARD CONTAINER --}}
                <div class="group bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-xl transition-shadow duration-300">
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-0">
                        
                        {{-- GAMBAR --}}
                        {{-- Logika Zig-Zag: 
                             - Ganjil: Gambar Kiri (Mobile: Atas) 
                             - Genap: Gambar Kanan (Mobile: Atas - menggunakan order-first)
                        --}}
                        @php
                            $isOdd = $loop->odd;
                            $bgGradient = $isOdd 
                                ? 'bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-900 dark:to-gray-800' 
                                : 'bg-gradient-to-br from-purple-50 to-pink-100 dark:from-gray-900 dark:to-gray-800';
                            
                            // Class Order untuk Desktop & Mobile
                            // Mobile: Selalu order-first (gambar di atas)
                            // Desktop: Ganjil (order-none/kiri), Genap (order-last/kanan)
                            $orderImage = $isOdd ? '' : 'md:order-last'; 
                            $orderText = $isOdd ? '' : 'md:order-first';
                            
                            // Class 3D Effect
                            $class3D = $isOdd ? 'history-card-3d-left' : 'history-card-3d-right';
                        @endphp

                        <div class="md:col-span-2 relative aspect-[4/3] md:aspect-auto md:min-h-[400px] {{ $bgGradient }} overflow-visible p-6 sm:p-8 flex items-center justify-center {{ $orderImage }}">
                            
                            {{-- Wrapper 3D --}}
                            <div class="relative w-full max-w-sm md:max-w-full" style="perspective: 1000px;">
                                <div class="relative bg-white dark:bg-gray-700 rounded-xl shadow-2xl overflow-hidden {{ $class3D }}">
                                    @if($history->image)
                                        <img class="w-full h-full object-cover transition-transform duration-700" 
                                             src="{{ Storage::url($history->image) }}" 
                                             alt="{{ $history->title }}">
                                    @else
                                        {{-- Placeholder Icon --}}
                                        <div class="aspect-[4/3] flex bg-gray-100 dark:bg-gray-800 items-center justify-center">
                                            <svg class="w-16 h-16 text-gray-300 dark:text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                    @endif
                                    
                                    {{-- Inner Border/Shadow Overlay --}}
                                    <div class="absolute inset-0 ring-1 ring-inset ring-black/5 dark:ring-white/10 rounded-xl pointer-events-none"></div>
                                </div>
                            </div>
                        </div>
            
                        {{-- TEKS --}}
                        <div class="md:col-span-3 p-6 sm:p-8 lg:p-10 flex flex-col justify-center bg-white dark:bg-gray-800 {{ $orderText }}">
                            <div class="max-w-2xl">
                                <h2 class="mb-4 text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white leading-tight">
                                    {{ $history->title }}
                                </h2>
                                <div class="prose prose-base sm:prose-lg dark:prose-invert text-gray-600 dark:text-gray-400">
                                    {!! clean($history->content) !!}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            @empty
                {{-- EMPTY STATE --}}
                <div class="text-center py-16 bg-gray-50 dark:bg-gray-800/50 rounded-3xl border-2 border-dashed border-gray-200 dark:border-gray-700">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-700 mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Belum ada data sejarah</h3>
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Silakan tambahkan data melalui dashboard admin.</p>
                </div>
            @endforelse
        </div>

    </div>
</x-layout>