<x-dashboard-layout>
    <x-slot:title>Tambah Data Sejarah</x-slot:title>

    {{-- CSS Trix --}}
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
    <style>
        trix-toolbar [data-trix-button-group="file-tools"] {
            display: none;
        }
        .dark trix-editor {
            background-color: #374151;
            color: white;
            border-color: #4b5563;
        }
        .dark trix-toolbar {
            background-color: #f3f4f6;
            border-radius: 0.5rem;
            margin-bottom: 0.5rem;
        }
        trix-editor {
            min-height: 250px;
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
    </style>

    <div class="pb-6">
        {{-- HEADER --}}
        <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4 mb-8 pt-2">
            <div>
                <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white">
                    Tambah Data Sejarah
                </h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Tambahkan peristiwa bersejarah TVRI Yogyakarta
                </p>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
            <form action="{{ route('dashboard.sejarah.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="p-6 space-y-6">

                    {{-- Error Summary --}}
                    @if ($errors->any())
                        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 border border-red-300 dark:border-red-900" role="alert">
                            <div class="font-medium mb-2">Oops! Ada beberapa kesalahan:</div>
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    {{-- Judul --}}
                    <div>
                        <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Judul <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                            name="title" 
                            id="title" 
                            class="bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white {{ $errors->has('title') ? 'border-red-500' : 'border-gray-300' }}" 
                            placeholder="Contoh: Berdirinya TVRI Stasiun Yogyakarta" 
                            value="{{ old('title') }}" 
                            required
                            autofocus>
                        @error('title')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Konten dengan Trix Editor --}}
                    <div>
                        <label for="content" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Deskripsi / Konten <span class="text-red-500">*</span>
                        </label>
                        
                        <input id="content" type="hidden" name="content" value="{{ old('content') }}">

                        <trix-editor input="content" 
                                     class="trix-content bg-gray-50 border-gray-300 text-gray-900 text-sm rounded-lg min-h-[250px] focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                                     placeholder="Tulis deskripsi lengkap tentang peristiwa bersejarah ini..."></trix-editor>
                        
                        @error('content')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Gambar Ilustrasi --}}
                    <div x-data="{ preview: null }">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Gambar Ilustrasi (Opsional)
                        </label>
                        <div class="mb-3" x-show="preview">
                            <div class="relative w-full max-w-md">
                                <img :src="preview" class="w-full h-48 object-cover rounded-lg border-2 border-gray-300 dark:border-gray-600">
                                <button type="button" 
                                        @click="preview = null; $refs.fileInput.value = ''"
                                        class="absolute top-2 right-2 p-1.5 bg-red-500 text-white rounded-full hover:bg-red-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <input type="file" 
                               name="image" 
                               id="image"
                               x-ref="fileInput"
                               @change="preview = URL.createObjectURL($event.target.files[0])"
                               accept="image/png, image/jpeg, image/jpg, image/webp"
                               class="block w-full text-sm text-gray-900 border rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 {{ $errors->has('image') ? 'border-red-500' : 'border-gray-300' }}">
                        @error('image')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            Upload gambar dokumentasi atau ilustrasi terkait peristiwa ini (Max 5MB)
                        </p>
                    </div>
                </div>
                
                {{-- Action Buttons --}}
                <div class="flex items-center justify-between p-6 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50 rounded-b-lg">
                    <a href="{{ route('dashboard.sejarah.index') }}" 
                       class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600 transition-colors">
                        Batal
                    </a>
                    <div class="flex gap-3">
                        <button type="submit" 
                                name="action" 
                                value="draft"
                                class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600 transition-colors">
                            Simpan sebagai Draft
                        </button>
                        <button type="submit" 
                                name="action" 
                                value="publish"
                                class="px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition-colors">
                            Publikasikan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Script Trix --}}
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
    <script>
        document.addEventListener("trix-file-accept", function(event) {
            event.preventDefault();
        });
    </script>
</x-dashboard-layout>