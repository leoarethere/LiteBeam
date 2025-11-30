{{-- 1. Terima data posts sebagai props --}}
@props(['posts' => collect()]) 

@php
    use Illuminate\Support\Facades\Storage;

    // 2. Transformasi data Post Database ke format JSON untuk AlpineJS
    $slidesData = $posts->map(function($post) {
        return [
            // Pastikan menggunakan Storage::url untuk mendapatkan path gambar yang benar
            'image' => $post->featured_image ? Storage::url($post->featured_image) : null,
            'title' => $post->title,
            'link'  => route('posts.show', $post->slug)
        ];
    })->filter(fn($slide) => $slide['image'] != null)->values(); // Hapus yang gambarnya null

    // 3. Fallback: Jika tidak ada postingan, pakai gambar default Unsplash
    if ($slidesData->isEmpty()) {
        $slidesData = collect([
            ['image' => 'https://images.unsplash.com/photo-1488190211105-8b0e65b80b4e?q=80&w=2070&auto=format&fit=crop', 'title' => 'Berita Terkini', 'link' => '#'],
            ['image' => 'https://images.unsplash.com/photo-1499750310107-5fef28a66643?q=80&w=2070&auto=format&fit=crop', 'title' => 'Informasi Publik', 'link' => '#'],
            ['image' => 'https://images.unsplash.com/photo-1457369804613-52c61a468e7d?q=80&w=2070&auto=format&fit=crop', 'title' => 'Layanan TVRI', 'link' => '#'],
        ]);
    }
@endphp

<section 
    x-data="{
        {{-- 4. Inject Data PHP ke Alpine JS --}}
        slides: {{ Js::from($slidesData) }},
        activeSlide: 0,
        autoplay: null,
        startAutoplay() {
            this.autoplay = setInterval(() => {
                this.activeSlide = (this.activeSlide + 1) % this.slides.length;
            }, 5000);
        }
    }"
    x-init="startAutoplay()"
    class="relative w-full min-h-[400px] sm:min-h-[450px] md:min-h-[500px] aspect-[4/3] sm:aspect-[16/9] lg:aspect-[21/9] overflow-hidden rounded-2xl shadow-2xl group"
>
    {{-- Background Image Slideshow --}}
    <template x-for="(slide, index) in slides" :key="index">
        <div 
            class="absolute inset-0 transition-opacity duration-1000 ease-in-out bg-cover bg-center"
            :class="{ 'opacity-100': activeSlide === index, 'opacity-0': activeSlide !== index }"
            :style="`background-image: url('${slide.image}')`"
        >
            {{-- Gradient Overlay --}}
            <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/50 to-black/20 sm:to-transparent"></div>
        </div>
    </template>

    {{-- Konten Overlay --}}
    <div class="absolute inset-0 flex flex-col items-center justify-center text-center px-4 sm:px-6 md:px-12 z-10">
        
        {{-- Judul Dinamis (Opsional: Munculkan judul postingan jika slide aktif) --}}
        <template x-for="(slide, index) in slides" :key="index">
            <h1 x-show="activeSlide === index"
                x-transition:enter="transition ease-out duration-500"
                x-transition:enter-start="opacity-0 translate-y-5"
                x-transition:enter-end="opacity-100 translate-y-0"
                class="text-2xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold text-white mb-3 sm:mb-6 tracking-tight drop-shadow-lg leading-tight"
            >
                <span x-text="slide.title || 'Temukan Informasi Terkini'"></span>
            </h1>
        </template>
        
        <p class="hidden sm:block text-sm sm:text-lg md:text-xl text-gray-200 mb-6 sm:mb-8 max-w-2xl drop-shadow-md">
            Jelajahi postingan terbaru, dan ragam kategori yang sesuai dengan Anda.
        </p>

        {{-- Form Pencarian --}}
        <div class="w-full max-w-md sm:max-w-lg lg:max-w-2xl mx-auto">
            <form action="{{ route('posts.index') }}" method="GET" class="relative">
                @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif

                <div class="relative flex items-center group">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 sm:pl-5 pointer-events-none">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-500 dark:text-gray-400 group-focus-within:text-blue-500 transition-colors" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                    </div>

                    <input 
                        type="search" 
                        id="search" 
                        name="search" 
                        value="{{ request('search') }}"
                        class="block w-full py-3 sm:py-4 pl-10 sm:pl-14 pr-24 sm:pr-32 text-sm sm:text-base text-gray-900 border-none rounded-full bg-white/95 focus:ring-4 focus:ring-blue-500/50 placeholder-gray-500 shadow-lg backdrop-blur-sm transition-all" 
                        placeholder="Cari berita..." 
                        autocomplete="off"
                        required 
                    >

                    <button type="submit" class="absolute right-1.5 sm:right-2.5 bottom-1.5 sm:bottom-2.5 bg-blue-600 hover:bg-blue-700 text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-xs sm:text-sm px-4 sm:px-6 py-2 sm:py-2 transition-colors shadow-md">
                        Cari
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Indikator Slide (Dots) --}}
    <div class="absolute bottom-4 sm:bottom-8 left-1/2 transform -translate-x-1/2 flex space-x-2 sm:space-x-3 z-10">
        <template x-for="(slide, index) in slides" :key="index">
            <button 
                @click="activeSlide = index; clearInterval(autoplay); startAutoplay();"
                class="h-1.5 sm:h-2 rounded-full transition-all duration-300 shadow-sm backdrop-blur-sm"
                :class="activeSlide === index ? 'bg-blue-500 w-6 sm:w-8' : 'bg-white/50 w-1.5 sm:w-2 hover:bg-white'"
                :aria-label="`Slide ${index + 1}`"
            ></button>
        </template>
    </div>
</section>