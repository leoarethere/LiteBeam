<x-dashboard-layout>
    <x-slot:title>Tambah Jadwal Acara</x-slot:title>

    <div class="pb-6" x-data="{
        title: '{{ old('title') }}',
        slug: '{{ old('slug') }}',
        generateSlug() {
            this.slug = this.title.toLowerCase().replace(/[^a-z0-9\s-]/g, '').replace(/\s+/g, '-').replace(/-+/g, '-').trim();
        }
    }">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Tambah Jadwal Baru</h1>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 p-6">
            <form action="{{ route('dashboard.jadwal-acara.store') }}" method="POST">
                @csrf
                <div class="grid gap-6 mb-6 md:grid-cols-2">
                    
                    {{-- Nama Acara --}}
                    <div class="col-span-2">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Acara <span class="text-red-500">*</span></label>
                        <input type="text" name="title" x-model="title" @input="generateSlug()" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Contoh: Berita Pagi" required>
                    </div>

                    {{-- Slug --}}
                    <div class="col-span-2">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Slug URL</label>
                        <input type="text" name="slug" x-model="slug" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" readonly>
                    </div>

                    {{-- Pukul Penayangan --}}
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pukul Penayangan <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 end-0 top-0 flex items-center pe-3.5 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z" clip-rule="evenodd"/></svg>
                            </div>
                            <input type="time" name="start_time" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required value="{{ old('start_time') }}">
                        </div>
                    </div>

                    {{-- Kategori --}}
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kategori Acara <span class="text-red-500">*</span></label>
                        <select name="broadcast_category_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                            <option value="">Pilih Kategori...</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('broadcast_category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Status --}}
                    <div class="col-span-2">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
                        <div class="flex gap-4">
                            <label class="flex items-center p-3 border rounded-lg w-full cursor-pointer bg-gray-50 dark:bg-gray-700 dark:border-gray-600">
                                <input type="radio" name="is_active" value="1" class="w-4 h-4 text-blue-600" checked>
                                <span class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Aktif (Tayang)</span>
                            </label>
                            <label class="flex items-center p-3 border rounded-lg w-full cursor-pointer bg-gray-50 dark:bg-gray-700 dark:border-gray-600">
                                <input type="radio" name="is_active" value="0" class="w-4 h-4 text-blue-600">
                                <span class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Non-Aktif</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t dark:border-gray-700">
                    <a href="{{ route('dashboard.jadwal-acara.index') }}" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100">Batal</a>
                    <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">Simpan Jadwal</button>
                </div>
            </form>
        </div>
    </div>
</x-dashboard-layout>