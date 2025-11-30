<x-layout>
    <x-slot:title>{{ $title ?? 'Tugas dan Fungsi' }}</x-slot:title>

    <div class="px-4 sm:px-6 lg:px-8 py-6 sm:py-6 lg:py-6 space-y-8 md:space-y-12">
        
        {{-- Header Halaman --}}
        <div class="text-center mb-6 sm:mb-8">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white">
                {{ $title }}
            </h1>
            <p class="mt-3 sm:mt-4 text-sm sm:text-base md:text-lg text-gray-500 dark:text-gray-400 max-w-3xl mx-auto">
                Lembaga Penyiaran Publik TVRI Stasiun D.I. Yogyakarta.
            </p>
        </div>

        {{-- ========================== --}}
        {{-- CARD 1: TUGAS (Gambar Kiri | Teks Kanan) --}}
        {{-- ========================== --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-xl transition-shadow duration-300">
            <div class="grid md:grid-cols-5 gap-0">
                
                {{-- GAMBAR KIRI (2 kolom) - Dengan efek 3D perspective --}}
                <div class="md:col-span-2 relative aspect-[4/3] md:aspect-auto md:min-h-full bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-900 dark:to-gray-800 overflow-visible p-6 sm:p-8 lg:p-10 flex items-center justify-center">
                    <div class="relative w-full max-w-md" style="perspective: 1000px;">
                        <div class="relative bg-white dark:bg-gray-700 rounded-xl shadow-2xl overflow-hidden" style="transform: rotateY(-10deg) rotateX(5deg);">
                            @if($tugas->isNotEmpty() && $tugas->first()->image)
                                <img class="w-full h-auto object-cover transition-transform duration-700 hover:scale-105" 
                                     src="{{ Storage::url($tugas->first()->image) }}" 
                                     alt="Tugas TVRI Yogyakarta">
                            @else
                                {{-- Placeholder Icon --}}
                                <div class="aspect-[4/3] flex items-center justify-center bg-gray-100 dark:bg-gray-800">
                                    <svg class="w-16 h-16 sm:w-20 sm:h-20 text-gray-300 dark:text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd"/>
                                        <path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z"/>
                                    </svg>
                                </div>
                            @endif
                            {{-- Shadow effect --}}
                            <div class="absolute inset-0 ring-1 ring-inset ring-gray-900/10 rounded-xl"></div>
                        </div>
                    </div>
                </div>

                {{-- TEKS KANAN (3 kolom) --}}
                <div class="md:col-span-3 p-6 sm:p-8 lg:p-10 flex flex-col justify-center">
                    <h2 class="mb-3 sm:mb-4 text-xl sm:text-2xl lg:text-3xl  font-bold text-gray-900 dark:text-white">
                        Tugas Kami
                    </h2>
                    
                    @if($tugas->count() > 0)
                        <div class="space-y-3 sm:space-y-4">
                            @foreach($tugas as $misi)
                                <div class="flex gap-3">
                                    {{-- Konten Tugas --}}
                                    <div class="prose prose-sm sm:prose-base dark:prose-invert text-gray-600 dark:text-gray-400 flex-1">
                                        {!! $misi->content !!}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm sm:text-base text-gray-500 dark:text-gray-400 italic">Data Tugas belum ditambahkan.</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- ========================== --}}
        {{-- CARD 2: FUNGSI (Teks Kiri | Gambar Kanan) --}}
        {{-- ========================== --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-xl transition-shadow duration-300">
            <div class="grid md:grid-cols-5 gap-0">
                
                {{-- TEKS KIRI (3 kolom) --}}
                <div class="md:col-span-3 p-6 sm:p-8 lg:p-10 flex flex-col justify-center order-2 md:order-1">
                    <h2 class="mb-3 sm:mb-4 text-xl sm:text-2xl lg:text-3xl  font-bold text-gray-900 dark:text-white">
                        Fungsi Kami
                    </h2>
                    
                    @if($fungsi->count() > 0)
                        <div class="space-y-3 sm:space-y-4">
                            @foreach($fungsi as $misi)
                                <div class="flex gap-3">
                                    {{-- Konten Fungsi --}}
                                    <div class="prose prose-sm sm:prose-base dark:prose-invert text-gray-600 dark:text-gray-400 flex-1">
                                        {!! $misi->content !!}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm sm:text-base text-gray-500 dark:text-gray-400 italic">Data Fungsi belum ditambahkan.</p>
                    @endif
                </div>

                {{-- GAMBAR KANAN (2 kolom) - Dengan efek 3D perspective --}}
                <div class="md:col-span-2 relative aspect-[4/3] md:aspect-auto md:min-h-full bg-gradient-to-br from-green-50 to-emerald-100 dark:from-gray-900 dark:to-gray-800 overflow-visible p-6 sm:p-8 lg:p-10 flex items-center justify-center order-1 md:order-2">
                    <div class="relative w-full max-w-md" style="perspective: 1000px;">
                        <div class="relative bg-white dark:bg-gray-700 rounded-xl shadow-2xl overflow-hidden" style="transform: rotateY(10deg) rotateX(5deg);">
                            @if($fungsi->isNotEmpty() && $fungsi->first()->image)
                                <img class="w-full h-auto object-cover transition-transform duration-700 hover:scale-105" 
                                     src="{{ Storage::url($fungsi->first()->image) }}" 
                                     alt="Fungsi TVRI Yogyakarta">
                            @else
                                {{-- Placeholder Icon --}}
                                <div class="aspect-[4/3] flex items-center justify-center bg-gray-100 dark:bg-gray-800">
                                    <svg class="w-16 h-16 sm:w-20 sm:h-20 text-gray-300 dark:text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"/>
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
    </div>
</x-layout>