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
    class="relative h-[70vh] md:h-[60vh] overflow-hidden rounded-xl md:rounded-2xl mb-8 shadow-lg"
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

    <div class="absolute inset-0 bg-black/60"></div>

    <div class="relative z-10 flex flex-col items-center justify-center h-full text-center px-4">
        <div class="max-w-screen-md">
            {{-- PERUBAHAN DI SINI --}}
            <h2 class="mb-4 text-3xl font-bold tracking-tight text-white sm:text-4xl">Temukan Wawasan Baru</h2>
            <p class="mx-auto mb-8 max-w-2xl font-light text-gray-200 md:mb-4 sm:text-xl">
                Apa yang ingin Anda pelajari hari ini? Ribuan artikel dan ide menanti untuk dijelajahi.
            </p>
            
            <form action="/posts" method="GET">
                @if (request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                @if (request('author'))
                    <input type="hidden" name="author" value="{{ request('author') }}">
                @endif
                <div class="items-center mx-auto mb-3 space-y-4 max-w-screen-sm sm:flex sm:space-y-0">
                    <div class="relative w-full">
                        <label for="search" class="hidden">Kata Kunci</label>
                        <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                        </div>
                        <input class="block p-3 pl-10 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 sm:rounded-none sm:rounded-l-lg focus:ring-primary-500 focus:border-primary-500" placeholder="Jelajahi topik, penulis, atau kata kunci..." type="search" id="search" name="search" value="{{ request('search') }}" autocomplete="off">
                    </div>
                    <div>
                        <button type="submit" class="py-3 px-5 w-full text-sm font-medium text-center text-white rounded-lg border cursor-pointer bg-primary-700 border-primary-600 sm:rounded-none sm:rounded-r-lg hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Cari</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>