<x-dashboard-layout>
    <x-slot:title>
        Manajemen Banner Carousel
    </x-slot:title>

    {{-- Style untuk x-cloak dan modal --}}
    <style>
        [x-cloak] { 
            display: none !important; 
        }
        .modal-hidden {
            opacity: 0;
            visibility: hidden;
            transform: scale(0.9);
        }
        .modal-visible {
            opacity: 1;
            visibility: visible;
            transform: scale(1);
        }
    </style>

    <div x-data="{ 
        deleteModal: false, 
        deleteBannerId: null, 
        deleteBannerTitle: '',
        
        openDeleteModal(bannerId, bannerTitle) {
            this.deleteBannerId = bannerId;
            this.deleteBannerTitle = bannerTitle;
            this.deleteModal = true;
            document.body.style.overflow = 'hidden';
        },
        
        closeDeleteModal() {
            this.deleteModal = false;
            this.deleteBannerId = null;
            this.deleteBannerTitle = '';
            document.body.style.overflow = '';
        }
    }" 
    x-init="deleteModal = false; deleteBannerId = null; deleteBannerTitle = '';"
    class="pb-6">
        
        {{-- HEADER HALAMAN --}}
        <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4 mb-8 pt-2">
            <div>
                <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white">
                    Pengaturan Hero Carousel
                </h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Kelola semua banner yang tampil di halaman depan. Anda dapat menambah, mengubah urutan, dan menonaktifkan banner.
                </p>
            </div>
            <a href="{{ route('banners.create') }}" 
               class="inline-flex items-center justify-center px-4 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 transition-colors whitespace-nowrap">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                </svg>
                Tambah Banner Baru
            </a>
        </div>

        {{-- PESAN SUKSES --}}
        @if (session('success'))
            <div x-data="{ show: true }" 
                 x-show="show" 
                 x-transition 
                 x-init="setTimeout(() => show = false, 5000)"
                 class="flex items-center p-4 mb-6 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 border border-green-200 dark:border-green-800" 
                 role="alert">
                <svg class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <span class="font-medium">{{ session('success') }}</span>
                <button @click="show = false" 
                        class="ml-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700 items-center justify-center transition-colors">
                    <span class="sr-only">Close</span>
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        @endif

        {{-- GRID DAFTAR BANNER (Responsive) --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse ($banners as $banner)
                {{-- Card Banner - Matching post-card style --}}
                <article class="bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700 overflow-hidden flex flex-col group h-full hover:shadow-lg transition-shadow duration-200">
                    
                    {{-- Gambar Banner - h-40 sesuai post-card --}}
                    <div class="relative h-40 overflow-hidden">
                        <img src="{{ Storage::url($banner->image_path) }}" 
                             alt="{{ $banner->title }}" 
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300 ease-in-out"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        
                        {{-- Fallback Image --}}
                        <div class="w-full h-full hidden items-center justify-center bg-gray-100 dark:bg-gray-700">
                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>

                        {{-- Status Badge --}}
                        <div class="absolute top-2 right-2">
                            @if($banner->is_active)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-300 shadow-sm">
                                    ✓ Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 shadow-sm">
                                    ⊗ Nonaktif
                                </span>
                            @endif
                        </div>

                        {{-- Order Badge --}}
                        <div class="absolute top-2 left-2">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full text-xs font-bold bg-white/90 dark:bg-gray-800/90 text-gray-900 dark:text-white shadow-sm border border-gray-200 dark:border-gray-700">
                                {{ $banner->order }}
                            </span>
                        </div>
                    </div>

                    {{-- Konten - p-4 sesuai post-card --}}
                    <div class="p-4 flex flex-col flex-grow">
                        <div class="flex-grow">
                            {{-- Judul --}}
                            <h3 class="mb-2 text-lg font-bold tracking-tight text-gray-900 dark:text-white leading-snug line-clamp-2">
                                {{ $banner->title }}
                            </h3>

                            {{-- Subtitle --}}
                            <p class="mb-3 font-light text-sm text-gray-500 dark:text-gray-400 line-clamp-2">
                                {{ $banner->subtitle }}
                            </p>

                            {{-- Link --}}
                            @if($banner->link)
                                <div class="flex items-start text-xs text-gray-500 dark:text-gray-400 mb-2">
                                    <svg class="w-3 h-3 mr-1 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                    </svg>
                                    <span class="truncate">{{ Str::limit($banner->link, 30) }}</span>
                                </div>
                            @endif
                        </div>
                        
                        {{-- Footer dengan Tombol Aksi --}}
                        <div class="flex items-center justify-between mt-auto pt-3 border-t border-gray-100 dark:border-gray-700/50">
                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                Tombol Aksi ->
                            </span>
                            
                            <div class="flex items-center gap-2">
                                {{-- Tombol Edit --}}
                                <a href="{{ route('banners.edit', $banner) }}" 
                                   title="Edit Banner" 
                                   class="inline-flex items-center justify-center p-2 text-sm font-medium text-yellow-600 bg-yellow-50 border border-yellow-200 rounded-lg hover:bg-yellow-100 hover:border-yellow-300 focus:z-10 focus:ring-2 focus:ring-yellow-500 dark:bg-yellow-900/20 dark:border-yellow-900/50 dark:text-yellow-400 dark:hover:bg-yellow-900/30 dark:hover:border-yellow-800 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>

                                {{-- Tombol Hapus --}}
                                <button @click="openDeleteModal({{ $banner->id }}, '{{ addslashes($banner->title) }}')" 
                                        title="Hapus Banner" 
                                        type="button" 
                                        class="inline-flex items-center justify-center p-2 text-sm font-medium text-red-600 bg-red-50 border border-red-200 rounded-lg hover:bg-red-100 hover:border-red-300 focus:z-10 focus:ring-2 focus:ring-red-500 dark:bg-red-900/20 dark:border-red-900/50 dark:text-red-400 dark:hover:bg-red-900/30 dark:hover:border-red-800 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </article>
            @empty
                {{-- Empty State --}}
                <div class="sm:col-span-2 lg:col-span-3 xl:col-span-4 flex flex-col items-center justify-center py-16 bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
                    <svg class="w-16 h-16 text-gray-300 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <p class="text-lg font-medium text-gray-500 dark:text-gray-400">Belum ada banner yang ditambahkan</p>
                    <p class="mt-1 text-sm text-gray-400 dark:text-gray-500">Mulai dengan membuat banner pertama Anda untuk hero carousel</p>
                    <a href="{{ route('banners.create') }}" 
                       class="mt-6 inline-flex items-center px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                        </svg>
                        Tambah Banner Baru
                    </a>
                </div>
            @endforelse
        </div>

        {{-- PAGINASI --}}
        @if($banners->hasPages())
            <div class="mt-6">
                {{ $banners->links() }}
            </div>
        @endif

        {{-- DELETE CONFIRMATION MODAL --}}
        <div x-show="deleteModal" 
             x-cloak
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform scale-95"
             x-transition:enter-end="opacity-100 transform scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 transform scale-100"
             x-transition:leave-end="opacity-0 transform scale-95"
             class="fixed inset-0 z-50 overflow-y-auto bg-gray-900/75 backdrop-blur-sm flex items-center justify-center p-4"
             @keydown.escape.window="closeDeleteModal()"
             :class="{ 'modal-hidden': !deleteModal, 'modal-visible': deleteModal }">
             
            <div class="relative bg-white rounded-lg shadow-xl dark:bg-gray-800 max-w-md w-full" 
                 @click.away="closeDeleteModal()">
                {{-- Modal Header --}}
                <div class="flex items-center justify-between p-5 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Konfirmasi Hapus Banner</h3>
                    <button @click="closeDeleteModal()" 
                            type="button" 
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                
                {{-- Modal Body --}}
                <div class="p-6">
                    <div class="flex items-start mb-4">
                        <div class="flex-shrink-0 w-12 h-12 rounded-full bg-red-100 dark:bg-red-900/20 flex items-center justify-center">
                            <svg class="w-6 h-6 text-red-600 dark:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <div class="ml-4 flex-1">
                            <p class="text-gray-900 dark:text-white font-medium mb-2">Anda yakin ingin menghapus banner ini?</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2" x-text="deleteBannerTitle"></p>
                        </div>
                    </div>
                    <div class="p-3 bg-yellow-50 dark:bg-yellow-900/10 border border-yellow-200 dark:border-yellow-900/50 rounded-lg">
                        <p class="text-sm text-yellow-800 dark:text-yellow-500">
                            <strong>Perhatian:</strong> Tindakan ini tidak dapat dibatalkan dan banner akan dihapus permanen.
                        </p>
                    </div>
                </div>
                
                {{-- Modal Footer --}}
                <div class="flex items-center justify-end gap-3 p-6 border-t border-gray-200 dark:border-gray-700">
                    <button @click="closeDeleteModal()" 
                            type="button" 
                            class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600 transition-colors">
                        Batal
                    </button>
                    <form :action="`{{ url('dashboard/banners') }}/${deleteBannerId}`" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="px-5 py-2.5 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800 transition-colors">
                            Hapus Banner
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>