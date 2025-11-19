<x-dashboard-layout>
    <x-slot:title>
        Manajemen Penyiaran
    </x-slot:title>

    {{-- Style untuk modal & x-cloak --}}
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
        .table-container {
            overflow-x: auto;
        }
        /* Animasi untuk alert */
        .alert-transition {
            transition: all 0.3s ease-in-out;
        }
    </style>

    {{-- Data Alpine.js LENGKAP untuk modal --}}
    <div x-data="{ 
        // State untuk modal hapus penyiaran
        deleteModal: false, 
        deleteBroadcastId: null, 
        deleteBroadcastTitle: '',
        
        // State untuk modal kategori
        isCategoryModalOpen: false,
        modalMode: 'create',
        modalTitle: 'Tambah Kategori Penyiaran Baru',
        modalAction: '{{ route('dashboard.broadcast-categories.store') }}',
        updateUrlTemplate: '{{ route('dashboard.broadcast-categories.update', ':id') }}',
        
        categoryData: {
            id: null,
            name: '',
            slug: '',
            color: 'blue'
        },

        // State untuk modal hapus kategori
        deleteCategoryModal: false,
        deleteCategoryId: null,
        deleteCategoryName: '',
        deleteCategoryError: '',

        // Fungsi untuk slugify
        generateSlug() {
            this.categoryData.slug = this.categoryData.name
                .toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .trim();
        },

        // Fungsi untuk membuka modal Kategori (mode create)
        openCreateModal() {
            this.modalMode = 'create';
            this.modalTitle = 'Tambah Kategori Penyiaran Baru';
            this.modalAction = '{{ route('dashboard.broadcast-categories.store') }}';
            this.categoryData = { id: null, name: '', slug: '', color: 'blue' };
            this.isCategoryModalOpen = true;
            document.body.style.overflow = 'hidden';
        },

        // Fungsi untuk membuka modal Kategori (mode edit)
        openEditModal(category) {
            this.modalMode = 'edit';
            this.modalTitle = 'Edit Kategori Penyiaran';
            this.modalAction = this.updateUrlTemplate.replace(':id', category.id);
            this.categoryData = {
                id: category.id,
                name: category.name,
                slug: category.slug,
                color: category.color 
            };
            this.isCategoryModalOpen = true;
            document.body.style.overflow = 'hidden';
        },

        // Fungsi untuk menutup modal Kategori
        closeCategoryModal() {
            this.isCategoryModalOpen = false;
            document.body.style.overflow = '';
        },

        // Fungsi untuk modal hapus kategori
        openDeleteCategoryModal(category) {
            this.deleteCategoryId = category.id;
            this.deleteCategoryName = category.name;
            this.deleteCategoryError = '';
            this.deleteCategoryModal = true;
            document.body.style.overflow = 'hidden';
        },

        closeDeleteCategoryModal() {
            this.deleteCategoryModal = false;
            this.deleteCategoryError = '';
            document.body.style.overflow = '';
        },

        // Fungsi untuk modal hapus penyiaran
        openDeleteModal(broadcastId, broadcastTitle) {
            this.deleteBroadcastId = broadcastId;
            this.deleteBroadcastTitle = broadcastTitle;
            this.deleteModal = true;
            document.body.style.overflow = 'hidden';
        },
        
        closeDeleteModal() {
            this.deleteModal = false;
            document.body.style.overflow = '';
        }
    }" 
    class="pb-6"
    
    @if ($errors->has('name') || $errors->has('slug') || $errors->has('color'))
        x-init="isCategoryModalOpen = true; document.body.style.overflow = 'hidden';"
    @endif
    >
        
        {{-- HEADER HALAMAN --}}
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-6 pt-2">
            <div>
                <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white">
                    Semua Penyiaran
                </h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Kelola semua rilis, pengumuman, atau siaran pers di sini.
                </p>
            </div>
            
            {{-- Tombol Aksi Header --}}
            <div class="flex-shrink-0 flex items-center gap-3">
                <button 
                    @click="openCreateModal()"
                    type="button"
                    class="inline-flex items-center justify-center px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600 transition-colors whitespace-nowrap">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7A2 2 0 0121 12v5a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2h3m0 0l-3 3m0 0l3 3m-3-3h5"></path></svg>
                    Kelola Kategori
                </button>

                <a href="{{ route('dashboard.broadcasts.create') }}" 
                    class="inline-flex items-center justify-center px-4 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 transition-colors whitespace-nowrap">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                    Buat Penyiaran
                </a>
            </div>
        </div>

        {{-- Notifikasi ditangani oleh layout --}}

        {{-- FORM FILTER --}}
        <form method="GET" action="{{ route('dashboard.broadcasts.index') }}" class="mb-6">
            <div class="flex flex-col md:flex-row gap-4">
                <div class="relative flex-grow">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" class="block w-full p-3 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Cari penyiaran...">
                </div>
                
                <select name="category" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full md:w-48 p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                    <option value="">Semua Kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->slug }}" @selected(request('category') == $category->slug)>{{ $category->name }}</option>
                    @endforeach
                </select>
                
                <select name="sort" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full md:w-48 p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                    <option value="latest" @selected(request('sort', 'latest') == 'latest')>Terbaru</option>
                    <option value="oldest" @selected(request('sort') == 'oldest')>Terlama</option>
                </select>
                <div class="flex gap-2">
                    <button type="submit" class="w-full md:w-auto px-5 py-3 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300">Cari</button>
                    @if(request()->hasAny(['search', 'category', 'sort']))
                        <a href="{{ route('dashboard.broadcasts.index') }}" class="w-full md:w-auto px-5 py-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600">Reset</a>
                    @endif
                </div>
            </div>
        </form>

        {{-- INFO HASIL FILTER --}}
        @if(request()->hasAny(['search', 'category', 'sort']))
            <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
                Menampilkan {{ $broadcasts->total() }} hasil
                @if(request('search'))
                    untuk pencarian <strong class="text-gray-900 dark:text-white">"{{ request('search') }}"</strong>
                @endif
                @if(request('category'))
                    dalam kategori <strong class="text-gray-900 dark:text-white">"{{ $categories->where('slug', request('category'))->first()->name ?? request('category') }}"</strong>
                @endif
            </div>
        @endif

        {{-- TABEL --}}
        <div class="table-container bg-white dark:bg-gray-800 shadow-md sm:rounded-lg border border-gray-200 dark:border-gray-700">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                    <tr>
                        <th scope="col" class="p-4 text-center w-12">No</th>
                        <th scope="col" class="p-4 text-center">Judul & Kategori</th>
                        <th scope="col" class="p-4 text-center w-28">Poster</th>
                        <th scope="col" class="p-4 text-center">Sinopsis</th>
                        <th scope="col" class="p-4 text-center w-32">Link</th>
                        <th scope="col" class="p-4 text-center w-36">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($broadcasts as $broadcast)
                        {{-- [PERBAIKAN] Menggunakan 'align-top' agar rapi jika sinopsisnya panjang --}}
                        <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            
                            <td class="p-4 align-top text-center font-medium text-gray-900 dark:text-white">
                                {{ $loop->iteration + $broadcasts->firstItem() - 1 }}
                            </td>
                            
                            {{-- Judul & Kategori --}}
                            <td class="p-4 align-top">
                                <div class="space-y-1.5">
                                    <p class="font-semibold text-gray-900 dark:text-white line-clamp-2 leading-tight">
                                        {{ $broadcast->title }}
                                    </p>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $broadcast->broadcastCategory->color_classes ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                                        {{ $broadcast->broadcastCategory->name ?? 'N/A' }}
                                    </span>
                                </div>
                            </td>
                            
                            {{-- Poster --}}
                            <td class="p-4 align-top text-center">
                                @if ($broadcast->poster)
                                    <img src="{{ Storage::url($broadcast->poster) }}" alt="Poster {{ $broadcast->title }}" class="w-16 h-20 object-cover rounded-md ring-1 ring-gray-200 dark:ring-gray-700 inline-block">
                                @else
                                    <div class="w-16 h-20 inline-flex items-center justify-center bg-gray-100 dark:bg-gray-700 rounded-md ring-1 ring-gray-200 dark:ring-gray-700">
                                        <svg class="w-6 h-6 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </td>

                            {{-- Sinopsis --}}
                            <td class="p-4 align-top">
                                <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-3 leading-relaxed">
                                    {{ $broadcast->synopsis ?? '-' }}
                                </p>
                            </td>

                            {{-- Link Youtube --}}
                            <td class="p-4 align-top text-center">
                                @if ($broadcast->youtube_link)
                                    <a href="{{ $broadcast->youtube_link }}" target="_blank" rel="noopener noreferrer"
                                        title="Tonton di Youtube: {{ $broadcast->youtube_link }}"
                                        class="inline-flex items-center justify-center p-2 text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-900/50 rounded-lg transition-colors group">
                                        <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                        </svg>
                                        <span class="sr-only">Tonton Youtube</span>
                                    </a>
                                @else
                                    <span class="text-gray-400 dark:text-gray-600 text-sm">-</span>
                                @endif
                            </td>

                            {{-- Tombol Aksi --}}
                            <td class="p-4 align-top text-center">
                                <div class="flex items-center justify-center gap-3">
                                    {{-- Badge Edit --}}
                                    <a href="{{ route('dashboard.broadcasts.edit', $broadcast) }}" 
                                    class="inline-flex items-center justify-center w-10 h-10 text-xs font-medium 
                                            rounded-lg bg-yellow-100 text-yellow-800 hover:bg-yellow-200 
                                            dark:bg-yellow-900/30 dark:text-yellow-300 dark:hover:bg-yellow-800/50 
                                            transition-colors group" title="Edit Penyiaran">
                                        <svg class="w-4 h-4 group-hover:scale-110 transition-transform" 
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>

                                    {{-- Badge Hapus --}}
                                    <a href="#" 
                                    @click.prevent="openDeleteModal({{ $broadcast->id }}, '{{ addslashes($broadcast->title) }}')" 
                                    class="inline-flex items-center justify-center w-10 h-10 text-xs font-medium 
                                            rounded-lg bg-red-100 text-red-600 hover:bg-red-200 
                                            dark:bg-red-900/30 dark:text-red-400 dark:hover:bg-red-800/50 
                                            transition-colors group" title="Hapus Penyiaran">
                                        <svg class="w-4 h-4 group-hover:scale-110 transition-transform" 
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-16 h-16 text-gray-300 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <p class="text-lg font-medium text-gray-500 dark:text-gray-400">Tidak ada data penyiaran ditemukan</p>
                                    @if(request()->hasAny(['search', 'sort']))
                                        <p class="text-sm text-gray-400 dark:text-gray-500 mt-1">Coba kata kunci lain atau reset filter</p>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINASI --}}
        @if($broadcasts->hasPages())
            <div class="mt-6">
                {{ $broadcasts->links() }}
            </div>
        @endif

        {{-- (Sisa file modal tetap sama persis seperti sebelumnya) --}}
        {{-- MODAL HAPUS PENYIARAN --}}
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
                <div class="flex items-center justify-between p-5 border-b dark:border-gray-700">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Konfirmasi Hapus</h3>
                    <button @click="closeDeleteModal()" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
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
                            <p class="text-gray-900 dark:text-white font-medium mb-2">Anda yakin ingin menghapus data penyiaran ini?</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2" x-text="deleteBroadcastTitle"></p>
                        </div>
                    </div>
                    <div class="p-3 bg-yellow-50 dark:bg-yellow-900/10 border border-yellow-200 dark:border-yellow-900/50 rounded-lg">
                        <p class="text-sm text-yellow-800 dark:text-yellow-500"><strong>Perhatian:</strong> Tindakan ini tidak dapat dibatalkan.</p>
                    </div>
                </div>
                {{-- Modal Footer --}}
                <div class="flex items-center justify-end gap-3 p-6 border-t dark:border-gray-700">
                    <button @click="closeDeleteModal()" type="button" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600 transition-colors">Batal</button>
                    
                    <form :action="`{{ route('dashboard.broadcasts.destroy', '') }}/${deleteBroadcastId}`" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 transition-colors">
                            Hapus Penyiaran
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- MODAL KELOLA KATEGORI --}}
        <div x-show="isCategoryModalOpen" 
             x-cloak
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform scale-95"
             x-transition:enter-end="opacity-100 transform scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 transform scale-100"
             x-transition:leave-end="opacity-0 transform scale-95"
             class="fixed inset-0 z-50 overflow-y-auto bg-gray-900/75 backdrop-blur-sm flex items-center justify-center p-4"
             @keydown.escape.window="closeCategoryModal()"
             :class="{ 'modal-hidden': !isCategoryModalOpen, 'modal-visible': isCategoryModalOpen }">
            
            <div class="relative bg-white rounded-lg shadow-xl dark:bg-gray-800 max-w-2xl w-full max-h-[90vh] overflow-hidden flex flex-col" 
                 @click.away="closeCategoryModal()">
                
                {{-- Modal Header --}}
                <div class="flex items-center justify-between p-5 border-b dark:border-gray-700 flex-shrink-0">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white" x-text="modalTitle">Kelola Kategori Penyiaran</h3>
                    <button @click="closeCategoryModal()" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>

                {{-- Modal Body --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-0 overflow-hidden h-full">
                    
                <form :action="modalAction" method="POST" @submit="if(modalMode === 'edit') { $event.target.querySelector('[name=_method]').value = 'PUT'; }" class="p-6 border-r dark:border-gray-700 overflow-y-auto">
                    @csrf
                    <input type="hidden" name="_method" value="POST">
                    
                    <h4 class="text-lg font-medium text-gray-900 dark:text-white" x-text="modalMode === 'edit' ? 'Edit Kategori' : 'Buat Kategori Baru'"></h4>

                    {{-- Nama Kategori --}}
                    <div>
                        <label for="cat-name" class="block mt-2 mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Nama Kategori <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="cat-name" name="name" x-model="categoryData.name" @input="generateSlug()"
                            class="bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white {{ $errors->has('name') ? 'border-red-500' : 'border-gray-300' }}" 
                            placeholder="Contoh: Rilis Pers"
                            required>
                        @error('name')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Slug --}}
                    <div>
                        <label for="cat-slug" class="block mt-2 mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Slug <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="cat-slug" name="slug" x-model="categoryData.slug"
                            class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white font-mono text-xs {{ $errors->has('slug') ? 'border-red-500' : 'border-gray-300' }}"
                            placeholder="rilis-pers"
                            required>
                        @error('slug')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            URL: <span class="font-mono" x-text="`/broadcast-categories/${categoryData.slug || 'slug-anda'}`"></span>
                        </p>
                    </div>

                    {{-- Warna --}}
                    <div>
                        <label for="cat-color" class="block mt-2 mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Warna Badge
                        </label>
                        <select id="cat-color" name="color" x-model="categoryData.color"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="blue">Biru</option>
                            <option value="pink">Pink</option>
                            <option value="green">Hijau</option>
                            <option value="yellow">Kuning</option>
                            <option value="indigo">Indigo</option>
                            <option value="purple">Ungu</option>
                            <option value="red">Merah</option>
                            <option value="gray">Abu-abu</option>
                        </select>
                        @error('color')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="flex items-center gap-3 pt-4">
                        <button type="submit" 
                                class="px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition-colors">
                            <span x-show="modalMode === 'create'">Simpan Kategori</span>
                            <span x-show="modalMode === 'edit'">Perbarui Kategori</span>
                        </button>
                        <button type="button" @click="openCreateModal()" x-show="modalMode === 'edit'"
                                class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600 transition-colors">
                            Buat Baru
                        </button>
                    </div>
                </form>

                    <div class="p-6 overflow-y-auto">
                        <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Kategori yang Ada</h4>
                        <div class="space-y-2">
                            @forelse ($broadcastCategories as $category)
                                @php
                                    $broadcastCount = $category->broadcasts()->count();
                                @endphp
                                <div class="flex items-center justify-between gap-2 p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors border border-gray-200 dark:border-gray-600">
                                    <div class="flex items-center gap-3 flex-1 min-w-0">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $category->color_classes }} flex-shrink-0">
                                            {{ $category->name }}
                                        </span>
                                        <span class="text-xs text-gray-500 dark:text-gray-400 truncate">
                                            ({{ $broadcastCount }} penyiaran)
                                        </span>
                                    </div>
                                    <div class="flex-shrink-0 flex items-center gap-1">
                                    {{-- Tombol Edit --}}
                                    <button @click="openEditModal({{ $category }})"
                                            class="p-2 text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400 transition-colors rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/20" 
                                            title="Edit Kategori">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </button>
                                    
                                    {{-- Tombol Hapus --}}
                                    <button 
                                        type="button"
                                        @click="openDeleteCategoryModal({{ $category }})"
                                        
                                        @if($broadcastCount === 0)
                                        class="p-2 rounded-lg transition-colors
                                               text-gray-500 hover:text-red-600 hover:bg-red-50 
                                               dark:text-gray-400 dark:hover:text-red-500 dark:hover:bg-red-900/20"
                                        
                                        @else
                                        class="p-2 rounded-lg transition-colors
                                               text-gray-400 dark:text-gray-600 opacity-50 cursor-not-allowed"
                                        disabled
                                        @endif

                                        title="{{ $broadcastCount > 0 ? 'Kategori tidak bisa dihapus karena memiliki '.$broadcastCount.' penyiaran' : 'Hapus Kategori' }}">
                                        
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                                </div>
                            @empty
                                <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                                    <svg class="w-12 h-12 mx-auto mb-3 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                    <p>Belum ada kategori.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- MODAL HAPUS KATEGORI --}}
        <div x-show="deleteCategoryModal" 
            x-cloak
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform scale-95"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-95"
            class="fixed inset-0 z-[60] overflow-y-auto bg-gray-900/75 backdrop-blur-sm flex items-center justify-center p-4"
            @keydown.escape.window="closeDeleteCategoryModal()">
            
            <div class="relative bg-white rounded-lg shadow-xl dark:bg-gray-800 max-w-md w-full" 
                @click.away="closeDeleteCategoryModal()">
                
                {{-- Modal Header --}}
                <div class="flex items-center justify-between p-5 border-b dark:border-gray-700">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Konfirmasi Hapus Kategori</h3>
                    <button @click="closeDeleteCategoryModal()" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
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
                            <p class="text-gray-900 dark:text-white font-medium mb-2">Anda yakin ingin menghapus kategori ini?</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400 font-semibold" x-text="deleteCategoryName"></p>
                        </div>
                    </div>
                    <div class="p-3 bg-yellow-50 dark:bg-yellow-900/10 border border-yellow-200 dark:border-yellow-900/50 rounded-lg">
                        <p class="text-sm text-yellow-800 dark:text-yellow-500">
                            <strong>Perhatian:</strong> Tindakan ini tidak dapat dibatalkan.
                        </p>
                    </div>
                </div>
                
                {{-- Modal Footer --}}
                <div class="flex items-center justify-end gap-3 p-6 border-t dark:border-gray-700">
                    <button @click="closeDeleteCategoryModal()" type="button" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600 transition-colors">
                        Batal
                    </button>
                    
                    <form :action="`{{ route('dashboard.broadcast-categories.destroy', '') }}/${deleteCategoryId}`" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 transition-colors">
                            Hapus Kategori
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>