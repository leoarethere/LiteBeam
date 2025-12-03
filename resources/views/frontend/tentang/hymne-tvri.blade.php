<x-layout>
    <x-slot:title>Himne & Mars TVRI</x-slot:title>

    <div class="px-4 sm:px-6 lg:px-8 py-8 sm:py-12 lg:py-16 space-y-8 md:space-y-16">
        
        {{-- Header Halaman --}}
        <div class="text-center mb-8 sm:mb-12">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white">
                Himne & Mars TVRI
            </h1>
            <p class="mt-3 sm:mt-4 text-sm sm:text-base md:text-lg text-gray-500 dark:text-gray-400 max-w-3xl mx-auto">
                Kumpulan lagu identitas, mars, dan himne yang menjadi semangat Lembaga Penyiaran Publik TVRI.
            </p>
        </div>

        {{-- Loop Data Himne --}}
        @forelse($hymnes as $index => $hymne)
            {{-- Tentukan arah layout: Ganjil = Gambar Kiri, Genap = Gambar Kanan --}}
            @php
                $isImageLeft = $loop->iteration % 2 != 0;
            @endphp

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <div class="grid md:grid-cols-5 gap-0">
                    
                    {{-- BAGIAN GAMBAR/POSTER (2 Kolom) --}}
                    <div class="md:col-span-2 relative aspect-[4/3] md:aspect-auto md:min-h-full overflow-visible p-6 sm:p-8 lg:p-10 flex items-center justify-center 
                        {{ $isImageLeft ? 'bg-gradient-to-br from-blue-50 to-cyan-100 dark:from-gray-900 dark:to-gray-800' : 'bg-gradient-to-br from-indigo-50 to-purple-100 dark:from-gray-900 dark:to-gray-800 md:order-2' }}">
                        
                        <div class="relative w-full max-w-xs sm:max-w-sm" style="perspective: 1000px;">
                            {{-- Efek 3D --}}
                            <div class="relative bg-white dark:bg-gray-700 rounded-xl shadow-2xl overflow-hidden transform transition-transform duration-500 hover:scale-105" 
                                 style="transform: rotateY({{ $isImageLeft ? '-10deg' : '10deg' }}) rotateX(5deg);">
                                
                                @if($hymne->poster)
                                    <img class="w-full h-auto object-cover" 
                                         src="{{ Storage::url($hymne->poster) }}" 
                                         alt="{{ $hymne->title }}">
                                @else
                                    {{-- Placeholder Icon Music --}}
                                    <div class="aspect-[3/4] flex items-center justify-center bg-gray-100 dark:bg-gray-800">
                                        <svg class="w-20 h-20 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                        </svg>
                                    </div>
                                @endif
                                
                                {{-- Shadow Overlay --}}
                                <div class="absolute inset-0 ring-1 ring-inset ring-gray-900/10 rounded-xl"></div>
                            </div>
                        </div>
                    </div>

                    {{-- BAGIAN TEKS (3 Kolom) --}}
                    <div class="md:col-span-3 p-6 sm:p-8 lg:p-10 flex flex-col justify-center {{ $isImageLeft ? '' : 'md:order-1' }}">
                        
                        {{-- Info Tambahan (Pencipta/Tahun) --}}
                        @if($hymne->info)
                            <div class="flex items-center gap-2 mb-2">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    {{ $hymne->info }}
                                </span>
                            </div>
                        @endif

                        {{-- Judul --}}
                        <h2 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white mb-4 leading-tight">
                            {{ $hymne->title }}
                        </h2>

                        {{-- Sinopsis / Lirik --}}
                        <div class="prose prose-sm sm:prose-base dark:prose-invert text-gray-600 dark:text-gray-400 mb-6">
                            {!! $hymne->synopsis !!}
                        </div>

                        {{-- Tombol Aksi (Link) --}}
                        @if($hymne->link)
                            <div>
                                <a href="{{ $hymne->link }}" target="_blank" rel="noopener noreferrer"
                                   class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-lg focus:ring-4 focus:ring-red-300 dark:focus:ring-red-900 transition-colors shadow-sm hover:shadow-md">
                                    <svg class="w-5 h-5 mr-2 -ml-1" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/>
                                    </svg>
                                    Tonton / Dengarkan
                                </a>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        @empty
            {{-- Empty State --}}
            <div class="text-center py-16 bg-gray-50 dark:bg-gray-800/50 rounded-xl border-2 border-dashed border-gray-300 dark:border-gray-700">
                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                </svg>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Belum ada data</h3>
                <p class="text-gray-500 dark:text-gray-400">Data Himne & Mars belum ditambahkan.</p>
            </div>
        @endforelse

        {{-- Paginasi --}}
        @if($hymnes->hasPages())
            <div class="mt-8 flex justify-center">
                {{ $hymnes->links('vendor.pagination.tailwind') }}
            </div>
        @endif

    </div>
</x-layout>