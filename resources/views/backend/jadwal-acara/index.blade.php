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
        deleteId: null, 
        deleteTitle: '',
        
        openDeleteModal(id, title) {
            this.deleteId = id;
            this.deleteTitle = title;
            this.deleteModal = true;
            document.body.style.overflow = 'hidden';
        },
        
        closeDeleteModal() {
            this.deleteModal = false;
            document.body.style.overflow = '';
        }
    }" class="pb-6">
        
        {{-- HEADER --}}
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-6 pt-2">
            <div>
                <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white">Jadwal Acara TV</h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Atur jadwal penayangan program harian.</p>
            </div>
            
            <a href="{{ route('dashboard.jadwal-acara.create') }}" 
               class="inline-flex items-center justify-center px-4 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 transition-colors">
               <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
               Buat Jadwal
            </a>
        </div>

        {{-- FILTER --}}
        <form method="GET" action="{{ route('dashboard.jadwal-acara.index') }}" class="mb-6">
            <div class="flex flex-col md:flex-row gap-4">
                <div class="relative flex-grow">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" class="block w-full p-3 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Cari acara...">
                </div>
                <select name="category" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full md:w-48 p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <option value="">Semua Kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->slug }}" @selected(request('category') == $category->slug)>{{ $category->name }}</option>
                    @endforeach
                </select>
                <button type="submit" class="px-5 py-3 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">Cari</button>
            </div>
        </form>

        {{-- ALERT --}}
        @if(session('success'))
            <div class="mb-4 p-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-green-900/30 dark:text-green-400 border border-green-200 dark:border-green-800">
                <span class="font-medium">Sukses!</span> {{ session('success') }}
            </div>
        @endif

        {{-- TABEL --}}
        <div class="table-container bg-white dark:bg-gray-800 shadow-md sm:rounded-lg border border-gray-200 dark:border-gray-700">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                    <tr>
                        <th class="p-4 text-center w-24">Pukul</th>
                        <th class="p-4 text-left">Nama Program</th>
                        <th class="p-4 text-center">Kategori</th>
                        <th class="p-4 text-center w-28">Status</th>
                        <th class="p-4 text-center w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($jadwalAcaras as $jadwal)
                        <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <td class="p-4 align-middle text-center font-mono text-lg font-bold text-blue-600 dark:text-blue-400">
                                {{ \Carbon\Carbon::parse($jadwal->start_time)->format('H:i') }}
                            </td>
                            <td class="p-4 align-middle">
                                <span class="font-semibold text-gray-900 dark:text-white text-base">{{ $jadwal->title }}</span>
                            </td>
                            <td class="p-4 align-middle text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $jadwal->broadcastCategory->color_classes ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ $jadwal->broadcastCategory->name ?? '-' }}
                                </span>
                            </td>
                            <td class="p-4 align-middle text-center">
                                @if($jadwal->is_active)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300">
                                        Tayang
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400">
                                        Off
                                    </span>
                                @endif
                            </td>
                            <td class="p-4 align-middle text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('dashboard.jadwal-acara.edit', $jadwal) }}" class="p-2 text-yellow-600 bg-yellow-100 rounded-lg hover:bg-yellow-200 dark:bg-yellow-900/30 dark:text-yellow-300">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    <button @click="openDeleteModal({{ $jadwal->id }}, '{{ addslashes($jadwal->title) }}')" class="p-2 text-red-600 bg-red-100 rounded-lg hover:bg-red-200 dark:bg-red-900/30 dark:text-red-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-gray-500 dark:text-gray-400">Belum ada jadwal acara.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINASI --}}
        <div class="mt-4">{{ $jadwalAcaras->links() }}</div>

        {{-- MODAL HAPUS --}}
        <div x-show="deleteModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/75 backdrop-blur-sm"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full p-6" @click.away="closeDeleteModal()">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Hapus Jadwal?</h3>
                <p class="text-gray-600 dark:text-gray-300 mb-6">Anda yakin ingin menghapus jadwal <strong x-text="deleteTitle"></strong>?</p>
                <div class="flex justify-end gap-3">
                    <button @click="closeDeleteModal()" class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">Batal</button>
                    <form :action="`{{ route('dashboard.jadwal-acara.destroy', '') }}/${deleteId}`" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" class="px-4 py-2 text-white bg-red-600 rounded-lg hover:bg-red-700">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>