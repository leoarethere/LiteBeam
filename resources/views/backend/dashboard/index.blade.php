<x-dashboard-layout>
    <x-slot:title>
        Dashboard Admin
    </x-slot:title>

    <div class="mb-6 pt-2">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Dashboard</h1>
        <p class="mt-1 text-gray-500 dark:text-gray-400">Selamat datang kembali, {{ auth()->user()->name }}!</p>
    </div>

    {{-- BARIS 1: KARTU STATISTIK --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        {{-- Card 1: Total Postingan --}}
        <div class="relative overflow-hidden p-6 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Postingan</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ $totalPosts }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Semua artikel</p>
                </div>
                <div class="bg-indigo-100 dark:bg-indigo-600/20 text-indigo-600 dark:text-indigo-400 p-3 rounded-lg">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Card 2: Total Pengguna --}}
        <div class="relative overflow-hidden p-6 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Pengguna</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ $totalUsers }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Pengguna terdaftar</p>
                </div>
                <div class="bg-green-100 dark:bg-green-600/20 text-green-600 dark:text-green-400 p-3 rounded-lg">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Card 3: Postingan Hari Ini --}}
        <div class="relative overflow-hidden p-6 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Hari Ini</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ $todayPosts ?? 0 }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Postingan baru</p>
                </div>
                <div class="bg-purple-100 dark:bg-purple-600/20 text-purple-600 dark:text-purple-400 p-3 rounded-lg">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Card 4: Pengguna Baru Bulan Ini --}}
        <div class="relative overflow-hidden p-6 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Bulan Ini</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ $monthlyUsers ?? 0 }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Pengguna baru</p>
                </div>
                <div class="bg-orange-100 dark:bg-orange-600/20 text-orange-600 dark:text-orange-400 p-3 rounded-lg">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- BARIS 2: GRAFIK & AKTIVITAS --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- Grafik Statistik --}}
        <div class="lg:col-span-2 p-6 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h4 class="text-xl font-semibold text-gray-900 dark:text-white">Statistik Postingan</h4>
                <span class="px-3 py-1 text-xs font-medium text-gray-600 bg-gray-100 dark:bg-gray-700 dark:text-gray-300 rounded-full">9 Bulan Terakhir</span>
            </div>
            <div id="visitors-chart" class="w-full" style="min-height: 350px;"></div>
        </div>

        {{-- Aktivitas Terbaru --}}
        <div class="p-6 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h4 class="text-xl font-semibold text-gray-900 dark:text-white">Pengguna Baru</h4>
                <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </div>
            
            <div class="space-y-4 max-h-[380px] overflow-y-auto">
                @forelse ($recentActivities as $activity)
                    <div class="flex items-center p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200">
                        <img class="flex-shrink-0 w-10 h-10 rounded-full ring-2 ring-gray-200 dark:ring-gray-700" 
                             src="https://ui-avatars.com/api/?name={{ urlencode($activity->name) }}&background=random&color=fff&size=128" 
                             alt="{{ $activity->name }}">
                        <div class="ml-4 flex-1">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ $activity->name }}
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                {{ $activity->email }}
                            </p>
                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">
                                <svg class="w-3 h-3 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $activity->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="flex flex-col items-center justify-center py-8 text-center">
                        <svg class="w-16 h-16 text-gray-300 dark:text-gray-600 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Belum ada pengguna baru.
                        </p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- SCRIPT GRAFIK --}}
    @push('scripts')
    <script type="module">
        document.addEventListener('DOMContentLoaded', function() {
            const initDashboardGraph = () => {
                const chartElement = document.querySelector("#visitors-chart");
                
                if (chartElement && typeof ApexCharts !== 'undefined') {
                    const chartData = [0, 0, 0, 0, 0, 0, 0, 0, 0];

                    const options = {
                        series: [{
                            name: "Postingan",
                            data: chartData 
                        }],
                        chart: {
                            type: 'area',
                            height: 350,
                            fontFamily: 'Inter, sans-serif',
                            toolbar: { show: false },
                            zoom: { enabled: false }
                        },
                        dataLabels: { 
                            enabled: false 
                        },
                        stroke: { 
                            curve: 'smooth', 
                            width: 3 
                        },
                        fill: {
                            type: "gradient",
                            gradient: {
                                shadeIntensity: 1,
                                opacityFrom: 0.4,
                                opacityTo: 0.1,
                                stops: [0, 90, 100]
                            }
                        },
                        colors: ['#6366F1'],
                        xaxis: {
                            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep'],
                            labels: {
                                style: {
                                    colors: '#9CA3AF',
                                    fontSize: '12px'
                                }
                            },
                            axisBorder: { show: false },
                            axisTicks: { show: false }
                        },
                        yaxis: { 
                            show: true,
                            labels: {
                                style: {
                                    colors: '#9CA3AF',
                                    fontSize: '12px'
                                }
                            }
                        },
                        grid: {
                            show: true,
                            strokeDashArray: 4,
                            borderColor: '#E5E7EB',
                            yaxis: { lines: { show: true } },
                            xaxis: { lines: { show: false } }
                        },
                        tooltip: { 
                            theme: 'light',
                            x: {
                                format: 'MMM'
                            }
                        }
                    };

                    const chart = new ApexCharts(chartElement, options);
                    chart.render();
                } else {
                    setTimeout(initDashboardGraph, 100);
                }
            };

            initDashboardGraph();
        });
    </script>
    @endpush

</x-dashboard-layout>