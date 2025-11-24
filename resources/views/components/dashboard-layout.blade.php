<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="turbo-visit-control" content="reload">
    <title>{{ $title ?? 'Dashboard Admin' }}</title>
    
    @vite([
        'resources/css/app.css', 
        'resources/js/app.js', 
        'resources/js/dashboard.js' 
    ])
    
    {{-- 👇 TEMPELKAN KODE GOOGLE FONTS BARU DI SINI --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Google+Sans+Flex:opsz,wght@6..144,1..1000&display=swap" rel="stylesheet">

    <style>
        [x-cloak] { display: none !important; }
        .turbo-loading { opacity: 0.7; pointer-events: none; }
        .notification-banner { transition: all 0.5s cubic-bezier(0.68, -0.55, 0.27, 1.55); }

        .google-sans-flex-<uniquifier> {
        font-family: "Google Sans Flex", sans-serif;
        font-optical-sizing: auto;
        font-weight: <weight>;
        font-style: normal;
        font-variation-settings:
            "slnt" 0,
            "wdth" 100,
            "GRAD" 0,
            "ROND" 0;
        }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900">

    <div x-data="dashboardState()" 
         x-init="init()"
         class="antialiased">

        {{-- 1. WADAH UNTUK TURBO STREAM --}}
        <div id="flash-container"></div>

        {{-- 2. KOMPONEN MODAL PINTAR --}}
        <x-status-modal />

        {{-- 3. TRIGGER UNTUK NOTIFIKASI TOAST --}}
        <x-notification-trigger />

        <x-dashboard-navbar />
        <x-sidebar />

        {{-- Backdrop untuk Mobile --}}
        <div x-show="isSidebarOpen && isMobile()" 
            x-transition:enter="transition-opacity ease-linear duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="closeSidebar()"
            class="fixed inset-0 z-30 bg-gray-900/50 md:hidden"
            style="display: none;">
        </div>
        
        {{-- UI NOTIFIKASI TOAST --}}
        <div 
            x-show="notificationOpen"
            x-transition:enter="notification-banner transform ease-out duration-300 transition"
            x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
            x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
            x-transition:leave="notification-banner transition ease-in duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            x-cloak
            class="fixed top-20 right-4 z-50 w-full max-w-sm p-4 rounded-lg shadow-lg border"
            :class="{
                'bg-green-100 border-green-300 text-green-700 dark:bg-green-900/20 dark:border-green-700 dark:text-green-300': notificationType === 'success',
                'bg-red-100 border-red-300 text-red-700 dark:bg-red-900/20 dark:border-red-700 dark:text-red-300': notificationType === 'error'
            }"
            role="alert">
            <div class="flex items-start">
                {{-- Ikon --}}
                <div class="flex-shrink-0">
                    <svg x-show="notificationType === 'success'" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <svg x-show="notificationType === 'error'" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                {{-- Pesan --}}
                <div class="ml-3 text-sm font-medium" x-text="notificationMessage"></div>
                {{-- Tombol Tutup --}}
                <button type="button" 
                    @click="notificationOpen = false" 
                    class="ml-auto -mx-1.5 -my-1.5 rounded-lg p-1.5 inline-flex h-8 w-8 transition-colors duration-200"
                    :class="{
                        'bg-green-100 text-green-500 hover:bg-green-200 dark:bg-green-900/30 dark:text-green-400 dark:hover:bg-green-900/50': notificationType === 'success',
                        'bg-red-100 text-red-500 hover:bg-red-200 dark:bg-red-900/30 dark:text-red-400 dark:hover:bg-red-900/50': notificationType === 'error'
                    }">
                    <span class="sr-only">Close</span>
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        </div>

        <main class="p-4 md:p-6 min-h-screen transition-all duration-300 ease-out" 
            :class="{
                'md:ml-64': isSidebarOpen && !isMobile(), 
                'md:ml-20': !isSidebarOpen && !isMobile()
            }" 
            style="padding-top: 5.5rem;">
            {{ $slot }}
        </main>

        <footer class="bg-gray-900 dark:bg-gray-950 border-t border-white/10 transition-all duration-300 ease-out"
                :class="{ 
                    'md:ml-64': isSidebarOpen && !isMobile(), 
                    'md:ml-20': !isSidebarOpen && !isMobile() 
                }">
            <x-dashboard-footer />
        </footer>

    </div>

    <script>
        function dashboardState() {
            return {
                // --- STATE SIDEBAR ---
                isSidebarOpen: window.innerWidth >= 768,
                
                // --- STATE TOAST NOTIFICATION ---
                notificationOpen: false,
                notificationMessage: '',
                notificationType: 'success',

                // --- STATE MODAL POPUP ---
                modalOpen: false,
                modalType: 'success',
                modalTitle: '',
                modalMessage: '',

                init() {
                    console.log('🏠 Dashboard initialized (Enhanced Turbo Support)');
                    this.setupResizeHandler();
                    
                    // Cek pesan setiap kali init() dipanggil (termasuk setelah Turbo render)
                    this.checkForFlashMessages();

                    // Event listeners untuk Turbo
                    document.addEventListener('turbo:load', () => {
                        console.log('🔄 Turbo load detected, checking for flash messages...');
                        this.checkForFlashMessages();
                    });
                    
                    document.addEventListener('turbo:render', () => {
                        console.log('🎨 Turbo render detected, checking for flash messages...');
                        this.checkForFlashMessages();
                    });
                },

                checkForFlashMessages() {
                    // 1. Cek Toast Notification
                    const toastTrigger = document.getElementById('notification-trigger');
                    if (toastTrigger) {
                        const message = toastTrigger.getAttribute('data-message');
                        const type = toastTrigger.getAttribute('data-type');
                        
                        if (message) {
                            this.showNotification(message, type);
                            toastTrigger.remove(); // Hapus elemen agar tidak diproses dua kali
                        }
                    }

                    // 2. Cek Modal Popup
                    const modalTrigger = document.getElementById('modal-trigger');
                    if (modalTrigger) {
                        const title = modalTrigger.getAttribute('data-title');
                        const message = modalTrigger.getAttribute('data-message');
                        const type = modalTrigger.getAttribute('data-type');
                        
                        if (message) {
                            this.showModal(title, message, type);
                            modalTrigger.remove();
                        }
                    }
                },

                // Fungsi Menampilkan Toast
                showNotification(message, type) {
                    this.notificationMessage = message;
                    this.notificationType = type;
                    this.notificationOpen = true;
                    
                    setTimeout(() => {
                        this.notificationOpen = false;
                    }, 4000);
                },

                // Fungsi Menampilkan Modal
                showModal(title, message, type = 'success') {
                    this.modalTitle = title;
                    this.modalMessage = message;
                    this.modalType = type;
                    this.modalOpen = true;
                    // Tidak ada setTimeout, user harus klik OK
                },

                isMobile() { 
                    return window.innerWidth < 768; 
                },
                
                closeSidebar() { 
                    if (this.isMobile()) { 
                        this.isSidebarOpen = false; 
                    } 
                },
                
                setupResizeHandler() {
                    let resizeTimeout;
                    window.addEventListener('resize', () => {
                        clearTimeout(resizeTimeout);
                        resizeTimeout = setTimeout(() => {
                            this.isSidebarOpen = window.innerWidth >= 768;
                        }, 100);
                    });
                }
            }
        }
    </script>
</body>
</html>