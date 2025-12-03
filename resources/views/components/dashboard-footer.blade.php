<footer class="bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700">
    <div class="px-4 sm:px-6 lg:px-8 py-8 lg:py-12">
        <div class="md:flex md:justify-between">
            <div class="mb-6 md:mb-0 max-w-sm">
                <a href="/" class="flex items-center mb-6 gap-2">
                    {{-- 1. Logo Gelap (Tampil di Light Mode, Hilang di Dark Mode) --}}
                    <img src="{{ asset('img/logolight.png') }}" 
                        class="h-9 md:h-12 w-auto block dark:hidden" 
                        alt="LiteBeam Logo Dark" />

                    {{-- 2. Logo Terang (Hilang di Light Mode, Tampil di Dark Mode) --}}
                    <img src="{{ asset('img/logodark.png') }}" 
                        class="h-9 md:h-12 w-auto hidden dark:block" 
                        alt="LiteBeam Logo Light" />
                    <span class="self-center text-2xl font-semibold text-gray-900 dark:text-white whitespace-normal lg:whitespace-nowrap">
                    Media Pemersatu Bangsa
                </a>
                <p class="text-sm leading-6 text-gray-600 dark:text-gray-400">
                    Lembaga Penyiaran Publik Televisi Republik Indonesia Stasiun D.I. Yogyakarta.
                </p>
            </div>
            
            {{-- Menu Footer Statis --}}
            <div class="grid grid-cols-2 gap-8 sm:gap-6 sm:grid-cols-3">
                <div>
                    <h2 class="mb-6 text-sm font-semibold uppercase text-gray-900 dark:text-white">Resources</h2>
                    <ul class="text-gray-600 dark:text-gray-400 font-medium">
                        <li class="mb-4"><a href="#" class="hover:underline">Flowbite</a></li>
                        <li><a href="https://tailwindcss.com/" class="hover:underline">Tailwind CSS</a></li>
                    </ul>
                </div>
                <div>
                    <h2 class="mb-6 text-sm font-semibold uppercase text-gray-900 dark:text-white">Follow us</h2>
                    <ul class="text-gray-600 dark:text-gray-400 font-medium">
                        <li class="mb-4"><a href="#" class="hover:underline ">Github</a></li>
                        <li><a href="#" class="hover:underline">Discord</a></li>
                    </ul>
                </div>
                <div>
                    <h2 class="mb-6 text-sm font-semibold uppercase text-gray-900 dark:text-white">Legal</h2>
                    <ul class="text-gray-600 dark:text-gray-400 font-medium">
                        <li class="mb-4"><a href="#" class="hover:underline">Privacy Policy</a></li>
                        <li><a href="#" class="hover:underline">Terms &amp; Conditions</a></li>
                    </ul>
                </div>
            </div>
        </div>
        
        <hr class="my-6 border-gray-300 dark:border-gray-700 lg:my-8" />
        
        <div class="sm:flex sm:items-center sm:justify-between">
            <span class="text-sm text-gray-600 dark:text-gray-400 text-center sm:text-left">© {{ date('Y') }} <a href="/" class="hover:underline">TVRI Yogyakarta™</a>. All Rights Reserved.
            </span>
            
            {{-- ✅ BAGIAN IKON SOSIAL MEDIA DINAMIS --}}
            <div class="flex mt-4 justify-center sm:mt-0 space-x-5">
                
                {{-- Facebook --}}
                @if($socialMedia->facebook)
                    <a href="{{ $socialMedia->facebook }}" target="_blank" class="text-gray-500 hover:text-gray-900 dark:hover:text-white transition-colors">
                        <span class="sr-only">Facebook page</span>
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" /></svg>
                    </a>
                @endif

                {{-- X (Twitter) --}}
                @if($socialMedia->twitter)
                    <a href="{{ $socialMedia->twitter }}" target="_blank" class="text-gray-500 hover:text-gray-900 dark:hover:text-white transition-colors">
                        <span class="sr-only">X (Twitter) page</span>
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M13.6823 10.6218L20.2391 3H18.6854L12.9921 9.61788L8.44486 3H3.2002L10.0765 13.0074L3.2002 21H4.75404L10.7663 14.0113L15.5685 21H20.8131L13.6819 10.6218H13.6823ZM11.5541 13.0956L10.8574 12.0991L5.31391 4.16971H7.70053L12.1742 10.5689L12.8709 11.5655L18.6861 19.8835H16.2995L11.5541 13.096V13.0956Z" /></svg>
                    </a>
                @endif

                {{-- Instagram --}}
                @if($socialMedia->instagram)
                    <a href="{{ $socialMedia->instagram }}" target="_blank" class="text-gray-500 hover:text-gray-900 dark:hover:text-white transition-colors">
                        <span class="sr-only">Instagram page</span>
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.468.99c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" /></svg>
                    </a>
                @endif

                {{-- YouTube --}}
                @if($socialMedia->youtube)
                    <a href="{{ $socialMedia->youtube }}" target="_blank" class="text-gray-500 hover:text-gray-900 dark:hover:text-white transition-colors">
                        <span class="sr-only">YouTube account</span>
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M19.812 5.418c.861.23 1.538.907 1.768 1.768C21.998 8.746 22 12 22 12s0 3.255-.418 4.814a2.504 2.504 0 0 1-1.768 1.768c-1.56.419-7.814.419-7.814.419s-6.255 0-7.814-.419a2.505 2.505 0 0 1-1.768-1.768C2 15.255 2 12 2 12s0-3.255.417-4.814a2.507 2.507 0 0 1 1.768-1.768C5.744 5 11.998 5 11.998 5s6.255 0 7.814.418ZM15.194 12 10 15V9l5.194 3Z" clip-rule="evenodd" /></svg>
                    </a>
                @endif

                {{-- TikTok --}}
                @if($socialMedia->tiktok)
                    <a href="{{ $socialMedia->tiktok }}" target="_blank" class="text-gray-500 hover:text-gray-900 dark:hover:text-white transition-colors">
                        <span class="sr-only">TikTok</span>
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.35-1.17.82-1.5 1.47-.27.53-.39 1.15-.33 1.75.26 1.9 2.07 3.32 4 3.07 1.86-.24 3.27-1.85 3.27-3.74.02-4.27.01-8.54.01-12.81 1.36 1.09 1.61 2.8 1.73 4.45h4.09c-.06-1.86-.79-3.64-2.07-5.02-1.32-1.45-3.21-2.22-5.11-2.43V.02z" clip-rule="evenodd" /></svg>
                    </a>
                @endif

            </div>
        </div>
    </div>
</footer>

<script src="https://unpkg.com/feather-icons"></script>
<script>
    feather.replace();
</script>