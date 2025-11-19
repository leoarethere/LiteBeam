<x-dashboard-layout>
    <x-slot:title>
        Dashboard Admin
    </x-slot:title>

    <h3 class="text-3xl font-bold text-gray-900 dark:text-white">Dashboard</h3>
    <p class="mt-1 text-gray-500 dark:text-gray-400">Selamat datang kembali, {{ auth()->user()->name }}!</p>

    {{-- BARIS 1: KARTU STATISTIK UTAMA --}}
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

        {{-- Card 3: Total Kunjungan (DARI PACKAGE) --}}
        <div class="p-6 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Kunjungan</p>
                    {{-- Menggunakan variabel baru --}}
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $totalVisitors ?? 0 }}</p>
                </div>
                <div class="bg-blue-100 dark:bg-blue-600/20 text-blue-600 dark:text-blue-400 p-3 rounded-lg">
                    {{-- Icon Eye/Visit --}}
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Card 4: Pengunjung Unik (DARI PACKAGE) --}}
        <div class="p-6 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Pengunjung Unik</p>
                    {{-- Menggunakan variabel baru --}}
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $uniqueVisitors ?? 0 }}</p>
                </div>
                <div class="bg-purple-100 dark:bg-purple-600/20 text-purple-600 dark:text-purple-400 p-3 rounded-lg">
                    {{-- Icon Fingerprint/Unique --}}
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.2-2.873.571-4.222" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- BARIS 2: GRAFIK & AKTIVITAS --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-4">
        
        {{-- Grafik Statistik --}}
        <div class="lg:col-span-2 p-6 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm">
            <h4 class="text-xl font-semibold text-gray-900 dark:text-white">Tren Pengunjung (9 Bulan Terakhir)</h4>
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

    {{-- SCRIPT KHUSUS GRAFIK --}}
    <script type="module">
        const initDashboardGraph = () => {
            const chartElement = document.querySelector("#visitors-chart");
            
            if (chartElement && window.ApexCharts) {
                // Ambil data dari Controller (dikirim lewat blade sebagai JSON)
                // Jika kosong, gunakan array default nol
                const chartData = @json($visitorStats ?? [0,0,0,0,0,0,0,0,0]);

                const options = {
                    series: [{
                        name: "Kunjungan",
                        data: chartData // Gunakan data asli
                    }],
                    chart: {
                        type: 'area', // Ganti ke area agar lebih cantik
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
                    colors: ['#10B981'], // Warna Emerald/Green
                    xaxis: {
                        // Label sumbu X (Sederhana saja untuk contoh)
                        categories: ['M-9', 'M-8', 'M-7', 'M-6', 'M-5', 'M-4', 'M-3', 'M-2', 'Bulan Ini'],
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