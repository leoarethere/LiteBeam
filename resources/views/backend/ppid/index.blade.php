<x-dashboard-layout>
    <x-slot:title>Manajemen Dokumen PPID</x-slot:title>

    {{-- Style untuk modal & x-cloak --}}
    <style>
        [x-cloak] { display: none !important; }
        .modal-hidden { opacity: 0; visibility: hidden; transform: scale(0.9); }
        .modal-visible { opacity: 1; visibility: visible; transform: scale(1); }
        .table-container { overflow-x: auto; }
    </style>

    {{-- Data Alpine.js --}}
    <div x-data="{ 
        deleteModal: false, 
        deleteItemId: null, 
        deleteItemTitle: '',
        
        openDeleteModal(itemId, itemTitle) {
            this.deleteItemId = itemId;
            this.deleteItemTitle = itemTitle;
            this.deleteModal = true;
            document.body.style.overflow = 'hidden';
        },
        
        closeDeleteModal() {
            this.deleteModal = false;
            this.deleteItemId = null;
            this.deleteItemTitle = '';
            document.body.style.overflow = '';
        }
    }" 
    class="pb-6">
        
        {{-- HEADER HALAMAN --}}
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-6 pt-2">
            <div>
                <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white">
                    Dokumen PPID
                </h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Kelola dokumen dan informasi publik PPID di sini.
                </p>
            </div>
            
            <a href="{{ route('dashboard.ppid.create') }}" 
                class="inline-flex items-center justify-center px-4 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 transition-colors whitespace-nowrap">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                Tambah Dokumen
            </a>
        </div>

        {{-- Alert Success --}}
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                <div class="flex">
                    <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <p class="ml-3 text-sm font-medium text-green-800 dark:text-green-400">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        {{-- TABEL --}}
        <div class="table-container bg-white dark:bg-gray-800 shadow-md sm:rounded-lg border border-gray-200 dark:border-gray-700">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-center w-12">No</th>
                        <th scope="col" class="px-6 py-4 text-center w-24">Cover</th>
                        <th scope="col" class="px-6 py-4 text-left">Judul & File</th>
                        <th scope="col" class="px-6 py-4 text-left">Keterangan</th>
                        <th scope="col" class="px-6 py-4 text-center w-32">Status</th>
                        <th scope="col" class="px-6 py-4 text-center w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($ppids as $item)
                        <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <td class="px-6 py-4 align-top text-center font-medium text-gray-900 dark:text-white">{{ $loop->iteration }}</td>
                            
                            {{-- Cover --}}
                            <td class="px-6 py-4 align-top text-center">
                                @if ($item->cover_image)
                                    <img src="{{ asset('storage/' . $item->cover_image) }}" alt="Cover" class="w-16 h-auto object-cover rounded shadow-sm mx-auto border dark:border-gray-600">
                                @else
                                    <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded flex items-center justify-center mx-auto text-xs text-gray-400">
                                        No Cover
                                    </div>
                                @endif
                            </td>

                            {{-- Judul & File --}}
                            <td class="px-6 py-4 align-top">
                                <p class="text-base font-semibold text-gray-900 dark:text-white mb-1">{{ $item->title }}</p>
                                <a href="{{ asset('storage/' . $item->file_path) }}" target="_blank" class="inline-flex items-center gap-1 text-xs text-blue-600 dark:text-blue-400 hover:underline">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    Lihat Dokumen
                                </a>
                            </td>

                            {{-- Keterangan (Excerpt) --}}
                            <td class="px-6 py-4 align-top">
                                <div class="text-sm text-gray-600 dark:text-gray-300 line-clamp-3 prose prose-sm dark:prose-invert">
                                    {!! Str::limit(strip_tags($item->description), 100) !!}
                                </div>
                            </td>

                            {{-- Status --}}
                            <td class="px-6 py-4 align-top text-center">
                                @if($item->is_active)
                                    <span class="inline-flex items-center bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">
                                        <span class="w-2 h-2 me-1 bg-green-500 rounded-full"></span>
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">
                                        <span class="w-2 h-2 me-1 bg-red-500 rounded-full"></span>
                                        Non-Aktif
                                    </span>
                                @endif
                            </td>

                            {{-- Aksi --}}
                            <td class="px-6 py-4 align-top text-center">
                                <div class="flex items-center justify-center gap-2">
                                    {{-- Edit --}}
                                    <a href="{{ route('dashboard.ppid.edit', $item->id) }}" 
                                       class="p-2 text-white bg-yellow-400 rounded-lg hover:bg-yellow-500 focus:ring-4 focus:outline-none focus:ring-yellow-300 dark:focus:ring-yellow-800 transition-colors" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>

                                    {{-- Hapus --}}
                                    <button @click="openDeleteModal({{ $item->id }}, '{{ addslashes($item->title) }}')"
                                        type="button" 
                                        class="p-2 text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 transition-colors" title="Hapus">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 mb-3 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    <p>Belum ada dokumen PPID.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINASI --}}
        <div class="mt-4">
            {{ $ppids->links() }}
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
            
            <div class="relative bg-white rounded-lg shadow-xl dark:bg-gray-800 max-w-md w-full" @click.away="closeDeleteModal()">
                <div class="flex items-center justify-between p-5 border-b dark:border-gray-700">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Konfirmasi Hapus</h3>
                    <button @click="closeDeleteModal()" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </button>
                </div>
                <div class="p-6">
                    <div class="flex items-start mb-4">
                        <div class="flex-shrink-0 w-12 h-12 rounded-full bg-red-100 dark:bg-red-900/20 flex items-center justify-center">
                            <svg class="w-6 h-6 text-red-600 dark:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                        <div class="ml-4 flex-1">
                            <p class="text-gray-900 dark:text-white font-medium mb-2">Anda yakin ingin menghapus dokumen ini?</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400 font-semibold" x-text="deleteItemTitle"></p>
                        </div>
                    </div>
                    <div class="p-3 bg-yellow-50 dark:bg-yellow-900/10 border border-yellow-200 dark:border-yellow-900/50 rounded-lg">
                        <p class="text-sm text-yellow-800 dark:text-yellow-500"><strong>Perhatian:</strong> Tindakan ini tidak dapat dibatalkan.</p>
                    </div>
                </div>
                <div class="flex items-center justify-end gap-3 p-6 border-t dark:border-gray-700">
                    <button @click="closeDeleteModal()" type="button" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600 transition-colors">Batal</button>
                    
                    <form :action="`{{ route('dashboard.ppid.destroy', '') }}/${deleteItemId}`" method="POST" class="inline">
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