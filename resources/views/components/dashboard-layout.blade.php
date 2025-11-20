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
    
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />

    <style>
        [x-cloak] { display: none !important; }
        .turbo-loading { opacity: 0.7; pointer-events: none; }
        .notification-banner { transition: all 0.5s cubic-bezier(0.68, -0.55, 0.27, 1.55); }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900">

    <div x-data="dashboardState()" 
         x-init="init()"
         class="antialiased">
        
        {{-- [BARU] WADAH KHUSUS UNTUK TURBO STREAM --}}
        {{-- Sesuai video: Kita butuh ID target untuk di-update --}}
        <div id="flash-container"></div>

        {{-- Komponen notifikasi lama (Trigger) tetap biarkan untuk fallback --}}
        <x-notification-trigger />
        <x-status-modal />

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
        
        {{-- UI Notifikasi (Toast) --}}
        <div 
            x-show="notificationOpen"
            x-transition:enter="notification-banner transform ease-out duration-300 transition"
            x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
            x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
            x-transition:leave="notification-banner transition ease-in duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            x-cloak
            class="fixed top-20 right-4 z-50 w-full max-w-sm p-4 rounded-lg shadow-lg border-l-4"
            :class="{
                'bg-green-50 border-green-500 dark:bg-green-900/20': notificationType === 'success',
                'bg-red-50 border-red-500 dark:bg-red-900/20': notificationType === 'error'
            }"
            role="alert">
            
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    {{-- Icon Success --}}
                    <svg x-show="notificationType === 'success'" class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    {{-- Icon Error --}}
                    <svg x-show="notificationType === 'error'" class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                
                <div class="ml-3 text-sm font-medium flex-1" 
                    :class="{
                        'text-green-800 dark:text-green-300': notificationType === 'success',
                        'text-red-800 dark:text-red-300': notificationType === 'error'
                    }"
                    x-text="notificationMessage">
                </div>
                
                <button type="button" 
                    @click="notificationOpen = false" 
                    class="ml-auto -mx-1.5 -my-1.5 rounded-lg p-1.5 inline-flex items-center justify-center h-8 w-8 transition-colors"
                    :class="{
                        'text-green-500 hover:bg-green-200 dark:hover:bg-green-800/50': notificationType === 'success',
                        'text-red-500 hover:bg-red-200 dark:hover:bg-red-800/50': notificationType === 'error'
                    }">
                    <span class="sr-only">Tutup</span>
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
                // --- State Sidebar (Existing) ---
                isSidebarOpen: window.innerWidth >= 768,
                
                // --- State Toast Notification (Existing) ---
                notificationOpen: false,
                notificationMessage: '',
                notificationType: 'success',

                // --- 👇 STATE BARU UNTUK MODAL POPUP ---
                modalOpen: false,
                modalType: 'success', // 'success' or 'error'
                modalTitle: '',
                modalMessage: '',

                init() {
                    console.log('🏠 Dashboard initialized');
                    this.setupResizeHandler();
                    this.checkForFlashMessages();

                    document.addEventListener('turbo:load', () => this.checkForFlashMessages());
                    document.addEventListener('turbo:render', () => this.checkForFlashMessages());
                },

                checkForFlashMessages() {
                    // 1. Cek Toast Notification (Logika Lama)
                    const trigger = document.getElementById('notification-trigger');
                    if (trigger) {
                        const message = trigger.getAttribute('data-message');
                        const type = trigger.getAttribute('data-type');
                        if (message) {
                            this.showNotification(message, type);
                            trigger.remove();
                        }
                    }

                    // 👇 2. Cek Modal Popup (Logika Baru)
                    // Kita akan mencari elemen meta/hidden khusus untuk modal jika ada
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

                // Fungsi Menampilkan Toast (Existing)
                showNotification(message, type) {
                    this.notificationMessage = message;
                    this.notificationType = type;
                    this.notificationOpen = true;
                    setTimeout(() => { this.notificationOpen = false; }, 4000);
                },

                // 👇 Fungsi Menampilkan Modal (Baru)
                showModal(title, message, type = 'success') {
                    this.modalTitle = title;
                    this.modalMessage = message;
                    this.modalType = type;
                    this.modalOpen = true;
                    // Tidak ada setTimeout, user harus klik OK
                },

                isMobile() { return window.innerWidth < 768; },
                closeSidebar() { if (this.isMobile()) { this.isSidebarOpen = false; } },
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