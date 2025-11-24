<x-layout>
    <x-slot:title>{{ $title ?? 'Visi dan Misi' }}</x-slot:title>

    {{-- <div class="px-4 sm:px-6 lg:px-8"> --}}
    <div class="px-4 sm:px-6 lg:px-8 py-6 sm:py-6 lg:py-6 space-y-8 md:space-y-12">
        
        {{-- Header Halaman --}}
        <div class="text-center mb-6 sm:mb-8">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-gray-900 dark:text-white">
                {{ $title }}
            </h1>
            <p class="mt-3 sm:mt-4 text-sm sm:text-base md:text-lg text-gray-500 dark:text-gray-400 max-w-3xl mx-auto">
                Lembaga Penyiaran Publik TVRI Stasiun D.I. Yogyakarta.
            </p>
        </div>

        {{-- ========================== --}}
        {{-- CARD 1: VISI (Gambar Kiri | Teks Kanan) --}}
        {{-- ========================== --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-xl transition-shadow duration-300">
            <div class="grid md:grid-cols-5 gap-0">
                
                {{-- GAMBAR KIRI (2 kolom) - Dengan efek 3D perspective --}}
                <div class="md:col-span-2 relative aspect-[4/3] md:aspect-auto md:min-h-full bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-900 dark:to-gray-800 overflow-visible p-6 sm:p-8 lg:p-10 flex items-center justify-center">
                    <div class="relative w-full max-w-md" style="perspective: 1000px;">
                        <div class="relative bg-white dark:bg-gray-700 rounded-xl shadow-2xl overflow-hidden" style="transform: rotateY(-10deg) rotateX(5deg);">
                            @if($visi && $visi->image)
                                <img class="w-full h-auto object-cover transition-transform duration-700 hover:scale-105" 
                                     src="{{ Storage::url($visi->image) }}" 
                                     alt="Visi TVRI Yogyakarta">
                            @else
                                {{-- Placeholder Icon --}}
                                <div class="aspect-[4/3] flex items-center justify-center bg-gray-100 dark:bg-gray-800">
                                    <svg class="w-16 h-16 sm:w-20 sm:h-20 text-gray-300 dark:text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
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
                    <h2 class="mb-3 sm:mb-4 text-xl sm:text-2xl lg:text-3xl tracking-tight font-extrabold text-gray-900 dark:text-white">
                        Visi Kami
                    </h2>
                    <div class="text-sm sm:text-base text-gray-600 dark:text-gray-400 prose prose-sm sm:prose-base dark:prose-invert max-w-none">
                        @if($visi)
                            {!! $visi->content !!}
                        @else
                            <p class="italic">Data Visi belum ditambahkan.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- ========================== --}}
        {{-- CARD 2: MISI (Teks Kiri | Gambar Kanan) --}}
        {{-- ========================== --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-xl transition-shadow duration-300">
            <div class="grid md:grid-cols-5 gap-0">
                
                {{-- TEKS KIRI (3 kolom) --}}
                <div class="md:col-span-3 p-6 sm:p-8 lg:p-10 flex flex-col justify-center order-2 md:order-1">
                    <h2 class="mb-3 sm:mb-4 text-xl sm:text-2xl lg:text-3xl tracking-tight font-extrabold text-gray-900 dark:text-white">
                        Misi Kami
                    </h2>
                    
                    @if($misis->count() > 0)
                        <div class="space-y-3 sm:space-y-4">
                            @foreach($misis as $index => $misi)
                                <div class="flex gap-3">
                                    {{-- Konten Misi --}}
                                    <div class="prose prose-sm sm:prose-base dark:prose-invert text-gray-600 dark:text-gray-400 flex-1">
                                        {!! $misi->content !!}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm sm:text-base text-gray-500 dark:text-gray-400 italic">Data Misi belum ditambahkan.</p>
                    @endif
                </div>

                {{-- GAMBAR KANAN (2 kolom) - Dengan efek 3D perspective --}}
                <div class="md:col-span-2 relative aspect-[4/3] md:aspect-auto md:min-h-full bg-gradient-to-br from-purple-50 to-pink-100 dark:from-gray-900 dark:to-gray-800 overflow-visible p-6 sm:p-8 lg:p-10 flex items-center justify-center order-1 md:order-2">
                    <div class="relative w-full max-w-md" style="perspective: 1000px;">
                        <div class="relative bg-white dark:bg-gray-700 rounded-xl shadow-2xl overflow-hidden" style="transform: rotateY(10deg) rotateX(5deg);">
                            @if($misis->isNotEmpty() && $misis->first()->image)
                                <img class="w-full h-auto object-cover transition-transform duration-700 hover:scale-105" 
                                     src="{{ Storage::url($misis->first()->image) }}" 
                                     alt="Misi TVRI Yogyakarta">
                            @else
                                {{-- Placeholder Icon --}}
                                <div class="aspect-[4/3] flex items-center justify-center bg-gray-100 dark:bg-gray-800">
                                    <svg class="w-16 h-16 sm:w-20 sm:h-20 text-gray-300 dark:text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
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