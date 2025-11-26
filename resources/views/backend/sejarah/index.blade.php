<x-dashboard-layout>
    <x-slot:title>Manajemen Sejarah TVRI</x-slot:title>

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
    </style>

    {{-- Data Alpine.js --}}
    <div x-data="{ 
        deleteModal: false, 
        deleteItemId: null, 
        deleteItemContent: '',
        
        openDeleteModal(itemId, itemContent) {
            this.deleteItemId = itemId;
            this.deleteItemContent = itemContent;
            this.deleteModal = true;
            document.body.style.overflow = 'hidden';
        },
        
        closeDeleteModal() {
            this.deleteModal = false;
            this.deleteItemId = null;
            this.deleteItemContent = '';
            document.body.style.overflow = '';
        }
    }" 
    class="pb-6">
        
        {{-- HEADER HALAMAN --}}
        <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4 mb-8 pt-2">
            <div>
                <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white">Sejarah TVRI</h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Kelola timeline dan peristiwa bersejarah TVRI Yogyakarta.</p>
            </div>
            <a href="{{ route('dashboard.sejarah.create') }}" 
               class="inline-flex items-center justify-center px-4 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 transition-colors whitespace-nowrap shadow-sm hover:shadow-md">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Baru
            </a>
        </div>

        {{-- TABEL --}}
        <div class="bg-white dark:bg-gray-800 shadow-md sm:rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="table-container">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                        <tr>
                            <th class="px-6 py-4 text-center w-12">No</th>
                            <th class="px-6 py-4 text-center w-28">Gambar</th> {{-- Diperlebar dari w-24 menjadi w-28 --}}
                            <th class="px-6 py-4">Judul & Konten</th>
                            <th class="px-6 py-4 text-center w-32">Status</th>
                            <th class="px-6 py-4 text-center w-36">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($histories as $item)
                            <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <td class="px-6 py-4 text-center font-semibold text-gray-900 dark:text-white">
                                    {{ $loop->iteration + $histories->firstItem() - 1 }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($item->image)
                                        <img src="{{ Storage::url($item->image) }}" 
                                             alt="Gambar {{ $item->title }}" 
                                             class="w-20 h-14 object-cover rounded-lg ring-1 ring-gray-200 dark:ring-gray-700 inline-block"> {{-- Menggunakan desain yang sama dengan postingan --}}
                                    @else
                                        {{-- Placeholder yang sama dengan postingan --}}
                                        <div class="w-20 h-14 inline-flex items-center justify-center bg-gray-100 dark:bg-gray-700 rounded-lg ring-1 ring-gray-200 dark:ring-gray-700">
                                            <svg class="w-6 h-6 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="space-y-1">
                                        <p class="font-semibold text-gray-900 dark:text-white">{{ $item->title }}</p>
                                        <div class="line-clamp-2 text-xs text-gray-600 dark:text-gray-400">
                                            {!! strip_tags($item->content) !!}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($item->status === 'published')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300 border border-green-200 dark:border-green-800">
                                            <span class="w-1.5 h-1.5 me-1.5 bg-green-500 rounded-full"></span>
                                            Published
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-600">
                                            <span class="w-1.5 h-1.5 me-1.5 bg-gray-500 rounded-full"></span>
                                            Draft
                                        </span>
                                    @endif
                                </td>
                                
                                {{-- Tombol Aksi --}}
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-3">
                                        {{-- Tombol Edit --}}
                                        <a href="{{ route('dashboard.sejarah.edit', $item) }}" 
                                           class="inline-flex items-center justify-center w-10 h-10 text-xs font-medium rounded-lg bg-yellow-100 text-yellow-800 hover:bg-yellow-200 dark:bg-yellow-900/30 dark:text-yellow-300 dark:hover:bg-yellow-800/50 transition-colors group"
                                           title="Edit Data">
                                            <svg class="w-4 h-4 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>

                                        {{-- Tombol Hapus --}}
                                        <button @click="openDeleteModal({{ $item->id }}, '{{ addslashes(Str::limit($item->title, 50)) }}')" 
                                                class="inline-flex items-center justify-center w-10 h-10 text-xs font-medium rounded-lg bg-red-100 text-red-600 hover:bg-red-200 dark:bg-red-900/30 dark:text-red-400 dark:hover:bg-red-800/50 transition-colors group"
                                                title="Hapus Data">
                                            <svg class="w-4 h-4 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 mb-3 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <p class="text-base font-medium">Belum ada data sejarah</p>
                                        <p class="text-sm mt-1">Silakan tambahkan data baru untuk ditampilkan.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>  
            
            {{-- Pagination --}}
            @if($histories->hasPages())
                <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                    {{ $histories->links() }}
                </div>
            @endif
        </div>

        {{-- MODAL HAPUS --}}
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
                            <p class="text-gray-900 dark:text-white font-medium mb-2">Anda yakin ingin menghapus data ini?</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2" x-text="deleteItemContent"></p>
                        </div>
                    </div>
                    <div class="p-3 bg-yellow-50 dark:bg-yellow-900/10 border border-yellow-200 dark:border-yellow-900/50 rounded-lg">
                        <p class="text-sm text-yellow-800 dark:text-yellow-500"><strong>Perhatian:</strong> Tindakan ini tidak dapat dibatalkan.</p>
                    </div>
                </div>
                {{-- Modal Footer --}}
                <div class="flex items-center justify-end gap-3 p-6 border-t dark:border-gray-700">
                    <button @click="closeDeleteModal()" type="button" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600 transition-colors">Batal</button>
                    
                    {{-- Form Action Dynamic --}}
                    <form :action="`{{ route('dashboard.sejarah.destroy', '') }}/${deleteItemId}`" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 transition-colors">
                            Hapus Data
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</x-dashboard-layout>