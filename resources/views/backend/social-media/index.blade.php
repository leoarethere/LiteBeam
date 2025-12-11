<x-dashboard-layout>
    <x-slot:title>Pengaturan Sosial Media</x-slot:title>

    <div class="pb-6">
        <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4 mb-8 pt-2">
            <div>
                <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white">
                    Sosial Media
                </h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Daftar tautan sosial media instansi.
                </p>
            </div>

            {{-- Tombol Edit Biru --}}
            @if($socialMedia)
                <a href="{{ route('dashboard.social-media.edit', $socialMedia->id) }}" 
                   class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition-colors shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    Edit Sosial Media
                </a>
            @endif
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800" role="alert">
                <span class="font-medium">Sukses!</span> {{ session('success') }}
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Helper function untuk menampilkan link atau '-' jika kosong --}}
                    @php
                        function showLink($url) {
                            return $url ? '<a href="'.$url.'" target="_blank" class="text-blue-600 hover:underline break-all">'.$url.'</a>' : '<span class="text-gray-400 italic">Tidak ada tautan</span>';
                        }
                    @endphp

                    {{-- Instagram --}}
                    <div class="p-4 bg-gray-50 dark:bg-gray-700/30 rounded-lg border border-gray-100 dark:border-gray-700">
                        <div class="flex items-center gap-3 mb-2">
                            <i class="fab fa-instagram text-2xl text-pink-600"></i> {{-- Gunakan FontAwesome jika ada, atau SVG --}}
                            <h3 class="font-semibold text-gray-900 dark:text-white">Instagram</h3>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-300">
                            {!! showLink($socialMedia->instagram) !!}
                        </p>
                    </div>

                    {{-- Facebook --}}
                    <div class="p-4 bg-gray-50 dark:bg-gray-700/30 rounded-lg border border-gray-100 dark:border-gray-700">
                        <div class="flex items-center gap-3 mb-2">
                            <i class="fab fa-facebook text-2xl text-blue-600"></i>
                            <h3 class="font-semibold text-gray-900 dark:text-white">Facebook</h3>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-300">
                            {!! showLink($socialMedia->facebook) !!}
                        </p>
                    </div>

                    {{-- Twitter / X --}}
                    <div class="p-4 bg-gray-50 dark:bg-gray-700/30 rounded-lg border border-gray-100 dark:border-gray-700">
                        <div class="flex items-center gap-3 mb-2">
                            <span class="text-xl font-bold text-gray-900 dark:text-white">X</span>
                            <h3 class="font-semibold text-gray-900 dark:text-white">Twitter / X</h3>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-300">
                            {!! showLink($socialMedia->twitter) !!}
                        </p>
                    </div>

                    {{-- YouTube --}}
                    <div class="p-4 bg-gray-50 dark:bg-gray-700/30 rounded-lg border border-gray-100 dark:border-gray-700">
                        <div class="flex items-center gap-3 mb-2">
                            <i class="fab fa-youtube text-2xl text-red-600"></i>
                            <h3 class="font-semibold text-gray-900 dark:text-white">YouTube</h3>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-300">
                            {!! showLink($socialMedia->youtube) !!}
                        </p>
                    </div>

                    {{-- TikTok --}}
                    <div class="md:col-span-2 p-4 bg-gray-50 dark:bg-gray-700/30 rounded-lg border border-gray-100 dark:border-gray-700">
                        <div class="flex items-center gap-3 mb-2">
                            <i class="fab fa-tiktok text-2xl text-gray-900 dark:text-white"></i>
                            <h3 class="font-semibold text-gray-900 dark:text-white">TikTok</h3>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-300">
                            {!! showLink($socialMedia->tiktok) !!}
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>