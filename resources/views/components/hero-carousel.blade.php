@props(['slides' => []])

{{-- Early return jika tidak ada slides untuk mencegah error --}}
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
        autoplayDuration: 5000,

        resetAutoplay() {
            this.progress = 0;
            clearInterval(this.autoplayInterval);
            this.startAutoplay();
        },

        startAutoplay() {
            this.autoplayInterval = setInterval(() => {
                this.progress += 1;
                if (this.progress >= 100) {
                    this.nextSlide();
                }
            }, this.autoplayDuration / 100);
        },

        stopAutoplay() {
            clearInterval(this.autoplayInterval);
        },

        nextSlide() {
            this.activeSlide = (this.activeSlide + 1) % this.slides.length;
            this.progress = 0;
        },

        selectSlide(index) {
            this.activeSlide = index;
            this.resetAutoplay();
        }
    }"
    x-init="startAutoplay()"
    @mouseenter="stopAutoplay()"
    @mouseleave="startAutoplay()"
    {{-- ✅ PERBAIKAN: Menggunakan aspect-ratio untuk konsistensi --}}
    class="relative w-full aspect-[21/9] overflow-hidden rounded-xl md:rounded-2xl shadow-lg"
>

    {{-- Slides Container --}}
    <template x-for="(slide, index) in slides" :key="index">
        <div 
            x-show="activeSlide === index"
            x-transition:enter="transition ease-out duration-1000"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-700"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="absolute inset-0"
        >
            {{-- Background Image --}}
            <img :src="slide.image" 
                 class="h-full w-full object-cover transition-transform duration-[5000ms] ease-linear"
                 :class="{ 'scale-110': activeSlide === index, 'scale-100': activeSlide !== index }" 
                 :alt="slide.title"
                 loading="lazy">
            
            {{-- Gradient Overlay --}}
            <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/50 to-transparent"></div>
            
            {{-- Content - ✅ RESPONSIVE PADDING & FONT SIZES --}}
            <div class="absolute inset-0 flex items-center justify-start p-4 sm:p-8 md:p-12 lg:p-24 text-left text-white">
                <div x-show="activeSlide === index"
                     x-transition:enter="transition ease-out duration-1000 delay-300"
                     x-transition:enter-start="opacity-0 translate-y-8"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="max-w-xl">
                    
                    {{-- ✅ Heading: Mobile (text-xl) → Tablet (text-2xl) → Desktop (text-4xl) → Large (text-5xl) --}}
                    <h1 class="mb-2 sm:mb-3 md:mb-4 text-xl sm:text-2xl md:text-4xl lg:text-5xl font-bold" 
                        x-text="slide.title">
                    </h1>
                    
                    {{-- ✅ Subtitle: Responsive sizes + line clamp untuk mobile --}}
                    <p class="mb-4 sm:mb-6 md:mb-8 text-xs sm:text-sm md:text-base lg:text-lg text-gray-300 line-clamp-2 sm:line-clamp-3" 
                       x-text="slide.subtitle">
                    </p>
                    
                    {{-- ✅ Button: Responsive text & icon sizes --}}
                    <a :href="slide.link" 
                       class="group inline-flex items-center gap-1.5 sm:gap-2 text-xs sm:text-sm md:text-base font-semibold text-white transition-colors duration-300 hover:text-indigo-400">
                        <span x-text="slide.button_text || 'Selengkapnya'"></span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 sm:h-4 sm:w-4 md:h-5 md:w-5 transition-transform duration-300 group-hover:translate-x-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </template>

    {{-- Bottom Navigation - ✅ RESPONSIVE HEIGHT & FONT --}}
    <div class="absolute bottom-0 left-0 right-0 h-16 sm:h-20 md:h-24 bg-gradient-to-t from-black/60 to-transparent">
        <div class="absolute bottom-0 left-0 right-0 flex justify-center items-end space-x-2 sm:space-x-4 md:space-x-8 px-2 sm:px-4 pb-2 sm:pb-3 md:pb-4">
            <template x-for="(slide, index) in slides" :key="index">
                <button 
                    @click="selectSlide(index)" 
                    class="relative text-center py-1.5 sm:py-2 transition-colors duration-300 overflow-hidden group w-1/4 max-w-[120px] sm:max-w-[150px]"
                    :class="{
                        'text-white': activeSlide === index, 
                        'text-gray-400 hover:text-white': activeSlide !== index
                    }">
                    
                    {{-- ✅ Responsive font: 10px → 12px → 14px --}}
                    <span class="text-[10px] sm:text-xs md:text-sm font-medium truncate block" x-text="slide.title"></span>
                    
                    <div class="absolute bottom-0 left-0 w-full h-0.5 bg-white/20"></div>
                    
                    <div 
                        class="absolute bottom-0 left-0 h-0.5 bg-indigo-500"
                        :style="`width: ${activeSlide === index ? progress : (activeSlide > index ? 100 : 0)}%`">
                    </div>
                </button>
            </template>
        </div>
    </div>
</section>