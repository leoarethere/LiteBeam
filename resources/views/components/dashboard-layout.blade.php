<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard Admin' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</head>
<body class="bg-gray-50 dark:bg-gray-900">
    <div x-data="{ isSidebarOpen: window.innerWidth >= 768 }" class="antialiased">

        <x-dashboard-navbar />
        <x-sidebar />

        {{-- Backdrop untuk Mobile dengan transisi fade --}}
        <div x-show="isSidebarOpen" 
            @click="isSidebarOpen = false" 
            class="fixed inset-0 z-30 bg-gray-900/50 md:hidden"
            x-transition:enter="transition-opacity ease-linear duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            style="display: none;">
        </div>

        {{-- Main Content dengan transisi geser --}}
        <main class="p-4 md:p-6 min-h-screen transition-all duration-300 ease-out" 
            :class="{ 'md:ml-64': isSidebarOpen, 'md:ml-20': !isSidebarOpen }" 
            style="padding-top: 5.5rem;">
            {{ $slot }}
        </main>

        <footer class="bg-gray-900 dark:bg-gray-950 border-t border-white/10 transition-all duration-300 ease-out"
                :class="{ 'md:ml-64': isSidebarOpen, 'md:ml-20': !isSidebarOpen }">
            {{-- 
                ============================================================
                PERBAIKAN UTAMA ADA DI SINI
                ============================================================
                Class `max-w-7xl` dan `mx-auto` telah dihapus dari div di bawah ini
                agar lebarnya mengikuti elemen parent (footer).
                Padding `px-*` tetap dipertahankan agar konten tidak menempel di tepi layar.
            --}}
            <div class="px-4 sm:px-6 lg:px-8 py-8 lg:py-12">
                <div class="md:flex md:justify-between">
                    <div class="mb-6 md:mb-0 max-w-sm">
                        <a href="/" class="flex items-center mb-6">
                            <img src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=500" class="h-8 me-3" alt="FlowBite Logo" />
                            <span class="self-center text-2xl font-semibold whitespace-nowrap text-white">TVRI Yogyakarta</span>
                        </a>
                        <p class="text-sm leading-6 text-gray-400">
                            Lembaga Penyiaran Publik Televisi Republik Indonesia Stasiun D.I. Yogyakarta.
                        </p>
                    </div>
                    <div class="grid grid-cols-2 gap-8 sm:gap-6 sm:grid-cols-3">
                        <div>
                            <h2 class="mb-6 text-sm font-semibold uppercase text-white">Resources</h2>
                            <ul class="text-gray-400 font-medium">
                                <li class="mb-4">
                                    <a href="#" class="hover:underline">Flowbite</a>
                                </li>
                                <li>
                                    <a href="https://tailwindcss.com/" class="hover:underline">Tailwind CSS</a>
                                </li>
                            </ul>
                        </div>
                        <div>
                            <h2 class="mb-6 text-sm font-semibold uppercase text-white">Follow us</h2>
                            <ul class="text-gray-400 font-medium">
                                <li class="mb-4">
                                    <a href="#" class="hover:underline ">Github</a>
                                </li>
                                <li>
                                    <a href="#" class="hover:underline">Discord</a>
                                </li>
                            </ul>
                        </div>
                        <div>
                            <h2 class="mb-6 text-sm font-semibold uppercase text-white">Legal</h2>
                            <ul class="text-gray-400 font-medium">
                                <li class="mb-4">
                                    <a href="#" class="hover:underline">Privacy Policy</a>
                                </li>
                                <li>
                                    <a href="#" class="hover:underline">Terms &amp; Conditions</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <hr class="my-6 border-gray-700 lg:my-8" />
                <div class="sm:flex sm:items-center sm:justify-between">
                    <span class="text-sm text-gray-400 text-center sm:text-left">© 2025 <a href="/" class="hover:underline">TVRI Yogyakarta™</a>. All Rights Reserved.
                    </span>
                    <div class="flex mt-4 justify-center sm:mt-0 space-x-5">
                        <a href="#" class="text-gray-500 hover:text-white">
                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 8 19">
                                <path fill-rule="evenodd" d="M6.135 3H8V0H6.135a4.147 4.147 0 0 0-4.142 4.142V6H0v3h2v9.938h3V9h2.021l.592-3H5V3.591A.6.6 0 0 1 5.592 3h.543Z" clip-rule="evenodd"/>
                            </svg>
                            <span class="sr-only">Facebook page</span>
                        </a>
                        <a href="#" class="text-gray-500 hover:text-white">
                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 21 16">
                                <path d="M16.942 1.556a16.3 16.3 0 0 0-4.126-1.3 12.04 12.04 0 0 0-.529 1.1 15.175 15.175 0 0 0-4.573 0 11.585 11.585 0 0 0-.535-1.1 16.274 16.274 0 0 0-4.129 1.3A17.392 17.392 0 0 0 .182 13.218a15.785 15.785 0 0 0 4.963 2.521c.41-.564.773-1.16 1.084-1.785a10.63 10.63 0 0 1-1.706-.83c.143-.106.283-.217.418-.33a11.664 11.664 0 0 0 10.118 0c.137.113.277.224.418-.33-.543.348-1.106.6-1.706.83.311.623.673 1.22 1.084 1.785a16.012 16.012 0 0 0 4.963-2.521A17.353 17.353 0 0 0 16.942 1.556Z"/>
                            </svg>
                            <span class="sr-only">Discord community</span>
                        </a>
                        <a href="#" class="text-gray-500 hover:text-white">
                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 17">
                                <path fill-rule="evenodd" d="M20 1.892a8.178 8.178 0 0 1-2.355.635 4.074 4.074 0 0 0 1.8-2.235 8.344 8.344 0 0 1-2.605.98A4.13 4.13 0 0 0 13.85 0a4.068 4.068 0 0 0-4.1 4.038 4 4 0 0 0 .105.919A11.705 11.705 0 0 1 1.4.734a4.006 4.006 0 0 0 1.268 5.392 4.165 4.165 0 0 1-1.859-.5v.05A4.057 4.057 0 0 0 4.1 9.635a4.19 4.19 0 0 1-1.856.07 4.108 4.108 0 0 0 3.831 2.807A8.36 8.36 0 0 1 0 14.184 11.732 11.732 0 0 0 6.291 16 11.502 11.502 0 0 0 17.964 4.5c0-.177 0-.355-.012-.53A8.348 8.348 0 0 0 20 1.892Z" clip-rule="evenodd"/>
                            </svg>
                            <span class="sr-only">Twitter page</span>
                        </a>
                        <a href="#" class="text-gray-500 hover:text-white">
                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 .333A9.911 9.911 0 0 0 6.866 19.67c.5.092.678-.215.678-.477 0-.235-.008-.864-.013-1.69-2.782.602-3.369-1.34-3.369-1.34-.454-1.157-1.11-1.464-1.11-1.464-.908-.618.069-.606.069-.606 1.003.07 1.531 1.03 1.531 1.03.892 1.527 2.341 1.084 2.91.83.092-.645.35-1.083.636-1.334-2.22-.25-4.555-1.11-4.555-4.942 0-1.09.39-1.984 1.03-2.684-.103-.25-.446-1.268.098-2.65 0 0 .84-.27 2.75 1.026A9.522 9.522 0 0 1 10 6.845c.85.004 1.705.115 2.504.336 1.909-1.296 2.747-1.027 2.747-1.027.546 1.382.202 2.398.1 2.651.64.7 1.03 1.595 1.03 2.684 0 3.848-2.338 4.695-4.566 4.943.359.308.678.92.678 1.854 0 1.336-.012 2.41-.012 2.737 0 .263.18.572.681.477A9.911 9.911 0 0 0 10 .333Z" clip-rule="evenodd"/>
                            </svg>
                            <span class="sr-only">GitHub account</span>
                        </a>
                        <a href="#" class="text-gray-500 hover:text-white">
                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 14">
                                <path fill-rule="evenodd" d="M19.7 3.037a4.26 4.26 0 0 0-3.004-3.004C15.044 0 10 0 10 0S4.956 0 3.304.033A4.26 4.26 0 0 0 .3 3.037c-.033 1.652-.033 6.963 0 8.615a4.26 4.26 0 0 0 3.004 3.004C4.956 14.688 10 14.688 10 14.688s5.044 0 6.696-.033a4.26 4.26 0 0 0 3.004-3.004c.033-1.652.033-6.963 0-8.615Zm-8.633 8.22V4.433l6.034 3.412-6.034 3.412Z" clip-rule="evenodd"/>
                            </svg>
                            <span class="sr-only">Dribbble account</span>
                        </a>
                    </div>
                </div>
            </div>
        </footer>

    </div>
</body>
</html>