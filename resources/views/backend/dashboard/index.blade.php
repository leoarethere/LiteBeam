<x-dashboard-layout>
    <x-slot:title>
        Dashboard Admin
    </x-slot:title>

    {{-- Header Halaman --}}
    <div class="mb-6 pt-2">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">Dashboard Overview</h1>
        <p class="mt-1 text-sm sm:text-base text-gray-500 dark:text-gray-400">
            Selamat datang kembali, {{ auth()->user()->name }}! Berikut ringkasan data website Anda.
        </p>
    </div>

    {{-- GRID KARTU DETAIL DATA WEBSITE --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8">
        
        {{-- 1. Total Postingan --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5 flex items-center justify-between transition-all hover:shadow-md border-l-4 border-l-indigo-500">
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Postingan</p>
                <p class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $totalPosts }}</p>
                <p class="text-xs text-green-600 mt-1 font-medium">+{{ $todayPosts }} hari ini</p>
            </div>
            <div class="flex-shrink-0 p-3 bg-indigo-50 text-indigo-600 dark:bg-indigo-900/20 dark:text-indigo-400 rounded-lg">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                </svg>
            </div>
        </div>

        {{-- 2. Total Penyiaran (Broadcast) --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5 flex items-center justify-between transition-all hover:shadow-md border-l-4 border-l-red-500">
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Program Siaran</p>
                <p class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $totalBroadcasts }}</p>
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Video & Live</p>
            </div>
            <div class="flex-shrink-0 p-3 bg-red-50 text-red-600 dark:bg-red-900/20 dark:text-red-400 rounded-lg">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                </svg>
            </div>
        </div>

        {{-- 3. Jadwal Acara --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5 flex items-center justify-between transition-all hover:shadow-md border-l-4 border-l-yellow-500">
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Jadwal Acara</p>
                <p class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $totalJadwal }}</p>
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Agenda Tayang</p>
            </div>
            <div class="flex-shrink-0 p-3 bg-yellow-50 text-yellow-600 dark:bg-yellow-900/20 dark:text-yellow-400 rounded-lg">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
        </div>

        {{-- 4. Info Magang --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5 flex items-center justify-between transition-all hover:shadow-md border-l-4 border-l-blue-500">
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Info Magang</p>
                <p class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $totalMagang }}</p>
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Lowongan aktif</p>
            </div>
            <div class="flex-shrink-0 p-3 bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-400 rounded-lg">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>
        </div>

        {{-- 5. Info Kunjungan --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5 flex items-center justify-between transition-all hover:shadow-md border-l-4 border-l-teal-500">
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Info Kunjungan</p>
                <p class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $totalKunjungan }}</p>
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Data tamu</p>
            </div>
            <div class="flex-shrink-0 p-3 bg-teal-50 text-teal-600 dark:bg-teal-900/20 dark:text-teal-400 rounded-lg">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
        </div>

        {{-- 6. Banner Aktif --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5 flex items-center justify-between transition-all hover:shadow-md border-l-4 border-l-pink-500">
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Banner Slider</p>
                <p class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $totalBanners }}</p>
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Gambar beranda</p>
            </div>
            <div class="flex-shrink-0 p-3 bg-pink-50 text-pink-600 dark:bg-pink-900/20 dark:text-pink-400 rounded-lg">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
        </div>

        {{-- 7. Total Pengguna (Digeser ke sini) --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5 flex items-center justify-between transition-all hover:shadow-md border-l-4 border-l-gray-500">
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total Pengguna</p>
                <p class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $totalUsers }}</p>
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Akun admin</p>
            </div>
            <div class="flex-shrink-0 p-3 bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </div>
        </div>
        
    </div>

    {{-- BARIS 2: AKTIVITAS TERBARU (Full Width karena chart dihapus) --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm p-5 sm:p-6">
        <div class="flex items-center justify-between mb-4">
            <h4 class="text-lg font-bold text-gray-900 dark:text-white">Pengguna Baru / Aktivitas</h4>
            <a href="{{ route('dashboard.users.index') }}" class="text-sm text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 font-medium">
                Kelola Pengguna &rarr;
            </a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-4 py-3">Nama</th>
                        <th scope="col" class="px-4 py-3">Email</th>
                        <th scope="col" class="px-4 py-3">Bergabung</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recentActivities as $activity)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-4 py-3 font-medium text-gray-900 dark:text-white flex items-center gap-3">
                                <img class="w-8 h-8 rounded-full" 
                                     src="https://ui-avatars.com/api/?name={{ urlencode($activity->name) }}&background=random&color=fff" 
                                     alt="{{ $activity->name }}">
                                {{ $activity->name }}
                            </td>
                            <td class="px-4 py-3">
                                {{ $activity->email }}
                            </td>
                            <td class="px-4 py-3">
                                {{ $activity->created_at->diffForHumans() }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-4 py-8 text-center text-gray-500">
                                Belum ada data pengguna.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</x-dashboard-layout>