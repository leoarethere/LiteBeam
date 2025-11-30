<x-dashboard-layout>
    <x-slot:title>Edit Tugas & Fungsi</x-slot:title>

    {{-- Style Trix --}}
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
    <style>
        trix-toolbar [data-trix-button-group="file-tools"] { display: none; }
        .dark trix-editor { background-color: #374151; color: white; border-color: #4b5563; }
        .dark trix-toolbar { 
            background-color: #f3f4f6; 
            border-radius: 0.5rem; 
            margin-bottom: 0.5rem; 
        }
        trix-editor { 
            min-height: 200px; 
            background-color: #f9fafb;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            padding: 0.75rem;
        }
        trix-editor ul { 
            list-style-type: disc !important; 
            padding-left: 1.5rem !important; 
            margin-bottom: 1rem !important; 
        }
        trix-editor ol { 
            list-style-type: decimal !important; 
            padding-left: 1.5rem !important; 
            margin-bottom: 1rem !important; 
        }
        trix-editor li { margin-bottom: 0.5rem; }
        trix-editor blockquote { 
            border-left: 4px solid #e5e7eb; 
            padding-left: 1rem; 
            margin-left: 0; 
            font-style: italic; 
            color: #4b5563; 
        }
        .dark trix-editor blockquote { 
            border-left-color: #4b5563; 
            color: #d1d5db; 
        }
        .dark trix-editor {
            background-color: #374151;
        }
    </style>

    <div class="pb-6">
        {{-- HEADER HALAMAN --}}
        <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4 mb-8 pt-2">
            <div>
                <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white">Edit Data</h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Perbarui informasi Tugas atau Fungsi.</p>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
            <form action="{{ route('dashboard.tugas-fungsi.update', $task->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="p-6 space-y-6">
                    
                    {{-- Tipe --}}
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tipe Data</label>
                        <select name="type" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                            <option value="tugas" {{ old('type', $task->type) == 'tugas' ? 'selected' : '' }}>Tugas</option>
                            <option value="fungsi" {{ old('type', $task->type) == 'fungsi' ? 'selected' : '' }}>Fungsi</option>
                        </select>
                        @error('type')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Input Gambar dengan Preview --}}
                    <div x-data="{ preview: '{{ $task->image ? Storage::url($task->image) : null }}' }">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Gambar / Ikon (Opsional)</label>
                        
                        {{-- Preview Image --}}
                        <div class="mb-3" x-show="preview">
                            <div class="relative w-full max-w-xs">
                                <img :src="preview" class="w-full h-40 object-cover rounded-lg border-2 border-gray-300 dark:border-gray-600">
                                <button type="button" @click="preview = null; $refs.fileInput.value = ''" class="absolute top-2 right-2 p-1.5 bg-red-500 text-white rounded-full hover:bg-red-600 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <input type="file" name="image" x-ref="fileInput" 
                               @change="preview = URL.createObjectURL($event.target.files[0])" 
                               accept="image/png, image/jpeg, image/jpg, image/webp" 
                               class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400">
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Ganti gambar jika ingin mengubahnya. PNG, JPG, WEBP (Max. 5MB).</p>
                        @error('image')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Konten Trix --}}
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Isi Konten <span class="text-red-500">*</span></label>
                        <input id="content" type="hidden" name="content" value="{{ old('content', $task->content) }}">
                        <trix-editor input="content" class="trix-content bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"></trix-editor>
                        @error('content')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Urutan & Aktif --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Urutan Tampil</label>
                            <input type="number" name="order" value="{{ old('order', $task->order) }}" min="1" 
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Angka lebih kecil tampil lebih dulu.</p>
                            @error('order')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex items-center pt-8">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ old('is_active', $task->is_active) ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">Status Aktif</span>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Footer --}}
                <div class="flex items-center justify-between p-6 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50 rounded-b-lg">
                    <a href="{{ route('dashboard.tugas-fungsi.index') }}" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600 transition-colors">Batal</a>
                    <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 transition-colors">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
    <script>
        document.addEventListener("trix-file-accept", function(e) { 
            e.preventDefault(); 
        });
    </script>
</x-dashboard-layout>