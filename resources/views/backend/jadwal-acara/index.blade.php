<x-dashboard-layout>
    <x-slot:title>Manajemen Jadwal Acara</x-slot:title>

    {{-- Style Tambahan --}}
    <style>
        [x-cloak] { display: none !important; }
        .modal-hidden { opacity: 0; visibility: hidden; transform: scale(0.9); }
        .modal-visible { opacity: 1; visibility: visible; transform: scale(1); }
        .table-container { overflow-x: auto; }
    </style>

    <div x-data="{ 
        // Modal Hapus Jadwal
        deleteModal: false, 
        deleteId: null, 
        deleteTitle: '',
        
        // Modal Kategori (Hari)
        categoryModal: false,
        catMode: 'create',
        catAction: '',
        catData: { id: null, name: '', slug: '', color: 'blue' },
        
        // Modal Hapus Kategori
        deleteCatModal: false,
        deleteCatId: null,
        deleteCatName: '',

        // Helper Slug
        generateSlug() {
            this.catData.slug = this.catData.name.toLowerCase().replace(/[^a-z0-9\s-]/g, '').replace(/\s+/g, '-').trim();
        },

        // --- Functions ---
        openDeleteModal(id, title) {
            this.deleteId = id;
            this.deleteTitle = title;
            this.deleteModal = true;
            document.body.style.overflow = 'hidden';
        },
        
        closeDeleteModal() {
            this.deleteModal = false;
            document.body.style.overflow = '';
        },
        
        openCategoryModal(mode, data = null) {
            this.catMode = mode;
            this.categoryModal = true;
            if (mode === 'create') {
                this.catData = { id: null, name: '', slug: '', color: 'blue' };
                this.catAction = '{{ route('dashboard.jadwal-categories.store') }}';
            } else {
                this.catData = { ...data };
                this.catAction = '{{ route('dashboard.jadwal-categories.update', ':id') }}'.replace(':id', data.id);
            }
        },

        openDeleteCatModal(id, name) {
            this.deleteCatId = id;
            this.deleteCatName = name;
            this.deleteCatModal = true;
        }
    }" class="pb-6">
        
        {{-- HEADER --}}
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-6 pt-2">
            <div>
                <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white">Jadwal Acara TV</h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Atur jadwal dan hari penayangan program.</p>
            </div>
            
            <div class="flex gap-2">
                {{-- Tombol Kelola Hari --}}
                <button @click="openCategoryModal('create')" type="button" class="inline-flex items-center justify-center px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Kelola Hari
                </button>

                <a href="{{ route('dashboard.jadwal-acara.create') }}" class="inline-flex items-center justify-center px-4 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                    Buat Jadwal
                </a>
            </div>
        </div>

        {{-- ALERT --}}
        @if(session('success'))
            <div class="mb-4 p-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-green-900/30 dark:text-green-400 border border-green-200 dark:border-green-800">
                <span class="font-medium">Sukses!</span> {{ session('success') }}
            </div>
        @endif

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

        {{-- TABEL JADWAL --}}
        <div class="table-container bg-white dark:bg-gray-800 shadow-md sm:rounded-lg border border-gray-200 dark:border-gray-700">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                    <tr>
                        <th class="p-4 text-center w-24">Pukul</th>
                        <th class="p-4 text-left">Nama Program</th>
                        <th class="p-4 text-center">Hari</th> 
                        <th class="p-4 text-center">Jenis</th>
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
                            <td class="p-4 align-middle font-semibold text-gray-900 dark:text-white">{{ $jadwal->title }}</td>
                            
                            {{-- Kolom Hari --}}
                            <td class="p-4 align-middle text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $jadwal->jadwalCategory->color_classes ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ $jadwal->jadwalCategory->name ?? '-' }}
                                </span>
                            </td>

                            {{-- Kolom Jenis --}}
                            <td class="p-4 align-middle text-center">
                                <span class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $jadwal->broadcastCategory->name ?? '-' }}
                                </span>
                            </td>

                            <td class="p-4 align-middle text-center">
                                @if($jadwal->is_active)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300">Tayang</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">Off</span>
                                @endif
                            </td>
                            <td class="p-4 align-middle text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('dashboard.jadwal-acara.edit', $jadwal) }}" class="p-2 text-yellow-600 bg-yellow-100 rounded-lg hover:bg-yellow-200"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg></a>
                                    <button @click="openDeleteModal({{ $jadwal->id }}, '{{ addslashes($jadwal->title) }}')" class="p-2 text-red-600 bg-red-100 rounded-lg hover:bg-red-200"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="p-8 text-center text-gray-500">Belum ada jadwal acara.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">{{ $jadwalAcaras->links() }}</div>

        {{-- MODAL CRUD KATEGORI (HARI) --}}
        <div x-show="categoryModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/75 backdrop-blur-sm">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-2xl w-full max-h-[90vh] overflow-hidden flex flex-col" @click.away="categoryModal = false">
                <div class="p-5 border-b dark:border-gray-700 flex justify-between items-center">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Kelola Hari / Kategori</h3>
                    <button @click="categoryModal = false" class="text-gray-400 hover:text-gray-900"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg></button>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 h-full">
                    {{-- Form Input --}}
                    <div class="p-6 border-r dark:border-gray-700">
                        <h4 class="font-medium text-gray-900 dark:text-white mb-4" x-text="catMode === 'create' ? 'Tambah Hari Baru' : 'Edit Hari'"></h4>
                        <form :action="catAction" method="POST">
                            @csrf
                            <input type="hidden" name="_method" :value="catMode === 'edit' ? 'PUT' : 'POST'">
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-900 dark:text-white mb-1">Nama Hari</label>
                                    <input type="text" name="name" x-model="catData.name" @input="generateSlug()" class="bg-gray-50 border border-gray-300 text-sm rounded-lg w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Contoh: Senin - Jumat" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-900 dark:text-white mb-1">Slug</label>
                                    <input type="text" name="slug" x-model="catData.slug" class="bg-gray-50 border border-gray-300 text-sm rounded-lg w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" readonly>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-900 dark:text-white mb-1">Warna Badge</label>
                                    <select name="color" x-model="catData.color" class="bg-gray-50 border border-gray-300 text-sm rounded-lg w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                        <option value="blue">Biru</option>
                                        <option value="green">Hijau</option>
                                        <option value="red">Merah</option>
                                        <option value="yellow">Kuning</option>
                                        <option value="purple">Ungu</option>
                                        <option value="gray">Abu-abu</option>
                                    </select>
                                </div>
                                <button type="submit" class="w-full text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Simpan</button>
                                <button type="button" x-show="catMode === 'edit'" @click="openCategoryModal('create')" class="w-full mt-2 text-gray-700 bg-white border border-gray-300 hover:bg-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600">Batal Edit</button>
                            </div>
                        </form>
                    </div>

                    {{-- List Kategori (DENGAN BADGE EDIT/DELETE BARU) --}}
                    <div class="p-6 overflow-y-auto max-h-[400px]">
                        <h4 class="font-medium text-gray-900 dark:text-white mb-4">Daftar Hari Tersedia</h4>
                        <div class="space-y-2">
                            @foreach($jadwalCategories as $cat)
                                <div class="flex items-center justify-between gap-2 p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors border border-gray-200 dark:border-gray-600">
                                    <div class="flex items-center gap-3 flex-1 min-w-0">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $cat->color_classes }} flex-shrink-0">
                                            {{ $cat->name }}
                                        </span>
                                    </div>
                                    
                                    {{-- Action Buttons (Style Baru sesuai Postingan) --}}
                                    <div class="flex-shrink-0 flex items-center gap-1">
                                        {{-- Tombol Edit --}}
                                        <button @click="openCategoryModal('edit', {{ $cat }})"
                                                class="p-2 text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400 transition-colors rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/20" 
                                                title="Edit Hari">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </button>
                                        
                                        {{-- Tombol Hapus --}}
                                        <button @click="openDeleteCatModal({{ $cat->id }}, '{{ $cat->name }}')"
                                                class="p-2 text-gray-500 hover:text-red-600 hover:bg-red-50 dark:text-gray-400 dark:hover:text-red-500 dark:hover:bg-red-900/20 rounded-lg transition-colors"
                                                title="Hapus Hari">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- MODAL HAPUS KATEGORI --}}
        <div x-show="deleteCatModal" x-cloak class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-gray-900/75 backdrop-blur-sm">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-sm w-full p-6" @click.away="deleteCatModal = false">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Hapus Hari?</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Menghapus hari <strong x-text="deleteCatName"></strong> akan menghapus relasinya pada jadwal terkait.</p>
                <div class="flex justify-end gap-2">
                    <button @click="deleteCatModal = false" class="px-4 py-2 text-sm text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">Batal</button>
                    <form :action="`{{ route('dashboard.jadwal-categories.destroy', '') }}/${deleteCatId}`" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" class="px-4 py-2 text-sm text-white bg-red-600 rounded-lg hover:bg-red-700">Hapus</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- MODAL HAPUS JADWAL (Original) --}}
        <div x-show="deleteModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/75 backdrop-blur-sm"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100"
             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-95">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full p-6" @click.away="closeDeleteModal()">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Hapus Jadwal?</h3>
                <p class="text-gray-600 dark:text-gray-300 mb-6">Anda yakin ingin menghapus jadwal <strong x-text="deleteTitle"></strong>?</p>
                <div class="flex justify-end gap-3">
                    <button @click="closeDeleteModal()" class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">Batal</button>
                    <form :action="`{{ route('dashboard.jadwal-acara.destroy', '') }}/${deleteId}`" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" class="px-4 py-2 text-white bg-red-600 rounded-lg hover:bg-red-700">Hapus</button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</x-dashboard-layout>