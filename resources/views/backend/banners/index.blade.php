<x-dashboard-layout>
<x-slot:title>
Manajemen Banner Carousel
</x-slot:title>

<div x-data="{ 
    deleteModal: false, 
    deleteBannerId: null, 
    deleteBannerTitle: ''
}" class="pb-6">
    
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
            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
            </svg>
            Tambah Banner Baru
        </a>
    </div>

    {{-- PESAN SUKSES --}}
    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 5000)"
             class="flex items-center p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 border border-green-200 dark:border-green-800" role="alert">
            <svg class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
            <span class="font-medium">{{ session('success') }}</span>
            <button @click="show = false" class="ml-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700 items-center justify-center transition-colors">
                <span class="sr-only">Close</span>
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
            </button>
        </div>
    @endif

    {{-- GRID DAFTAR BANNER --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($banners as $banner)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 flex flex-col">
                {{-- Gambar Banner --}}
                <div class="relative h-48 rounded-t-lg overflow-hidden">
                    <img src="{{ Storage::url($banner->image_path) }}" alt="{{ $banner->title }}" class="w-full h-full object-cover">
                    <div class="absolute top-2 right-2">
                        @if($banner->is_active)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                Aktif
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                Tidak Aktif
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Konten Teks --}}
                <div class="p-4 flex-grow">
                    <h3 class="text-base font-semibold text-gray-900 dark:text-white line-clamp-2 mb-1">
                        {{ $banner->title }}
                    </h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2">
                        {{ $banner->subtitle }}
                    </p>
                </div>

                {{-- Tombol Aksi --}}
                <div class="flex items-center justify-between gap-2 p-4 border-t border-gray-200 dark:border-gray-700">
                    <span class="text-sm text-gray-500 dark:text-gray-400">Urutan: <strong>{{ $banner->order }}</strong></span>
                    <div class="flex items-center gap-2">
                        <a href="{{-- {{ route('banners.edit', $banner->id) }} --}}" title="Edit Banner" class="inline-flex items-center p-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-yellow-600 focus:z-10 focus:ring-2 focus:ring-yellow-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-yellow-400 dark:focus:ring-yellow-500 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </a>
                        <button @click="deleteModal = true; deleteBannerId = {{ $banner->id }}; deleteBannerTitle = '{{ addslashes($banner->title) }}'" title="Hapus Banner" type="button" class="inline-flex items-center p-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-red-50 hover:text-red-600 hover:border-red-300 focus:z-10 focus:ring-2 focus:ring-red-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-red-900/20 dark:hover:border-red-900 dark:hover:text-red-400 dark:focus:ring-red-500 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="md:col-span-2 lg:col-span-3 text-center py-16 bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
                <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l-1.586-1.586a2 2 0 00-2.828 0L6 14m6-6l.01.01"></path></svg>
                <p class="mt-4 text-gray-500 dark:text-gray-400 font-medium">Belum ada banner yang ditambahkan.</p>
                <p class="mt-1 text-sm text-gray-400 dark:text-gray-500">Mulai dengan membuat banner pertama Anda.</p>
                <a href="{{-- {{ route('banners.create') }} --}}" class="mt-4 inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                    Tambah Banner
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
    <div x-show="deleteModal" x-cloak x-transition @click.self="deleteModal = false" class="fixed inset-0 z-50 overflow-y-auto bg-gray-900 bg-opacity-75 backdrop-blur-sm flex items-center justify-center p-4">
        <div x-show="deleteModal" x-transition @click.away="deleteModal = false" class="relative bg-white rounded-lg shadow-xl dark:bg-gray-800 max-w-md w-full">
            {{-- Modal Header --}}
            <div class="flex items-center justify-between p-5 border-b border-gray-200 dark:border-gray-700 rounded-t">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Konfirmasi Hapus</h3>
                <button @click="deleteModal = false" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 ...">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
            </div>
            {{-- Modal Body --}}
            <div class="p-6">
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Apakah Anda yakin ingin menghapus banner ini?</p>
                <p class="text-base font-semibold text-gray-900 dark:text-white" x-text="deleteBannerTitle"></p>
                <div class="mt-4 p-3 bg-yellow-50 dark:bg-yellow-900/10 border border-yellow-200 dark:border-yellow-900/50 rounded-lg">
                    <p class="text-sm text-yellow-800 dark:text-yellow-500"><strong>Perhatian:</strong> Tindakan ini tidak dapat dibatalkan.</p>
                </div>
            </div>
            {{-- Modal Footer --}}
            <div class="flex items-center justify-end gap-3 p-6 border-t border-gray-200 dark:border-gray-700 rounded-b">
                <button @click="deleteModal = false" type="button" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border ...">Batal</button>
                <form :action="`/dashboard/banners/${deleteBannerId}`" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 ...">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

</x-dashboard-layout>