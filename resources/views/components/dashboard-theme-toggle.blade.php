{{-- 
SKRIP INI PENTING:
Skrip ini dijalankan segera (tanpa Alpine) untuk MENCEGAH KEDIPAN (FOUC).
Ini akan menimpa logika tema dari app.js dengan membaca 'dashboard_theme'.
--}}
<script>
    (function() {
        // Menggunakan kunci 'dashboard_theme' yang terpisah
        const theme = localStorage.getItem('dashboard_theme') || 'light';
        
        if (theme === 'dark' || (!('dashboard_theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
            if (!('dashboard_theme' in localStorage)) {
                localStorage.setItem('dashboard_theme', 'dark');
            }
        } else {
            document.documentElement.classList.remove('dark');
            if (!('dashboard_theme' in localStorage)) {
                localStorage.setItem('dashboard_theme', 'light');
            }
        }
    })();
</script>

{{-- 
Komponen Alpine ini MENGONTROL PENGGANTIAN TEMA.
Ini terpisah dari skrip di atas, tetapi membaca/menulis ke 'dashboard_theme' yang sama.
--}}
<div x-data="{ 
        // Menggunakan variabel Alpine yang unik
        dashboardTheme: localStorage.getItem('dashboard_theme') || 'light',
        
        toggleDashboardTheme() {
            this.dashboardTheme = (this.dashboardTheme === 'light') ? 'dark' : 'light';
            // Menyimpan ke kunci 'dashboard_theme'
            localStorage.setItem('dashboard_theme', this.dashboardTheme);
            
            if (this.dashboardTheme === 'dark') {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        }
     }" 
     class="flex items-center">
    
    <a href="#" 
       @click.prevent="toggleDashboardTheme()"
       {{-- Menyamakan styling dengan tombol notifikasi di dashboard --}}
       class="p-2 mr-1 text-gray-500 rounded-lg hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600 transition-colors"
       :aria-label="'Ganti ke mode ' + (dashboardTheme === 'light' ? 'gelap' : 'terang')">
        
        {{-- Ikon Matahari (Muncul saat mode gelap) --}}
        <svg x-show="dashboardTheme === 'dark'" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
        </svg>

        {{-- Ikon Bulan (Muncul saat mode terang) --}}
        <svg x-show="dashboardTheme === 'light'" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
        </svg>

        <span class="sr-only">Toggle Dashboard Theme</span>
    </a>
</div>