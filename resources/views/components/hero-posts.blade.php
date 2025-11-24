<section 
    x-data="{
        slides: [
            { image: 'https://images.unsplash.com/photo-1488190211105-8b0e65b80b4e?q=80&w=2070&auto=format&fit=crop' },
            { image: 'https://images.unsplash.com/photo-1499750310107-5fef28a66643?q=80&w=2070&auto=format&fit=crop' },
            { image: 'https://images.unsplash.com/photo-1457369804613-52c61a468e7d?q=80&w=2070&auto=format&fit=crop' },
            { image: 'https://images.unsplash.com/photo-1522204523234-8729aa6e3d5f?q=80&w=2070&auto=format&fit=crop' }
        ],
        activeSlide: 0,
        autoplay: null,
        startAutoplay() {
            this.autoplay = setInterval(() => {
                this.activeSlide = (this.activeSlide + 1) % this.slides.length;
            }, 2000);
        }
    }"
    x-init="startAutoplay()"
    {{-- ✅ PERBAIKAN: Menggunakan aspect-ratio untuk konsistensi --}}
    class="relative w-full aspect-[16/9] md:aspect-[21/9] overflow-hidden rounded-xl md:rounded-2xl mb-8 shadow-lg"
>
    {{-- Latar Belakang Gambar Slider --}}
    <template x-for="(slide, index) in slides" :key="index">
        <div 
            x-show="activeSlide === index"
            x-transition:enter="transition ease-out duration-1000"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-500"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="absolute inset-0"
        >
            <img :src="slide.image" class="w-full h-full object-cover" alt="Hero Background">
        </div>
    </template>

    <div class="absolute inset-0 bg-black/50"></div>

    {{-- ✅ PERBAIKAN: Responsive padding --}}
    <div class="relative z-10 flex flex-col items-center justify-center h-full text-center px-4 sm:px-6">
        <div class="max-w-screen-md w-full">
            {{-- ✅ Heading: Mobile (text-2xl) → Tablet (text-3xl) → Desktop (text-4xl) --}}
            <h2 class="mb-3 sm:mb-4 text-2xl sm:text-3xl md:text-4xl font-bold tracking-tight text-white">Cari Postingan</h2>
            
            {{-- ✅ Subtitle: Responsive font sizes --}}
            <p class="mx-auto mb-4 sm:mb-6 md:mb-8 max-w-2xl text-sm sm:text-base md:text-lg font-light text-gray-100">
                Jelajahi postingan terbaru, penulis favorit, dan kategori yang sesuai dengan minat Anda.
            </p>
            
            {{-- ✅ PERBAIKAN: FORM PENCARIAN YANG LEBIH RESPONSIVE --}}
            <form action="{{ route('posts.index') }}" method="GET">
                {{-- ✅ SIMPAN PARAMETER FILTER YANG SUDAH ADA --}}
                @if (request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                @if (request('author'))
                    <input type="hidden" name="author" value="{{ request('author') }}">
                @endif
                @if (request('sort'))
                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                @endif
                
                {{-- ✅ Responsive spacing & layout --}}
                <div class="items-center mx-auto mb-3 space-y-3 max-w-screen-sm sm:flex sm:gap-2">
                    <div class="relative w-full">
                        <label for="search" class="hidden mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Cari</label>
                        
                        {{-- ✅ Responsive icon size --}}
                        <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        
                        {{-- ✅ Responsive input: padding & font size --}}
                        <input 
                            class="block p-3 sm:p-4 pl-9 sm:pl-10 w-full text-xs sm:text-sm text-gray-900 bg-white rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" 
                            placeholder="Cari judul, penulis, kategori..." 
                            type="search" 
                            id="search" 
                            name="search" 
                            value="{{ request('search') }}" 
                            autocomplete="off"
                            required
                        >
                    </div>
                    
                    {{-- ✅ Button: Full width di mobile, auto di desktop --}}
                    <div class="w-full sm:w-auto">
                        <button type="submit" class="py-3 sm:py-4 px-5 sm:px-6 w-full text-xs sm:text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition-colors">
                            Cari
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>