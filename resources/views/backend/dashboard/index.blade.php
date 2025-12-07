<x-dashboard-layout>
    <x-slot:title>
        Dashboard Admin
    </x-slot:title>

    {{-- Header Halaman --}}
    <div class="mb-6 pt-2">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">Dashboard</h1>
        <p class="mt-1 text-sm sm:text-base text-gray-500 dark:text-gray-400">
            Selamat datang kembali, {{ auth()->user()->name }}!
        </p>
    </div>

    {{-- BARIS 1: KARTU STATISTIK --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6 sm:mb-8">
        
        {{-- Card 1: Total Postingan --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5 flex items-center justify-between transition-all hover:shadow-md">
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total Postingan</p>
                <p class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $totalPosts }}</p>
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1 truncate">Semua artikel terbit</p>
            </div>
            <div class="flex-shrink-0 p-3 bg-indigo-50 text-indigo-600 dark:bg-indigo-900/20 dark:text-indigo-400 rounded-lg">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                </svg>
            </div>
        </div>

        {{-- Card 2: Total Pengguna --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5 flex items-center justify-between transition-all hover:shadow-md">
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total Pengguna</p>
                <p class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $totalUsers }}</p>
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1 truncate">Akun terdaftar</p>
            </div>
            <div class="flex-shrink-0 p-3 bg-green-50 text-green-600 dark:bg-green-900/20 dark:text-green-400 rounded-lg">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </div>
        </div>

        {{-- Card 3: Postingan Hari Ini --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5 flex items-center justify-between transition-all hover:shadow-md">
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Hari Ini</p>
                <p class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $todayPosts ?? 0 }}</p>
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1 truncate">Postingan baru</p>
            </div>
            <div class="flex-shrink-0 p-3 bg-purple-50 text-purple-600 dark:bg-purple-900/20 dark:text-purple-400 rounded-lg">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>

        {{-- Card 4: Pengguna Baru Bulan Ini --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5 flex items-center justify-between transition-all hover:shadow-md">
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Bulan Ini</p>
                <p class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $monthlyUsers ?? 0 }}</p>
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1 truncate">Pengguna baru</p>
            </div>
            <div class="flex-shrink-0 p-3 bg-orange-50 text-orange-600 dark:bg-orange-900/20 dark:text-orange-400 rounded-lg">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                </svg>
            </div>
        </div>
    </div>

    {{-- BARIS 2: GRAFIK & AKTIVITAS --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- Grafik Statistik --}}
        <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm p-5 sm:p-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-4">
                <h4 class="text-lg font-bold text-gray-900 dark:text-white">Statistik Kunjungan</h4>
                <span class="px-3 py-1 text-xs font-medium text-gray-600 bg-gray-100 dark:bg-gray-700 dark:text-gray-300 rounded-full self-start sm:self-auto">
                    9 Bulan Terakhir
                </span>
            </div>
            
            {{-- Container Chart Responsif --}}
            <div class="relative w-full h-[300px] sm:h-[350px]">
                <div id="visitors-chart" class="w-full h-full"></div>
            </div>
        </div>

        {{-- Aktivitas Terbaru --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm p-5 sm:p-6 flex flex-col h-full">
            <div class="flex items-center justify-between mb-4">
                <h4 class="text-lg font-bold text-gray-900 dark:text-white">Pengguna Baru</h4>
                <a href="{{ route('dashboard.users.index') }}" class="text-sm text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 font-medium">
                    Lihat Semua
                </a>
            </div>
            
            <div class="flex-1 overflow-y-auto pr-1 space-y-4 max-h-[350px] scrollbar-thin scrollbar-thumb-gray-300 dark:scrollbar-thumb-gray-600">
                @forelse ($recentActivities as $activity)
                    <div class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                        <img class="w-10 h-10 rounded-full object-cover ring-2 ring-gray-100 dark:ring-gray-700 flex-shrink-0" 
                             src="https://ui-avatars.com/api/?name={{ urlencode($activity->name) }}&background=random&color=fff&size=128" 
                             alt="{{ $activity->name }}">
                        
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-900 dark:text-white truncate">
                                {{ $activity->name }}
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                                {{ $activity->email }}
                            </p>
                        </div>
                        
                        <div class="text-right flex-shrink-0">
                            <span class="text-xs text-gray-400 dark:text-gray-500 whitespace-nowrap">
                                {{ $activity->created_at->diffForHumans(null, true) }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="flex flex-col items-center justify-center h-full py-8 text-center text-gray-500 dark:text-gray-400">
                        <svg class="w-12 h-12 mb-3 text-gray-300 dark:text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <p class="text-sm">Belum ada pengguna baru.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- SCRIPT GRAFIK --}}
    @push('scripts')
    <script type="module">
        document.addEventListener('DOMContentLoaded', function() {
            const chartElement = document.querySelector("#visitors-chart");
            
            if (chartElement && typeof ApexCharts !== 'undefined') {
                // Data Dummy (Bisa diganti dengan data dari controller)
                const chartData = [30, 40, 35, 50, 49, 60, 70, 91, 125]; 
                const chartCategories = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep'];

                const isDarkMode = document.documentElement.classList.contains('dark');
                
                const options = {
                    series: [{
                        name: "Kunjungan",
                        data: chartData 
                    }],
                    chart: {
                        type: 'area',
                        height: '100%', 
                        width: '100%',
                        fontFamily: 'Inter, sans-serif',
                        background: 'transparent',
                        toolbar: { show: false },
                        zoom: { enabled: false }
                    },
                    colors: ['#3B82F6'], // Blue-500
                    fill: {
                        type: "gradient",
                        gradient: {
                            shadeIntensity: 1,
                            opacityFrom: 0.45,
                            opacityTo: 0.05,
                            stops: [0, 100]
                        }
                    },
                    dataLabels: { enabled: false },
                    stroke: {
                        curve: 'smooth',
                        width: 3
                    },
                    xaxis: {
                        categories: chartCategories,
                        labels: {
                            style: {
                                colors: isDarkMode ? '#9CA3AF' : '#6B7280',
                                fontSize: '12px'
                            }
                        },
                        axisBorder: { show: false },
                        axisTicks: { show: false }
                    },
                    yaxis: {
                        labels: {
                            style: {
                                colors: isDarkMode ? '#9CA3AF' : '#6B7280',
                                fontSize: '12px'
                            }
                        }
                    },
                    grid: {
                        show: true,
                        borderColor: isDarkMode ? '#374151' : '#E5E7EB',
                        strokeDashArray: 4,
                        padding: { top: 0, right: 0, bottom: 0, left: 10 }
                    },
                    tooltip: {
                        theme: isDarkMode ? 'dark' : 'light',
                    }
                };

                const chart = new ApexCharts(chartElement, options);
                chart.render();
                
                // Update chart on resize & theme toggle logic could be added here
            }
        });
    </script>
    @endpush

</x-dashboard-layout>