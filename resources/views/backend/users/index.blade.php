<x-dashboard-layout>
    <x-slot:title>Manajemen Pengguna</x-slot:title>

    <style>
        [x-cloak] { display: none !important; }
        .modal-hidden { opacity: 0; visibility: hidden; transform: scale(0.9); }
        .modal-visible { opacity: 1; visibility: visible; transform: scale(1); }
        .table-container { overflow-x: auto; }
        .alert-transition { transition: all 0.3s ease-in-out; }
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
        
        {{-- HEADER --}}
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-6 pt-2">
            <div>
                <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white">Manajemen Pengguna</h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Kelola akun admin yang memiliki akses ke dashboard.</p>
            </div>
            
            <a href="{{ route('dashboard.users.create') }}" 
               class="inline-flex items-center justify-center px-4 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah User
            </a>
        </div>

        {{-- ALERT --}}
        @if(session('success'))
            <div class="mb-4 p-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-green-900/30 dark:text-green-400 border border-green-200 dark:border-green-800 alert-transition">
                <span class="font-medium">Sukses!</span> {{ session('success') }}
            </div>
        @endif
        @if($errors->has('error'))
            <div class="mb-4 p-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-red-900/30 dark:text-red-400 border border-red-200 dark:border-red-800 alert-transition">
                <span class="font-medium">Gagal!</span> {{ $errors->first('error') }}
            </div>
        @endif

        {{-- TABLE --}}
        <div class="table-container bg-white dark:bg-gray-800 shadow-md sm:rounded-lg border border-gray-200 dark:border-gray-700">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                    <tr>
                        <th scope="col" class="px-4 py-4 text-center w-12">No</th>
                        <th scope="col" class="px-4 py-4 text-left">Nama Lengkap</th>
                        <th scope="col" class="px-4 py-4 text-left">Email</th>
                        <th scope="col" class="px-4 py-4 text-center w-40">Terdaftar</th>
                        <th scope="col" class="px-4 py-4 text-center w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($users as $user)
                        <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <td class="px-4 py-4 text-center font-medium text-gray-900 dark:text-white">{{ $loop->iteration + $users->firstItem() - 1 }}</td>
                            <td class="px-4 py-4">
                                <div class="flex items-center gap-3">
                                    <img class="w-8 h-8 rounded-full bg-gray-200 ring-2 ring-gray-100 dark:ring-gray-700" src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random&color=fff" alt="">
                                    <div class="flex items-center gap-2">
                                        <span class="font-semibold text-gray-900 dark:text-white">{{ $user->name }}</span>
                                        @if(auth()->id() === $user->id)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wide bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300">
                                                Anda
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4">{{ $user->email }}</td>
                            <td class="px-4 py-4 text-center text-xs text-gray-500">{{ $user->created_at->format('d M Y') }}</td>
                            <td class="px-4 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    {{-- Badge Edit --}}
                                    <a href="{{ route('dashboard.users.edit', $user) }}"
                                    class="inline-flex items-center justify-center w-10 h-10 text-xs font-medium
                                            rounded-lg bg-yellow-100 text-yellow-800 hover:bg-yellow-200
                                            dark:bg-yellow-900/30 dark:text-yellow-300 dark:hover:bg-yellow-800/50
                                            transition-colors group" title="Edit User">
                                        <svg class="w-4 h-4 group-hover:scale-110 transition-transform"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                    </a>
                                    {{-- Badge Hapus --}}
                                    @if(auth()->id() !== $user->id)
                                    <button @click="openDeleteModal({{ $user->id }}, '{{ addslashes($user->name) }}')"
                                        class="inline-flex items-center justify-center w-10 h-10 text-xs font-medium
                                            rounded-lg bg-red-100 text-red-700 hover:bg-red-200
                                            dark:bg-red-900/30 dark:text-red-400 dark:hover:bg-red-800/50
                                            transition-colors group" title="Hapus User">
                                        <svg class="w-4 h-4 group-hover:scale-110 transition-transform"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-gray-500 dark:text-gray-400">Belum ada user lain.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $users->links() }}</div>

        {{-- MODAL HAPUS --}}
        <div x-show="deleteModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/75 backdrop-blur-sm"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100"
             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-95">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full p-6" @click.away="closeDeleteModal()">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 rounded-full bg-red-100 dark:bg-red-900/20 flex items-center justify-center text-red-600 dark:text-red-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Hapus Pengguna?</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Anda yakin ingin menghapus user <strong x-text="deleteItemName"></strong>?</p>
                    </div>
                </div>
                <div class="flex justify-end gap-3">
                    <button @click="closeDeleteModal()" class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">Batal</button>
                    <form :action="`{{ route('dashboard.users.destroy', '') }}/${deleteItemId}`" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" class="px-4 py-2 text-white bg-red-600 rounded-lg hover:bg-red-700">Hapus User</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>