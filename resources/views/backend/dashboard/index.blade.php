<x-dashboard-layout>
    <x-slot:title>
        Dashboard Admin
    </x-slot:title>

    <h3 class="text-3xl font-bold text-gray-900 dark:text-white">Dashboard</h3>
    <p class="mt-1 text-gray-500 dark:text-gray-400">Selamat datang kembali, {{ auth()->user()->name }}!</p>

    {{-- BARIS 1: KARTU STATISTIK (Hanya Post & User) --}}
    <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
        
        {{-- Card 1: Total Postingan --}}
        <div class="p-6 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Postingan</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $totalPosts }}</p>
                </div>
                <div class="bg-indigo-100 dark:bg-indigo-600/20 text-indigo-600 dark:text-indigo-400 p-3 rounded-lg">
                    {{-- Icon Document --}}
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                </div>
            </div>
        </div>

        {{-- Card 2: Total Pengguna --}}
        <div class="p-6 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Pengguna</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $totalUsers }}</p>
                </div>
                <div class="bg-green-100 dark:bg-green-600/20 text-green-600 dark:text-green-400 p-3 rounded-lg">
                    {{-- Icon User --}}
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
            </div>
        </div>

        {{-- SISA KARTU ANALITIK DIHAPUS AGAR TIDAK ERROR --}}
    </div>

    {{-- BARIS 2: GRAFIK & AKTIVITAS --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-4">
        
        {{-- Grafik Statistik (Menggunakan Data Dummy/Kosong) --}}
        <div class="lg:col-span-2 p-6 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm">
            <h4 class="text-xl font-semibold text-gray-900 dark:text-white">Statistik (Demo)</h4>
            <div id="visitors-chart" class="mt-4 w-full min-h-[350px]"></div>
        </div>

        {{-- Aktivitas Terbaru --}}
        <div class="p-6 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm">
            <h4 class="text-xl font-semibold text-gray-900 dark:text-white">Pengguna Baru</h4>
            <ul class="mt-4 space-y-4">
                @forelse ($recentActivities as $activity)
                    <li class="flex items-center">
                        <img class="flex-shrink-0 w-10 h-10 rounded-full bg-gray-200" 
                             src="https://ui-avatars.com/api/?name={{ urlencode($activity->name) }}&background=random&color=fff" 
                             alt="{{ $activity->name }}">
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ $activity->name }} 
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                {{ $activity->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </li>
                @empty
                    <li class="text-center text-sm text-gray-500 dark:text-gray-400">
                        Belum ada pengguna baru.
                    </li>
                @endforelse
            </ul>
        </div>
    </div>

    {{-- SCRIPT GRAFIK (SAFE MODE) --}}
    <script type="module">
        const initDashboardGraph = () => {
            const chartElement = document.querySelector("#visitors-chart");
            
            if (chartElement && window.ApexCharts) {
                // Menggunakan data dari controller (yang sekarang isinya dummy/0)
                // atau array default [0,0...] jika variable tidak dikirim
                const chartData = @json($visitorStats ?? [10, 20, 15, 25, 30, 20, 15, 25, 30]);

                const options = {
                    series: [{
                        name: "Statistik",
                        data: chartData 
                    }],
                    chart: {
                        type: 'area',
                        height: 350,
                        fontFamily: 'Inter, sans-serif',
                        toolbar: { show: false },
                        zoom: { enabled: false }
                    },
                    dataLabels: { enabled: false },
                    stroke: { curve: 'smooth', width: 3 },
                    fill: {
                        type: "gradient",
                        gradient: {
                            shadeIntensity: 1,
                            opacityFrom: 0.7,
                            opacityTo: 0.9,
                            stops: [0, 90, 100]
                        }
                    },
                    colors: ['#6366F1'], // Warna Indigo Default
                    xaxis: {
                        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep'],
                        axisBorder: { show: false },
                        axisTicks: { show: false }
                    },
                    yaxis: { show: false },
                    grid: {
                        show: true,
                        strokeDashArray: 4,
                        yaxis: { lines: { show: true } }
                    },
                    tooltip: { theme: 'light' }
                };

                const chart = new ApexCharts(chartElement, options);
                chart.render();
            } else {
                setTimeout(initDashboardGraph, 100);
            }
        };

        initDashboardGraph();
    </script>

</x-dashboard-layout>