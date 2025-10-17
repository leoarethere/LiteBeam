<x-dashboard-layout>
    <x-slot:title>Tambah Banner Baru</x-slot:title>

    {{-- Cropper.js CSS --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" />

    <div class="pb-6"
        x-data="{
            imagePreview: null,
            cropper: null,
            isModalOpen: false,

            handleFileSelect(event) {
                const file = event.target.files[0];
                if (!file) return;

                const reader = new FileReader();
                reader.onload = (e) => {
                    this.imagePreview = e.target.result;
                    this.isModalOpen = true;
                    setTimeout(() => this.initCropper(), 50); 
                };
                reader.readAsDataURL(file);
            },

            initCropper() {
                if (this.cropper) {
                    this.cropper.destroy();
                }
                const image = this.$refs.imageToCrop;
                this.cropper = new Cropper(image, {
                    aspectRatio: 16 / 9,
                    viewMode: 1,
                    dragMode: 'move',
                    background: false,
                });
            },

            cropAndApply() {
                if (!this.cropper) return;

                // ✅ PERBAIKAN: Mengubah resolusi menjadi 1280x720 untuk mengurangi ukuran payload
                const highResCanvas = this.cropper.getCroppedCanvas({
                    width: 1280,
                    height: 720,
                    imageSmoothingEnabled: true,
                    imageSmoothingQuality: 'high',
                });
                
                // Menggunakan kualitas 85% untuk keseimbangan ukuran dan kualitas
                this.$refs.imageBase64.value = highResCanvas.toDataURL('image/jpeg', 0.85);

                // Preview tetap menggunakan resolusi rendah agar ringan
                const previewCanvas = this.cropper.getCroppedCanvas({
                    width: 640,
                    height: 360,
                });
                this.imagePreview = previewCanvas.toDataURL('image/jpeg', 0.85);

                this.isModalOpen = false;
                this.cropper.destroy();
                this.cropper = null;
            }
        }"
    >
        {{-- HEADER --}}
        <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4 mb-8 pt-2">
            <div>
                <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white">
                    Buat Banner Carousel Baru
                </h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Isi formulir, unggah gambar, lalu sesuaikan ukurannya.
                </p>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
            <form action="{{ route('banners.store') }}" method="POST" novalidate>
                @csrf
                <div class="p-6 space-y-6">

                    {{-- ✅ IMPROVISASI: Penampil semua error validasi --}}
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
                            Judul Banner <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="title" 
                               id="title" 
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" 
                               placeholder="e.g., Berita Terkini" 
                               value="{{ old('title') }}" 
                               required>
                        @error('title')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Subtitle --}}
                    <div>
                        <label for="subtitle" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Subtitle <span class="text-red-500">*</span>
                        </label>
                        <textarea name="subtitle" 
                                  id="subtitle" 
                                  rows="3" 
                                  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" 
                                  placeholder="Deskripsi singkat untuk banner..." 
                                  required>{{ old('subtitle') }}</textarea>
                        @error('subtitle')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Link URL --}}
                    <div>
                        <label for="link" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Tautan (URL) <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="link" 
                               id="link" 
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" 
                               placeholder="e.g., /posts atau https://example.com" 
                               value="{{ old('link') }}" 
                               required>
                         @error('link')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Teks Tombol --}}
                    <div>
                        <label for="button_text" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Teks Tombol
                        </label>
                        <input type="text" 
                               name="button_text" 
                               id="button_text" 
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" 
                               placeholder="e.g., Jelajahi Berita" 
                               value="{{ old('button_text', 'Selengkapnya') }}">
                        @error('button_text')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    {{-- Upload Gambar --}}
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Gambar Banner <span class="text-red-500">*</span>
                        </label>
                        
                        {{-- Preview Container --}}
                        <div class="mb-3">
                            <div class="relative w-full max-w-md mx-auto aspect-[16/9] rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center overflow-hidden border-2 border-dashed border-gray-300 dark:border-gray-600">
                                <template x-if="imagePreview">
                                    <img :src="imagePreview" alt="Preview" class="w-full h-full object-cover">
                                </template>
                                <template x-if="!imagePreview">
                                    <div class="text-center p-4">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Preview gambar</p>
                                    </div>
                                </template>
                            </div>
                        </div>

                        {{-- File Input --}}
                        <div>
                             <input id="image-upload" type="file" class="hidden" @change="handleFileSelect($event)" accept="image/png, image/jpeg, image/jpg, image/webp">
                             <label for="image-upload" class="cursor-pointer inline-flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                <span>Pilih Gambar...</span>
                            </label>
                        </div>

                        <input type="hidden" name="image_base64" x-ref="imageBase64">
                        
                        @error('image_base64')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">Gambar wajib diunggah dan dipotong.</p>
                        @enderror
                        
                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                            💡 Tips: Unggah gambar resolusi tinggi (min. 1280x720px) untuk hasil terbaik.
                        </p>
                    </div>

                    {{-- Urutan & Status --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="order" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Urutan</label>
                            <input type="number" name="order" id="order" min="0" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="0" value="{{ old('order', 0) }}">
                        </div>
                        
                        <div>
                            <label for="is_active" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
                            <select name="is_active" id="is_active" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <option value="1" @selected(old('is_active', 1) == 1)>Aktif</option>
                                <option value="0" @selected(old('is_active') == 0)>Tidak Aktif</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                {{-- Action Buttons --}}
                <div class="flex items-center justify-end gap-4 p-6 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50 rounded-b-lg">
                    <a href="{{ route('banners.index') }}" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600">Batal</a>
                    <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300">Simpan Banner</button>
                </div>
            </form>
        </div>

        {{-- Modal Cropping --}}
        <div x-show="isModalOpen" x-cloak class="fixed inset-0 z-50 bg-gray-900/75 backdrop-blur-sm flex items-center justify-center p-4" @keydown.escape.window="isModalOpen = false">
            <div @click.away="isModalOpen = false" class="bg-white dark:bg-gray-800 rounded-lg shadow-2xl w-full max-w-4xl flex flex-col max-h-[90vh]">
                <div class="p-4 border-b dark:border-gray-700 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Potong & Sesuaikan Gambar</h3>
                    <button type="button" @click="isModalOpen = false" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
                </div>
                <div class="p-6 flex-grow overflow-auto" @dblclick="cropAndApply()">
                    <img x-ref="imageToCrop" :src="imagePreview" class="block max-w-full max-h-[60vh]" alt="Image to crop">
                </div>
                <div class="p-4 flex justify-between items-center gap-3 border-t dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                    <div class="text-sm text-gray-600 dark:text-gray-400">
                        <span class="font-medium">💡 Tip:</span> Klik dua kali pada gambar untuk menyimpan.
                    </div>
                    <div class="flex gap-3">
                        <button type="button" @click="isModalOpen = false" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600">Batal</button>
                        <button type="button" @click="cropAndApply()" class="px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">Potong & Gunakan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Cropper.js Script --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
</x-dashboard-layout>