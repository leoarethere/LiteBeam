<x-dashboard-layout>
    <x-slot:title>Tambah Jadwal Acara</x-slot:title>

    <div class="pb-6">
        <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4 mb-8 pt-2">
            <div>
                <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white">Tambah Jadwal Baru</h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Masukan informasi jadwal acara TV.</p>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
            <form action="{{ route('dashboard.tv-schedules.store') }}" method="POST">
                @csrf
                
                <div class="p-6 space-y-6">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Pilih Hari --}}
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Hari Tayang <span class="text-red-500">*</span></label>
                            <select name="day" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                                <option value="" disabled selected>-- Pilih Hari --</option>
                                @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $day)
                                    <option value="{{ $day }}">{{ $day }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Input Jam --}}
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jam Tayang (WIB) <span class="text-red-500">*</span></label>
                            <input type="time" name="time" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                        </div>
                    </div>

                    {{-- Nama Program --}}
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Program / Acara <span class="text-red-500">*</span></label>
                        <input type="text" name="program_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Contoh: Jejak Islam, Berita Terkini..." required>
                    </div>

                    {{-- Link Source (Opsional) --}}
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Sumber Link (Opsional)</label>
                        <select name="link_source_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="">-- Tidak Ada Link --</option>
                            @forelse($sources as $source)
                                <option value="{{ $source->id }}">{{ $source->name }} ({{ $source->url }})</option>
                            @empty
                                <option value="" disabled>Belum ada data Sumber Link</option>
                            @endforelse
                        </select>
                        <p class="mt-1 text-xs text-gray-500">Pilih sumber link jika acara ini bisa ditonton streaming.</p>
                    </div>

                    {{-- Status Aktif --}}
                    <div class="flex items-center pt-2">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" class="sr-only peer" checked>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                            <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">Status Aktif</span>
                        </label>
                    </div>

                </div>

                {{-- Footer Tombol --}}
                <div class="flex items-center justify-between p-6 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50 rounded-b-lg">
                    <a href="{{ route('dashboard.tv-schedules.index') }}" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600 transition-colors">Batal</a>
                    <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 transition-colors">Simpan Jadwal</button>
                </div>
            </form>
        </div>
    </div>
</x-dashboard-layout>