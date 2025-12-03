<x-layout>
    <x-slot:title>Informasi Magang / PKL</x-slot:title>

    {{-- KONTAINER UTAMA --}}
    <div class="px-4 sm:px-6 lg:px-8">

        {{-- HERO SECTION (Disamakan dengan tema lainnya) --}}
        <div class="relative rounded-3xl overflow-hidden mb-6 bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 dark:from-blue-900 dark:via-blue-950 dark:to-indigo-950 shadow-xl">
            {{-- Pattern Overlay --}}
            <div class="absolute inset-0 bg-grid-white/[0.03] bg-[size:24px_24px] [mask-image:radial-gradient(ellipse_at_center,black_40%,transparent_100%)]"></div>
            
            <div class="relative px-6 py-12 lg:px-12 lg:py-20 text-center">
                <div class="max-w-3xl mx-auto">
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-4 drop-shadow-md">
                        Informasi Magang / PKL
                    </h1>
                    <p class="text-blue-100 text-lg max-w-2xl mx-auto leading-relaxed">
                        Temukan peluang pengembangan karir dan pengalaman kerja nyata bersama TVRI Stasiun D.I. Yogyakarta.
                    </p>
                </div>
            </div>
        </div>

        {{-- FORM PENCARIAN & FILTER (Diperbarui sesuai tema lainnya) --}}
        <div class="mb-6">
            <form method="GET" action="{{ route('info-magang.index') }}" class="mx-auto">
                <div class="flex flex-col md:flex-row gap-4 p-2 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                    
                    {{-- Input Search --}}
                    <div class="relative flex-grow">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <input type="text" 
                            name="search" 
                            value="{{ request('search') }}" 
                            class="block w-full p-3 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                            placeholder="Cari lowongan atau panduan magang...">
                    </div>

                    {{-- Select Sort (Urutan) --}}
                    <select name="sort" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full md:w-48 p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="latest" {{ request('sort', 'latest') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                    </select>

                    {{-- Tombol Action --}}
                    <div class="flex gap-2">
                        <button type="submit" class="w-full md:w-auto px-6 py-3 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 transition-colors">
                            Cari
                        </button>
                        @if(request()->hasAny(['search', 'sort']))
                            <a href="{{ route('info-magang.index') }}" class="w-full md:w-auto px-6 py-3 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600 transition-colors flex items-center justify-center">
                                Reset
                            </a>
                        @endif
                    </div>
                </div>
            </form>

            {{-- Info Hasil Pencarian --}}
            @if(request()->hasAny(['search', 'sort']))
                <div class="max-w-5xl mx-auto mt-4 text-sm text-gray-600 dark:text-gray-400">
                    Menampilkan {{ $items->total() }} informasi
                    @if(request('search'))
                        untuk pencarian <strong class="text-gray-900 dark:text-white">"{{ request('search') }}"</strong>
                    @endif
                </div>
            @endif
        </div>

        {{-- CONTENT GRID --}}
        <div class="mb-16">
            @if($items->count() > 0)
                <div class="grid gap-6 mb-8 lg:mb-12 md:grid-cols-2">
                    @foreach($items as $item)
                        <div class="group bg-white dark:bg-gray-800 rounded-2xl shadow-sm hover:shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden transition-all duration-300 hover:-translate-y-1 flex flex-col sm:flex-row h-full">
                            
                            {{-- Bagian Gambar / Icon (Kiri/Atas) --}}
                            <a href="{{ $item->source_link }}" target="_blank" class="flex-shrink-0 w-full sm:w-48 h-48 sm:h-auto relative overflow-hidden bg-gray-100 dark:bg-gray-700">
                                @if($item->cover_image)
                                    <img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" 
                                         src="{{ Storage::url($item->cover_image) }}" 
                                         alt="{{ $item->title }}"
                                         onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\"w-full h-full flex items-center justify-center bg-blue-50 dark:bg-gray-700 group-hover:bg-blue-100 dark:group-hover:bg-gray-600 transition-colors\"><svg class=\"w-16 h-16 text-blue-300 dark:text-gray-500\" fill=\"currentColor\" viewBox=\"0 0 20 20\"><path d=\"M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z\"></path></svg></div>'">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-blue-50 dark:bg-gray-700 group-hover:bg-blue-100 dark:group-hover:bg-gray-600 transition-colors">
                                        <svg class="w-16 h-16 text-blue-300 dark:text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.973 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </a>

                            {{-- Bagian Konten (Kanan/Bawah) --}}
                            <div class="p-6 flex flex-col justify-between w-full">
                                <div>
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300">
                                            Info Magang
                                        </span>
                                        <span class="text-xs text-gray-400 flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $item->created_at->format('d M Y') }}
                                        </span>
                                    </div>
                                    
                                    <h3 class="text-xl font-bold tracking-tight text-gray-900 dark:text-white mb-2 leading-snug">
                                        <a href="{{ $item->source_link }}" target="_blank" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors line-clamp-2">
                                            {{ $item->title }}
                                        </a>
                                    </h3>
                                    
                                    <div class="font-light text-gray-500 dark:text-gray-400 text-sm line-clamp-2 mb-4">
                                        {{ Str::limit(strip_tags($item->description), 100) }}
                                    </div>
                                </div>
                                
                                {{-- Action Buttons --}}
                                <div class="flex items-center gap-4 pt-4 border-t border-gray-100 dark:border-gray-700 mt-auto">
                                    {{-- Tombol Lihat Detail --}}
                                    <a href="{{ $item->source_link }}" target="_blank" class="flex items-center gap-2 text-sm font-medium text-gray-600 hover:text-blue-600 dark:text-gray-300 dark:hover:text-blue-400 transition-colors group/link">
                                        <div class="p-1.5 rounded-lg bg-gray-100 dark:bg-gray-700 group-hover/link:bg-blue-50 dark:group-hover/link:bg-blue-900/30 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                            </svg>
                                        </div>
                                        Lihat Detail
                                    </a>

                                    {{-- Tombol Salin --}}
                                    <button onclick="copyLink('{{ $item->source_link }}')" class="flex items-center gap-2 text-sm font-medium text-gray-600 hover:text-green-600 dark:text-gray-300 dark:hover:text-green-400 transition-colors group/copy ml-auto">
                                        <div class="p-1.5 rounded-lg bg-gray-100 dark:bg-gray-700 group-hover/copy:bg-green-50 dark:group-hover/copy:bg-green-900/30 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                        <span class="hidden sm:inline">Salin Link</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                {{-- Empty State --}}
                <div class="text-center py-20 bg-gray-50 dark:bg-gray-800/50 rounded-3xl border-2 border-dashed border-gray-200 dark:border-gray-700">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-white dark:bg-gray-800 shadow-sm mb-6">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Informasi Tidak Ditemukan</h3>
                    <p class="text-gray-600 dark:text-gray-400 max-w-md mx-auto mb-8">
                        @if(request('search'))
                            Tidak ada info magang yang cocok dengan kata kunci <strong>"{{ request('search') }}"</strong>.
                        @else
                            Belum ada informasi magang/PKL yang tersedia saat ini.
                        @endif
                    </p>
                    @if(request('search'))
                        <a href="{{ route('info-magang.index') }}" class="inline-flex items-center px-5 py-2.5 border border-transparent text-sm font-medium rounded-xl text-white bg-blue-600 hover:bg-blue-700 transition-colors shadow-sm">
                            Tampilkan Semua
                        </a>
                    @endif
                </div>
            @endif

            {{-- Pagination --}}
            @if($items->hasPages())
                <div class="mt-8 flex justify-center">
                    {{ $items->withQueryString()->links('vendor.pagination.tailwind') }}
                </div>
            @endif
        </div>
    </div>

    {{-- JavaScript untuk copy link --}}
    <script>
        function copyLink(url) {
            navigator.clipboard.writeText(url).then(function() {
                const toast = document.createElement('div');
                toast.className = 'fixed top-4 right-4 bg-green-600 text-white px-4 py-2 rounded-lg shadow-lg z-50';
                toast.textContent = 'Link berhasil disalin ke clipboard!';
                document.body.appendChild(toast);
                
                setTimeout(() => {
                    toast.remove();
                }, 3000);
            }).catch(function(err) {
                console.error('Gagal menyalin link: ', err);
                alert('Gagal menyalin link. Silakan salin manual.');
            });
        }
        
        // Fallback untuk browser yang tidak mendukung clipboard API
        if (!navigator.clipboard) {
            console.warn('Clipboard API tidak didukung');
        }
    </script>
</x-layout>