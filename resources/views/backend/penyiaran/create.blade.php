<x-dashboard-layout>
    <x-slot:title>Buat Penyiaran Baru</x-slot:title>

    <div class="pb-6"
        {{-- Alpine.js untuk generate slug --}}
        x-data="{
            title: '{{ old('title') }}',
            slug: '{{ old('slug') }}',
            
            generateSlug() {
                this.slug = this.title
                    .toLowerCase()
                    .replace(/[^a-z0-9\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-')
                    .trim();
            }
        }"
    >
        {{-- HEADER --}}
        <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4 mb-8 pt-2">
            <div>
                <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white">
                    Buat Penyiaran Baru
                </h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Isi detail untuk rilis, siaran, atau pengumuman baru.
                </p>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
            <form action="{{ route('dashboard.broadcasts.store') }}" method="POST" enctype="multipart/form-data">
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
                    
                    {{-- Judul Penyiaran --}}
                    <div>
                        <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Nama Siaran / Judul <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                            name="title" 
                            id="title" 
                            x-model="title"
                            @input.debounce.500ms="generateSlug()"
                            class="bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white {{ $errors->has('title') ? 'border-red-500' : 'border-gray-300' }}" 
                            placeholder="Masukkan judul penyiaran..." 
                            value="{{ old('title') }}" 
                            required
                            autofocus>
                        @error('title')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Slug --}}
                    <div>
                        <label for="slug" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Slug URL <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                                name="slug" 
                                id="slug" 
                                x-model="slug"
                                class="bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white {{ $errors->has('slug') ? 'border-red-500' : 'border-gray-300' }}" 
                                placeholder="slug-url-penyiaran" 
                                value="{{ old('slug') }}" 
                                required>
                        @error('slug')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Kategori Penyiaran --}}
                    <div>
                        <label for="broadcast_category_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Kategori <span class="text-red-500">*</span>
                        </label>
                        <select name="broadcast_category_id" 
                                id="broadcast_category_id" 
                                class="bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white {{ $errors->has('broadcast_category_id') ? 'border-red-500' : 'border-gray-300' }}" 
                                required>
                            <option value="">Pilih Kategori...</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('broadcast_category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('broadcast_category_id')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Link Youtube --}}
                    <div>
                        <label for="youtube_link" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Link Youtube (Opsional)
                        </label>
                        <input type="url" name="youtube_link" id="youtube_link"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                            placeholder="https://www.youtube.com/watch?v=xxxxxx" value="{{ old('youtube_link') }}">
                        @error('youtube_link')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Sinopsis --}}
                    <div>
                        <label for="synopsis" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Sinopsis (Opsional)
                        </label>
                        <textarea name="synopsis" 
                                  id="synopsis" 
                                  rows="5" 
                                  class="bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" 
                                  placeholder="Ringkasan singkat tentang siaran ini...">{{ old('synopsis') }}</textarea>
                        @error('synopsis')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Poster --}}
                    <div x-data="{ preview: null }">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Poster (Opsional)
                        </label>
                        
                        {{-- Preview --}}
                        <div class="mb-3" x-show="preview">
                            <div class="relative w-full max-w-md">
                                <img :src="preview" class="w-full h-auto object-cover rounded-lg border-2 border-gray-300 dark:border-gray-600" style="aspect-ratio: 9/12">
                                <button type="button" 
                                        @click="preview = null; $refs.fileInput.value = ''"
                                        class="absolute top-2 right-2 p-1.5 bg-red-500 text-white rounded-full hover:bg-red-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        {{-- File Input --}}
                        <input type="file" 
                               name="poster" 
                               id="poster"
                               x-ref="fileInput"
                               @change="preview = URL.createObjectURL($event.target.files[0])"
                               accept="image/png, image/jpeg, image/jpg, image/webp"
                               class="block w-full text-sm text-gray-900 border rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 {{ $errors->has('poster') ? 'border-red-500' : 'border-gray-300' }}">
                        
                        @error('poster')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                        
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            PNG, JPG, WEBP (MAX. 10MB).
                        </p>
                    </div>
                    
                    {{-- Tanggal Publikasi --}}
                    <div>
                        <label for="published_at" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Tanggal Publikasi
                        </label>
                        <input type="datetime-local" 
                               name="published_at" 
                               id="published_at" 
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" 
                               value="{{ old('published_at', now()->format('Y-m-d\TH:i')) }}">
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            Akan diisi otomatis saat dipublikasikan jika dibiarkan kosong.
                        </p>
                    </div>

                </div>
                
                {{-- Action Buttons --}}
                <div class="flex items-center justify-between p-6 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50 rounded-b-lg">
                    <a href="{{ route('dashboard.broadcasts.index') }}" 
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
</x-dashboard-layout>