<x-layout>
    <x-slot:title>
        {{ $title ?? 'Jadwal Acara' }}
        @if(request('day'))
            - {{ ucwords(str_replace('-', ' ', request('day'))) }}
        @endif
    </x-slot:title>

    {{-- LOGIKA PHP --}}
    @php
        $dataJadwal = $jadwals ?? $jadwalAcaras ?? collect([]);
        $groupedJadwal = $dataJadwal->groupBy(function($item) {
            return $item->jadwalCategory->name ?? 'Lainnya';
        });
        $listHari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
    @endphp

    {{-- KONTAINER UTAMA --}}
    <div class="min-h-screen px-4 sm:px-6 lg:px-8">

        {{-- HERO SECTION --}}
        <div class="relative rounded-3xl overflow-hidden mb-8 bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 dark:from-blue-900 dark:via-blue-950 dark:to-indigo-950 shadow-xl">
            <div class="absolute inset-0 bg-grid-white/[0.05] bg-[size:24px_24px]"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
            
            <div class="relative px-6 py-12 lg:px-12 lg:py-20 text-center z-10">
                <div class="max-w-3xl mx-auto">
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-white mb-4 drop-shadow-sm">
                        Jadwal Acara TVRI
                    </h1>
                    <p class="text-blue-100 text-base sm:text-lg max-w-2xl mx-auto leading-relaxed">
                        Simak Jadwal Acaraan edukatif, informatif, dan menghibur pilihan kami hari ini dan hari-hari mendatang.
                    </p>
                </div>
            </div>
        </div>

        {{-- BAGIAN FILTER HARI --}}
        <div class="mb-6">
            <div class="relative group">
                {{-- Fade effect mobile --}}
                <div class="absolute -center-4 top-0 bottom-0 w-12 bg-gradient-to-r from-gray-50 dark:from-gray-900 to-transparent z-10 pointer-events-none md:hidden"></div>
                
                    <div class="overflow-x-auto scrollbar-hide -mx-4 px-4 lg:mx-0 lg:px-0">
                        <nav class="flex justify-center gap-2 lg:gap-3 pb-2" style="min-width: min-content;">
                        
                        <a href="{{ route('publikasi.jadwal') }}"
                           class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-medium rounded-full transition-all duration-200 whitespace-nowrap border shadow-sm
                           {{ !request('day') 
                               ? 'bg-blue-600 border-blue-600 text-white hover:bg-blue-700' 
                               : 'bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            Semua Hari
                        </a>

                        @foreach($listHari as $hari)
                            @php $slug = strtolower($hari); @endphp
                            <a href="{{ route('publikasi.jadwal', ['day' => $slug]) }}"
                               class="inline-flex items-center px-5 py-2.5 text-sm font-medium rounded-full transition-all duration-200 whitespace-nowrap border shadow-sm
                               {{ request('day') == $slug 
                                   ? 'bg-blue-600 border-blue-600 text-white hover:bg-blue-700' 
                                   : 'bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
                                {{ $hari }}
                            </a>
                        @endforeach
                    </nav>
                </div>
                <div class="absolute -right-4 top-0 bottom-0 w-12 bg-gradient-to-l from-gray-50 dark:from-gray-900 to-transparent z-10 pointer-events-none md:hidden"></div>
            </div>
        </div>

        {{-- LIST JADWAL --}}
        <div class="pb-8">
            @if($dataJadwal->count() > 0)
                <div class="space-y-8">
                    @foreach($groupedJadwal as $dayName => $schedules)
                        
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                            
                            {{-- Header Hari --}}
                            <div class="bg-gray-50 dark:bg-gray-700/30 px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center gap-3">
                                <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </span>
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white capitalize">
                                    {{ $dayName }}
                                </h3>
                            </div>

                            {{-- List Item Jadwal --}}
                            <div class="divide-y divide-gray-100 dark:divide-gray-700/50">
                                @foreach($schedules as $schedule)
                                    <div class="group p-5 hover:bg-blue-50/50 dark:hover:bg-blue-900/10 transition-colors duration-200 flex flex-col md:flex-row gap-4 md:items-center">
                                        
                                        {{-- Waktu --}}
                                        <div class="flex-shrink-0 md:w-48">
                                            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800/30 text-blue-700 dark:text-blue-300 font-mono text-sm font-bold">
                                                <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                <span>{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}</span>
                                                <span class="opacity-50">-</span>
                                                <span>{{ $schedule->end_time ? \Carbon\Carbon::parse($schedule->end_time)->format('H:i') : 'Selesai' }}</span>
                                            </div>
                                        </div>

                                        {{-- Info Program --}}
                                        <div class="flex-1 min-w-0">
                                            <div class="flex flex-wrap items-center gap-2 mb-1">
                                                <h4 class="text-lg font-bold text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                                    {{ $schedule->title }}
                                                </h4>
                                                
                                                {{-- Kategori Badge --}}
                                                @if($schedule->broadcastCategory)
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wide {{ $schedule->broadcastCategory->color_classes }} border border-transparent/10">
                                                        {{ $schedule->broadcastCategory->name }}
                                                    </span>
                                                @endif
                                            </div>
                                            
                                            <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-1">
                                                Saksikan tayangan {{ strtolower($schedule->broadcastCategory->name ?? 'menarik') }} hanya di TVRI D.I. Yogyakarta.
                                            </p>
                                        </div>

                                        {{-- Action (Desktop) --}}
                                        <div class="hidden md:block">
                                            <span class="text-gray-300 dark:text-gray-600">
                                                <svg class="w-5 h-5 group-hover:text-blue-500 transition-colors transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                            </span>
                                        </div>

                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                {{-- EMPTY STATE --}}
                <div class="text-center py-16 bg-white dark:bg-gray-800 rounded-3xl border border-dashed border-gray-200 dark:border-gray-700">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gray-50 dark:bg-gray-700/50 mb-6 text-gray-400 dark:text-gray-500">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Jadwal Tidak Ditemukan</h3>
                    <p class="text-gray-500 dark:text-gray-400 max-w-md mx-auto mb-8">
                        @if(request('day')) 
                            Tidak ada jadwal acara untuk hari <strong>{{ ucwords(request('day')) }}</strong> saat ini. 
                        @else 
                            Belum ada jadwal acara yang tersedia. 
                        @endif
                    </p>
                    @if(request('day'))
                        <a href="{{ route('publikasi.jadwal') }}" class="inline-flex items-center px-6 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-xl hover:bg-blue-700 transition-colors shadow-sm">
                            Tampilkan Semua Hari
                        </a>
                    @endif
                </div>
            @endif
        </div>

        {{-- PAGINATION --}}
        @if($dataJadwal->hasPages())
            <div class="mb-8 flex justify-center">
                {{ $dataJadwal->withQueryString()->links('vendor.pagination.tailwind') }}
            </div>
        @endif

    </div>

    <style>
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</x-layout>