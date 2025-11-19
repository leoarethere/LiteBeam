{{-- ================================================================
    SKRIP PENCEGAH KEDIPAN (FOUC FIX)
    Dijalankan segera untuk mengatur tema sebelum halaman render.
    Tidak bergantung pada Alpine.js atau app.js.
================================================================ --}}
<script>
    (function() {
        let theme = localStorage.getItem('theme');

        // Jika belum ada, cek preferensi sistem
        if (!theme) {
            theme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            localStorage.setItem('theme', theme);
        }

        // Terapkan class sesuai tema
        if (theme === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    })();
</script>

{{-- ================================================================
    KOMPONEN INTERAKTIF ALPINE.JS
    Digunakan untuk MENGGANTI tema saat ikon diklik.
================================================================ --}}
<div 
    x-data="{
        theme: localStorage.getItem('theme') || 'light',
        toggleTheme() {
            this.theme = (this.theme === 'dark') ? 'light' : 'dark';
            localStorage.setItem('theme', this.theme);
            document.documentElement.classList.toggle('dark', this.theme === 'dark');
        }
    }" 
    class="flex items-center"
>
    <button 
        @click="toggleTheme" 
        class="p-3 rounded-lg w-12 h-12 flex items-center justify-center 
               text-gray-700 dark:text-yellow-300 
               bg-gray-200 dark:bg-gray-800 
               hover:bg-gray-300 dark:hover:bg-gray-700 
               transition-colors duration-300 ease-in-out shadow-lg border border-gray-300 dark:border-gray-600"
    >
        <!-- Ikon Matahari -->
        <svg x-show="theme === 'light'" xmlns="http://www.w3.org/2000/svg" 
             class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                  d="M12 3v2m0 14v2m9-9h-2M5 12H3m15.364-6.364l-1.414 1.414M6.05 17.95l-1.414 1.414M17.95 17.95l1.414 1.414M6.05 6.05L4.636 4.636M12 7a5 5 0 100 10 5 5 0 000-10z" />
        </svg>

        <!-- Ikon Bulan -->
        <svg x-show="theme === 'dark'" xmlns="http://www.w3.org/2000/svg" 
             class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
            <path d="M21 12.79A9 9 0 1111.21 3a7 7 0 009.79 9.79z"/>
        </svg>
    </button>
</div>
