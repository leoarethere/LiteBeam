<x-dashboard-layout>
    <x-slot:title>
        Dashboard Admin
    </x-slot:title>

    {{-- Konten ini akan otomatis masuk ke dalam <main> dari layout --}}

    <h3 class="text-3xl font-bold text-gray-900 dark:text-white">Dashboard</h3>
    <p class="mt-1 text-gray-500 dark:text-gray-400">Selamat datang kembali, {{ auth()->user()->name }}!</p>

    <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
        <div class="p-6 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Postingan</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $totalPosts }}</p>
                </div>
                <div class="bg-indigo-100 dark:bg-indigo-600/20 text-indigo-600 dark:text-indigo-400 p-3 rounded-lg">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                </div>
            </div>
        </div>
        <div class="p-6 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Pengguna</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $totalUsers }}</p>
                </div>
                <div class="bg-green-100 dark:bg-green-600/20 text-green-600 dark:text-green-400 p-3 rounded-lg">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-2.253M15 19.128v-3.873M15 19.128A9.37 9.37 0 0 1 12.125 21a9.37 9.37 0 0 1-2.875-1.872M15 19.128a9.34 9.34 0 0 1 4.121-2.253c1.117-1.334 1.858-3.055 1.858-4.872a9.337 9.337 0 0 0-1.579-5.223M15 19.128A9.337 9.337 0 0 0 15 12.253v-3.873m0 3.873a9.337 9.337 0 0 0-4.121 2.253M15 12.253a9.337 9.337 0 0 1 2.625-.372M15 12.253a9.337 9.337 0 0 1-2.625-.372m2.625.372a9.337 9.337 0 0 1 2.875 1.872M15 12.253a9.337 9.337 0 0 0 1.579 5.223M15 12.253a9.337 9.337 0 0 0-1.579 5.223m-7.421-3.873a9.337 9.337 0 0 0-4.121-2.253M7.579 16.879a9.337 9.337 0 0 1-2.625.372m2.625-.372a9.337 9.337 0 0 1-2.875-1.872M7.579 16.879a9.337 9.337 0 0 0 4.121 2.253M7.579 16.879a9.34 9.34 0 0 0-4.121-2.253c-1.117-1.334-1.858-3.055-1.858-4.872a9.337 9.337 0 0 1 1.579-5.223M7.579 16.879a9.337 9.337 0 0 1 1.579-5.223m0 0a9.337 9.337 0 0 1-1.579-5.223m7.421 3.873a9.337 9.337 0 0 1 4.121-2.253M12.125 5a9.337 9.337 0 0 0-4.121 2.253A9.337 9.337 0 0 0 3.858 12c0 1.817.74 3.538 1.858 4.872a9.337 9.337 0 0 0 4.121 2.253m2.875-1.872a9.337 9.337 0 0 0 2.875 1.872M12 12v.01M12 12H9"></path></svg>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-4">
            <div class="lg:col-span-2 p-6 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm">
            <h4 class="text-xl font-semibold text-gray-900 dark:text-white">Statistik Pengunjung</h4>
            <div id="visitors-chart" class="mt-4"></div>
        </div>

        <div class="p-6 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm">
            <h4 class="text-xl font-semibold text-gray-900 dark:text-white">Aktivitas Terbaru</h4>
            <ul class="mt-4 space-y-4">
                @forelse ($recentActivities as $activity)
                    <li class="flex items-center">
                        <img class="flex-shrink-0 w-10 h-10 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode($activity->name) }}&background=random&color=fff" alt="{{ $activity->name }}'s avatar">
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ $activity->name }} 
                                <span class="font-normal text-gray-500 dark:text-gray-400">baru saja mendaftar.</span>
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                {{ $activity->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </li>
                @empty
                    <li class="text-center text-sm text-gray-500 dark:text-gray-400">
                        Tidak ada aktivitas terbaru.
                    </li>
                @endforelse
            </ul>
        </div>
    </div>
</x-dashboard-layout>