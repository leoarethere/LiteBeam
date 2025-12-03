<x-layout>
    <x-slot:title>{{ $title ?? 'Sejarah' }}</x-slot:title>

    <div class="px-4 sm:px-6 lg:px-8 py-6 sm:py-6 lg:py-6 space-y-8 md:space-y-12">
        
        {{-- HEADLINE / JUDUL HALAMAN --}}
        <div class="text-center mb-6 sm:mb-8">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white">
                {{ $title }}
            </h1>
            <p class="mt-3 sm:mt-4 text-sm sm:text-base md:text-lg text-gray-500 dark:text-gray-400 max-w-3xl mx-auto">
                Menelusuri jejak langkah perjalanan dan perkembangan kami melayani negeri.
            </p>
        </div>

        {{-- LOOPING DATA SEJARAH --}}
        @forelse($histories as $history)
            
            {{-- LOGIKA ZIG-ZAG --}}
            {{-- Item Ganjil (1, 3, 5): Gambar Kiri, Teks Kanan --}}
            @if($loop->odd)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-xl transition-shadow duration-300">
                    <div class="grid md:grid-cols-5 gap-0">
                        
                        {{-- GAMBAR (KIRI) - Dengan efek 3D perspective --}}
                        <div class="md:col-span-2 relative aspect-[4/3] md:aspect-auto md:min-h-full bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-900 dark:to-gray-800 overflow-visible p-6 sm:p-8 lg:p-10 flex items-center justify-center">
                            <div class="relative w-full max-w-md" style="perspective: 1000px;">
                                <div class="relative bg-white dark:bg-gray-700 rounded-xl shadow-2xl overflow-hidden" style="transform: rotateY(-10deg) rotateX(5deg);">
                                    @if($history->image)
                                        <img class="w-full h-full object-cover transition-transform duration-700 hover:scale-105" 
                                             src="{{ Storage::url($history->image) }}" 
                                             alt="{{ $history->title }}">
                                    @else
                                        {{-- Placeholder Icon --}}
                                        <div class="aspect-[4/3] flex bg-gray-100 dark:bg-gray-800 items-center justify-center">
                                            <svg class="w-16 h-16 sm:w-20 sm:h-20 text-gray-300 dark:text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                    @endif
                                    {{-- Shadow effect --}}
                                    <div class="absolute inset-0 ring-1 ring-inset ring-gray-900/10 rounded-xl"></div>
                                </div>
                            </div>
                        </div>
            
                        {{-- TEKS (KANAN) --}}
                        <div class="md:col-span-3 p-6 sm:p-8 lg:p-10 flex flex-col justify-center">
                            <h2 class="mb-3 sm:mb-4 text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white">
                                {{ $history->title }}
                            </h2>
                            {{-- PERBAIKAN: Menggunakan 'content' sesuai database --}}
                            <div class="text-sm sm:text-base text-gray-600 dark:text-gray-400 prose prose-sm sm:prose-base dark:prose-invert max-w-none">
                                {!! $history->content !!}
                            </div>
                        </div>
                    </div>
                </div>

            {{-- Item Genap (2, 4, 6): Gambar Kanan, Teks Kiri --}}
            @else
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-xl transition-shadow duration-300">
                    <div class="grid md:grid-cols-5 gap-0">
                        
                        {{-- TEKS (KIRI) --}}
                        <div class="md:col-span-3 p-6 sm:p-8 lg:p-10 flex flex-col justify-center order-2 md:order-1">
                            <h2 class="mb-3 sm:mb-4 text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white">
                                {{ $history->title }}
                            </h2>
                            {{-- PERBAIKAN: Menggunakan 'content' sesuai database --}}
                            <div class="text-sm sm:text-base text-gray-600 dark:text-gray-400 prose prose-sm sm:prose-base dark:prose-invert max-w-none">
                                {!! $history->content !!}
                            </div>
                        </div>
            
                        {{-- GAMBAR (KANAN) - Dengan efek 3D perspective --}}
                        <div class="md:col-span-2 relative aspect-[4/3] md:aspect-auto md:min-h-full bg-gradient-to-br from-purple-50 to-pink-100 dark:from-gray-900 dark:to-gray-800 overflow-visible p-6 sm:p-8 lg:p-10 flex items-center justify-center order-1 md:order-2">
                            <div class="relative w-full max-w-md" style="perspective: 1000px;">
                                <div class="relative bg-white dark:bg-gray-700 rounded-xl shadow-2xl overflow-hidden" style="transform: rotateY(10deg) rotateX(5deg);">
                                    @if($history->image)
                                        <img class="w-full h-full object-cover transition-transform duration-700 hover:scale-105" 
                                             src="{{ Storage::url($history->image) }}" 
                                             alt="{{ $history->title }}">
                                    @else
                                        {{-- Placeholder Icon --}}
                                        <div class="aspect-[4/3] flex items-center justify-center bg-gray-100 dark:bg-gray-800">
                                            <svg class="w-16 h-16 sm:w-20 sm:h-20 text-gray-300 dark:text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                    @endif
                                    {{-- Shadow effect --}}
                                    <div class="absolute inset-0 ring-1 ring-inset ring-gray-900/10 rounded-xl"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        @empty
            {{-- TAMPILAN JIKA BELUM ADA DATA --}}
            <div class="text-center py-12 bg-gray-50 dark:bg-gray-800 rounded-xl border-2 border-dashed border-gray-300 dark:border-gray-600">
                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Belum ada data sejarah</h3>
                <p class="mt-1 text-gray-500 dark:text-gray-400">Silakan tambahkan data melalui dashboard admin.</p>
            </div>
        @endforelse

    </div>
</x-layout>