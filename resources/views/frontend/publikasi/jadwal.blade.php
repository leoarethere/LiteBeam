<x-layout>
    <x-slot:title>
        {{ $title ?? 'Jadwal Acara' }}
        @if(request('day'))
            - {{ ucwords(str_replace('-', ' ', request('day'))) }}
        @endif
    </x-slot:title>

    {{-- KONTAINER UTAMA --}}
    <div class="px-4 sm:px-6 lg:px-8">

        {{-- HERO SECTION (Disamakan dengan Siaran.blade.php) --}}
        <div class="relative rounded-3xl overflow-hidden mb-8 bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 dark:from-blue-900 dark:via-blue-950 dark:to-indigo-950 shadow-xl">
            
            {{-- Pattern Grid Background --}}
            <div class="absolute inset-0 bg-grid-white/[0.03] bg-[size:24px_24px] [mask-image:radial-gradient(ellipse_at_center,black_40%,transparent_100%)]"></div>
            
            <div class="relative px-6 py-12 lg:px-12 lg:py-16 text-center">
                <div class="max-w-4xl mx-auto">
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-4 drop-shadow-md">
                        Jadwal Acara TVRI
                    </h1>
                    <p class="text-blue-100 text-lg max-w-2xl mx-auto mb-8">
                        Simak jadwal tayangan edukatif, informatif, dan menghibur pilihan kami hari ini dan hari-hari mendatang.
                    </p>

                    {{-- FILTER & SEARCH SECTION (Diintegrasikan ke dalam Hero agar rapi) --}}
                    <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-6 shadow-lg">
                        <div class="flex flex-col lg:flex-row justify-between items-center gap-6">
                            
                            {{-- Filter Hari (Scrollable Horizontal) --}}
                            <div class="w-full flex justify-center items-center pb-2 lg:pb-0 scrollbar-hide">
                                <div class="flex gap-2">
                                    <a href="{{ route('jadwal.index') }}" 
                                    class="px-5 py-2.5 rounded-lg text-sm font-medium transition-all duration-300 whitespace-nowrap 
                                    {{ !request('day') ? 'bg-white text-blue-700 shadow-md scale-105' : 'bg-blue-800/40 text-blue-100 hover:bg-blue-700/50 hover:text-white' }}">
                                        Hari Ini
                                    </a>
                                    @foreach(['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu'] as $day)
                                        <a href="{{ route('jadwal.index', ['day' => $day]) }}" 
                                        class="px-5 py-2.5 rounded-lg text-sm font-medium transition-all duration-300 whitespace-nowrap capitalize
                                        {{ request('day') == $day ? 'bg-white text-blue-700 shadow-md scale-105' : 'bg-blue-800/40 text-blue-100 hover:bg-blue-700/50 hover:text-white' }}">
                                            {{ $day }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>

                        </div>
                    </div>
                    {{-- END FILTER --}}

                </div>
            </div>
        </div>

        {{-- KONTEN JADWAL --}}
        <div class="mx-auto">
            @if($jadwalAcaras->count() > 0)
                <div class="space-y-8">
                    @php
                        // Grouping berdasarkan hari agar tampilan lebih terstruktur
                        $groupedJadwal = $jadwalAcaras->groupBy('day');
                    @endphp

                    @foreach($groupedJadwal as $day => $schedules)
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                            
                            {{-- Header Hari --}}
                            <div class="bg-gray-50 dark:bg-gray-700/50 px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center gap-3">
                                <div class="p-2 bg-blue-100 dark:bg-blue-900/30 rounded-lg text-blue-600 dark:text-blue-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <h2 class="text-xl font-bold text-gray-900 dark:text-white capitalize">
                                    {{ $day }}
                                </h2>
                            </div>

                            {{-- List Jadwal --}}
                            <div class="divide-y divide-gray-100 dark:divide-gray-700">
                                @foreach($schedules as $schedule)
                                    <div class="group p-6 hover:bg-blue-50/50 dark:hover:bg-gray-700/50 transition-colors duration-200 flex flex-col sm:flex-row gap-6 items-start">
                                        
                                        {{-- Kolom Waktu --}}
                                        <div class="sm:w-32 flex-shrink-0">
                                            <div class="inline-flex flex-col items-center justify-center px-4 py-2 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-xl font-mono text-sm font-bold border border-blue-200 dark:border-blue-800">
                                                <span>{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}</span>
                                                <span class="text-xs font-normal text-blue-500 dark:text-blue-400 my-0.5">s/d</span>
                                                <span>{{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}</span>
                                            </div>
                                            <div class="mt-2 text-center">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                    {{ $schedule->status == 'live' ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300 animate-pulse' : 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400' }}">
                                                    {{ $schedule->status == 'live' ? '● LIVE' : 'Recorded' }}
                                                </span>
                                            </div>
                                        </div>

                                        {{-- Kolom Info Program --}}
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-start justify-between gap-4">
                                                <div>
                                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white group-hover:text-blue-700 dark:group-hover:text-blue-400 transition-colors mb-1">
                                                        {{ $schedule->program_name }}
                                                    </h3>
                                                    <div class="text-sm text-gray-500 dark:text-gray-400 line-clamp-2 mb-3">
                                                        {{ $schedule->description ?? 'Tidak ada deskripsi untuk program ini.' }}
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            {{-- Footer Item (Kategori & Durasi) --}}
                                            <div class="flex items-center gap-4 text-xs text-gray-500 dark:text-gray-400">
                                                <div class="flex items-center gap-1.5">
                                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7A2 2 0 0121 12v5a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2h3m0 0l-3 3m0 0l3 3m-3-3h5"></path></svg>
                                                    <span>Program Hiburan</span> {{-- Bisa diganti dinamis jika ada kolom kategori --}}
                                                </div>
                                                <div class="flex items-center gap-1.5">
                                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                    <span>
                                                        {{ \Carbon\Carbon::parse($schedule->start_time)->diffInMinutes(\Carbon\Carbon::parse($schedule->end_time)) }} Menit
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

            @else
                {{-- EMPTY STATE (Disamakan dengan Siaran.blade.php) --}}
                <div class="text-center py-16 bg-gray-50 dark:bg-gray-800/50 rounded-xl border-2 border-dashed border-gray-300 dark:border-gray-700">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-700 mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Jadwal Tidak Ditemukan</h3>
                    <p class="text-gray-500 dark:text-gray-400 max-w-md mx-auto mb-8">
                        @if(request('day'))
                            Tidak ada jadwal acara untuk hari <strong>{{ ucwords(str_replace('-', ' ', request('day'))) }}</strong>.
                        @elseif(request('search'))
                            Tidak ada program yang cocok dengan kata kunci "<strong>{{ request('search') }}</strong>".
                        @else
                            Belum ada jadwal acara yang tersedia saat ini.
                        @endif
                    </p>
                    
                    @if(request('search') || request('day'))
                        <a href="{{ route('jadwal.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition-all duration-200 shadow-md hover:shadow-lg">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                            Tampilkan Semua Jadwal
                        </a>
                    @endif
                </div>
            @endif
        </div>

        {{-- PAGINATION --}}
        @if ($jadwalAcaras->hasPages())
            <div class="my-12">
                {{ $jadwalAcaras->links('vendor.pagination.tailwind') }}
            </div>
        @endif

    </div>

    {{-- Custom Styles --}}
    <style>
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
        .bg-grid-white { background-image: linear-gradient(to right, rgba(255, 255, 255, 0.1) 1px, transparent 1px), linear-gradient(to bottom, rgba(255, 255, 255, 0.1) 1px, transparent 1px); }
    </style>
</x-layout>