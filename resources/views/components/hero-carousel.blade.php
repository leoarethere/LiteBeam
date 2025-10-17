@props(['slides' => []])

{{-- Early return jika tidak ada slides --}}
@if(empty($slides))
    <div class="bg-gray-100 dark:bg-gray-800 rounded-lg h-96 flex items-center justify-center">
        <p class="text-gray-500 dark:text-gray-400">No slides available</p>
    </div>
    @php return; @endphp
@endif

<section 
    x-data="{
        slides: {{ json_encode($slides) }},
        activeSlide: 0,
        progress: 0,
        autoplayInterval: null,
        autoplayDuration: 5000, // Durasi dalam milidetik (5 detik)

        // Fungsi untuk memulai autoplay
        startAutoplay() {
            this.autoplayInterval = setInterval(() => {
                this.progress += 1; // Tingkatkan progress
                if (this.progress >= 100) {
                    this.nextSlide();
                }
            }, this.autoplayDuration / 100); // Update setiap 50ms untuk animasi halus
        },

        // Fungsi untuk menghentikan autoplay
        stopAutoplay() {
            clearInterval(this.autoplayInterval);
        },

        // Fungsi untuk pindah ke slide berikutnya
        nextSlide() {
            this.activeSlide = (this.activeSlide + 1) % this.slides.length;
            this.progress = 0; // Reset progress
        },

        // Fungsi untuk memilih slide tertentu
        selectSlide(index) {
            this.activeSlide = index;
            this.progress = 0;
            // Restart interval agar timer dimulai dari awal
            this.stopAutoplay();
            this.startAutoplay();
        }
    }"
    x-init="startAutoplay()"
    @mouseenter="stopAutoplay()"
    @mouseleave="startAutoplay()"
    class="relative w-full h-[70vh] md:h-[60vh] overflow-hidden rounded-xl md:rounded-2xl shadow-lg"
>

    {{-- Slides Container --}}
    <template x-for="(slide, index) in slides" :key="index">
        <div 
            x-show="activeSlide === index"
            x-transition:enter="transition ease-out duration-1000"
            x-transition:enter-start="opacity-50"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-700"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="absolute inset-0"
        >
            {{-- Background Image dengan efek Ken Burns (zoom halus) --}}
            <img :src="slide.image" 
                class="h-full w-full object-cover transition-transform duration-[6000ms] ease-linear"
                :class="{ 'scale-110': activeSlide === index }" 
                :alt="slide.title"
                loading="lazy">
            
            {{-- Gradient Overlay --}}
            <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/50 to-transparent"></div>
            
            {{-- Content --}}
            <div class="absolute inset-0 flex items-center justify-start p-8 text-left text-white sm:p-12 md:p-24">
                <div class="max-w-xl">
                    {{-- Animasi konten yang lebih halus (slide up + fade in) --}}
                    <h1 x-show="activeSlide === index" 
                        x-transition:enter="transition ease-out duration-700 delay-300"
                        x-transition:enter-start="opacity-0 translate-y-4"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        class="mb-4 text-4xl font-bold tracking-tight md:text-5xl" 
                        x-text="slide.title">
                    </h1>
                    
                    <p x-show="activeSlide === index" 
                    x-transition:enter="transition ease-out duration-700 delay-500"
                    x-transition:enter-start="opacity-0 translate-y-4"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="mb-8 text-base text-gray-300 md:text-lg" 
                    x-text="slide.subtitle">
                    </p>
                    
                    {{-- ✅ INI PERUBAHANNYA --}}
                    <a :href="slide.link" 
                    x-show="activeSlide === index"
                    x-transition:enter="transition ease-out duration-700 delay-700"
                    x-transition:enter-start="opacity-0 translate-y-4"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="group inline-flex items-center gap-2 font-semibold text-white transition-colors duration-300 hover:text-indigo-400">
                        <span x-text="slide.button_text || 'Selengkapnya'"></span>
                        {{-- Ikon panah dengan animasi hover --}}
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform duration-300 group-hover:translate-x-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </template>

    {{-- Bottom Navigation with Progress Bars --}}
    <div class="absolute bottom-0 left-0 right-0 h-24 bg-gradient-to-t from-black/60 to-transparent">
        <div class="absolute bottom-0 left-0 right-0 flex justify-center items-end space-x-4 md:space-x-8 px-4 pb-4">
            <template x-for="(slide, index) in slides" :key="index">
                <button 
                    @click="selectSlide(index)" 
                    class="relative text-center py-2 transition-colors duration-300 overflow-hidden group w-1/4 max-w-[150px]"
                    :class="{
                        'text-white': activeSlide === index, 
                        'text-gray-200 hover:text-white': activeSlide !== index
                    }">
                    
                    <span class="text-sm font-medium truncate" x-text="slide.title"></span>
                    
                    <div class="absolute bottom-0 left-0 w-full h-0.5 bg-white/20"></div>
                    
                    {{-- ✅ PERBAIKAN: Progress bar dikontrol oleh JavaScript, bukan CSS --}}
                    <div 
                        class="absolute bottom-0 left-0 h-0.5 bg-indigo-500"
                        :style="`width: ${activeSlide === index ? progress : 0}%`">
                    </div>
                </button>
            </template>
        </div>
    </div>
</section>