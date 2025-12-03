<x-layout>
    <x-slot:title>Prestasi & Penghargaan</x-slot:title>

    <div class="px-4 sm:px-6 lg:px-8 py-8 sm:py-12 lg:py-16 space-y-8 md:space-y-16">
        
        {{-- Header Halaman --}}
        <div class="text-center mb-8 sm:mb-12">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white">
                Prestasi & Penghargaan
            </h1>
            <p class="mt-3 sm:mt-4 text-sm sm:text-base md:text-lg text-gray-500 dark:text-gray-400 max-w-3xl mx-auto">
                Jejak langkah dan pencapaian TVRI Stasiun D.I. Yogyakarta dalam memberikan layanan penyiaran terbaik.
            </p>
        </div>

        {{-- Loop Data Prestasi --}}
        @forelse($prestasis as $index => $prestasi)
            {{-- Tentukan arah layout: Ganjil = Gambar Kiri, Genap = Gambar Kanan --}}
            @php
                $isImageLeft = $loop->iteration % 2 != 0;
            @endphp

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <div class="grid md:grid-cols-5 gap-0">
                    
                    {{-- BAGIAN GAMBAR (2 Kolom) --}}
                    {{-- Logic order-last jika gambar kanan --}}
                    <div class="md:col-span-2 relative aspect-[4/3] md:aspect-auto md:min-h-full overflow-visible p-6 sm:p-8 lg:p-10 flex items-center justify-center 
                        {{ $isImageLeft ? 'bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-900 dark:to-gray-800' : 'bg-gradient-to-br from-purple-50 to-pink-100 dark:from-gray-900 dark:to-gray-800 md:order-2' }}">
                        
                        <div class="relative w-full max-w-md" style="perspective: 1000px;">
                            {{-- Efek 3D: Rotasi berbeda tergantung posisi --}}
                            <div class="relative bg-white dark:bg-gray-700 rounded-xl shadow-2xl overflow-hidden transform transition-transform duration-500 hover:scale-105" 
                                 style="transform: rotateY({{ $isImageLeft ? '-10deg' : '10deg' }}) rotateX(5deg);">
                                
                                @if($prestasi->image)
                                    <img class="w-full h-auto object-cover" 
                                         src="{{ Storage::url($prestasi->image) }}" 
                                         alt="{{ $prestasi->title }}">
                                @else
                                    {{-- Placeholder Icon --}}
                                    <div class="aspect-[4/3] flex items-center justify-center bg-gray-100 dark:bg-gray-800">
                                        <svg class="w-16 h-16 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
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
                        
                        {{-- Tahun & Kategori --}}
                        <div class="flex flex-wrap items-center gap-2 mb-3">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                                Tahun {{ $prestasi->year }}
                            </span>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-600">
                                {{ $prestasi->category }}
                            </span>
                        </div>

                        {{-- Judul Prestasi --}}
                        <h2 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white mb-2 leading-tight">
                            {{ $prestasi->title }}
                        </h2>

                        {{-- Nama Penghargaan --}}
                        <div class="flex items-center gap-2 text-yellow-600 dark:text-yellow-400 font-medium text-sm sm:text-base mb-4">
                            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <span>{{ $prestasi->award_name }}</span>
                        </div>

                        {{-- Deskripsi / Jenis --}}
                        <div class="prose prose-sm sm:prose-base dark:prose-invert text-gray-600 dark:text-gray-400">
                            <p>
                                Penghargaan tingkat <strong>{{ $prestasi->type }}</strong> yang diraih atas dedikasi dan karya terbaik dalam industri penyiaran.
                            </p>
                        </div>

                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-16 bg-gray-50 dark:bg-gray-800/50 rounded-xl border-2 border-dashed border-gray-300 dark:border-gray-700">
                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="12" cy="8" r="7"></circle>
                    <polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Belum ada prestasi</h3>
                <p class="text-gray-500 dark:text-gray-400">Data prestasi belum ditambahkan.</p>
            </div>
        @endforelse

        {{-- Paginasi --}}
        @if($prestasis->hasPages())
            <div class="mt-8 flex justify-center">
                {{ $prestasis->links('vendor.pagination.tailwind') }}
            </div>
        @endif

    </div>
</x-layout>