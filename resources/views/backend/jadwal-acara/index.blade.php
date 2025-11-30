<x-dashboard-layout>
    <x-slot:title>Manajemen Jadwal Acara</x-slot:title>

    <style>
        [x-cloak] { display: none !important; }
        .modal-hidden { opacity: 0; visibility: hidden; transform: scale(0.9); }
        .modal-visible { opacity: 1; visibility: visible; transform: scale(1); }
        .table-container { overflow-x: auto; }
    </style>

    <div x-data="{ 
        deleteModal: false, 
        deleteItemId: null, 
        deleteItemName: '',
        openDeleteModal(itemId, itemName) {
            this.deleteItemId = itemId;
            this.deleteItemName = itemName;
            this.deleteModal = true;
            document.body.style.overflow = 'hidden';
        },
        closeDeleteModal() {
            this.deleteModal = false;
            this.deleteItemId = null;
            this.deleteItemName = '';
            document.body.style.overflow = '';
        }
    }" class="pb-6">
        
        <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4 mb-8 pt-2">
            <div>
                <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white">Jadwal Acara TV</h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Kelola jadwal siaran harian televisi.</p>
            </div>
            {{-- ROUTE UPDATE --}}
            <a href="{{ route('dashboard.jadwal-acara.create') }}" 
               class="inline-flex items-center justify-center px-4 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 transition-colors shadow-sm hover:shadow-md">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Jadwal
            </a>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow-md sm:rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="table-container">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                        <tr>
                            <th class="px-6 py-4 text-center w-12">No</th>
                            <th class="px-6 py-4 w-32">Hari</th>
                            <th class="px-6 py-4 w-24">Jam</th>
                            <th class="px-6 py-4">Nama Program</th>
                            <th class="px-6 py-4">Link Source</th>
                            <th class="px-6 py-4 text-center w-32">Status</th>
                            <th class="px-6 py-4 text-center w-36">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($schedules as $index => $item)
                            <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <td class="px-6 py-4 text-center">{{ $schedules->firstItem() + $index }}</td>
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $item->day }}</td>
                                <td class="px-6 py-4 text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($item->time)->format('H:i') }}</td>
                                <td class="px-6 py-4 font-semibold text-blue-600 dark:text-blue-400">{{ $item->program_name }}</td>
                                <td class="px-6 py-4 text-xs">
                                    @if($item->linkSource)
                                        <span class="px-2 py-1 bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300 rounded border border-gray-200 dark:border-gray-600">{{ $item->linkSource->name }}</span>
                                    @else
                                        <span class="text-gray-400 italic">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($item->is_active)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300 border border-green-200 dark:border-green-800">Aktif</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-600">Non-Aktif</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-3">
                                        {{-- ROUTE UPDATE --}}
                                        <a href="{{ route('dashboard.jadwal-acara.edit', $item) }}" 
                                           class="inline-flex items-center justify-center w-8 h-8 text-xs font-medium rounded-lg bg-yellow-100 text-yellow-800 hover:bg-yellow-200 dark:bg-yellow-900/30 dark:text-yellow-300 dark:hover:bg-yellow-800/50 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </a>
                                        <button @click="openDeleteModal({{ $item->id }}, '{{ addslashes($item->program_name) }} ({{ $item->day }})')" 
                                                class="inline-flex items-center justify-center w-8 h-8 text-xs font-medium rounded-lg bg-red-100 text-red-600 hover:bg-red-200 dark:bg-red-900/30 dark:text-red-400 dark:hover:bg-red-800/50 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">Belum ada data jadwal. Silakan tambahkan baru.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t border-gray-200 dark:border-gray-700">{{ $schedules->links() }}</div>
        </div>

        <div x-show="deleteModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-gray-900/75 backdrop-blur-sm flex items-center justify-center p-4">
            <div class="relative bg-white rounded-lg shadow-xl dark:bg-gray-800 max-w-md w-full" @click.away="closeDeleteModal()">
                <div class="p-6 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Apakah anda yakin ingin menghapus jadwal <br> "<span x-text="deleteItemName" class="font-bold text-gray-900 dark:text-white"></span>"?</h3>
                    <div class="flex justify-center gap-4">
                        <button @click="closeDeleteModal()" type="button" class="px-5 py-2.5 text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600">Batal</button>
                        {{-- ROUTE UPDATE --}}
                        <form :action="`{{ route('dashboard.jadwal-acara.destroy', '') }}/${deleteItemId}`" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800">Ya, Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>