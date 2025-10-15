<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    {{-- KONTENER BARU DITAMBAHKAN DI SINI UNTUK MENYAMAKAN LEBAR FOOTER --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- SLIDER HERO YANG SEKARANG BERADA DI DALAM KONTENER --}}
        <section 
            x-data="{
                slides: [
                    {
                        image: 'https://images.unsplash.com/photo-1517976487612-6a751a84f2de?q=80&w=2070&auto=format&fit=crop',
                        title: 'Energy Solutions',
                        subtitle: 'Our role as a fully integrated energy provider is built on a dynamic value chain. We are able to meet increasing energy demands and contribute to a better tomorrow.',
                        link: '#'
                    },
                    {
                        image: 'https://images.unsplash.com/photo-1611002214172-24302d7c674c?q=80&w=2070&auto=format&fit=crop',
                        title: 'Passionate about Progress',
                        subtitle: 'Explore how the latest technology is shaping the future of our industry and our daily lives through sustainable innovation.',
                        link: '#'
                    },
                    {
                        image: 'https://images.unsplash.com/photo-1504198453319-c0ab8a9b143c?q=80&w=2070&auto=format&fit=crop',
                        title: 'Sustainable Value Creation',
                        subtitle: 'Join the global movement to create clean and environmentally friendly energy solutions for future generations.',
                        link: '#'
                    },
                    {
                        image: 'https://images.unsplash.com/photo-1473341304170-971d678c5769?q=80&w=2070&auto=format&fit=crop',
                        title: 'Carbon Management',
                        subtitle: 'Discover our commitment to managing carbon emissions and our journey towards a net-zero future.',
                        link: '#'
                    }
                ],
                activeSlide: 0,
                autoplay: null,
                startAutoplay() {
                    this.autoplay = setInterval(() => {
                        this.activeSlide = (this.activeSlide + 1) % this.slides.length;
                    }, 5000);
                },
                stopAutoplay() {
                    clearInterval(this.autoplay);
                }
            }"
            x-init="startAutoplay()"
            class="relative w-full h-[70vh] md:h-[60vh] overflow-hidden rounded-xl md:rounded-2xl"
        >
            <template x-for="(slide, index) in slides" :key="index">
                <div 
                    x-show="activeSlide === index"
                    x-transition:enter="transition ease-out duration-1000"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in duration-1000"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="absolute inset-0"
                >
                    <img :src="slide.image" class="w-full h-full object-cover" alt="Slider Image">
                    <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/60 to-transparent"></div>
                    <div class="absolute inset-0 flex items-center justify-start text-left text-white p-8 sm:p-12 md:p-24">
                        <div class="max-w-xl">
                            <h1 x-show="activeSlide === index" 
                                x-transition:enter="transition ease-out duration-1000 delay-200"
                                x-transition:enter-start="opacity-99 -translate-x-0"
                                x-transition:enter-end="opacity-99 translate-x-0"
                                class="text-4xl md:text-5xl font-bold tracking-tight mb-4" 
                                x-text="slide.title"></h1>
                            <p x-show="activeSlide === index" 
                                x-transition:enter="transition ease-out duration-1000 delay-400"
                                x-transition:enter-start="opacity-0 -translate-x-0"
                                x-transition:enter-end="opacity-99 translate-x-0"
                                class="text-base md:text-lg text-gray-300 mb-8" 
                                x-text="slide.subtitle"></p>
                            <a :href="slide.link" 
                                x-show="activeSlide === index"
                                x-transition:enter="transition ease-out duration-1000 delay-600"
                                x-transition:enter-start="opacity-0 -translate-x-0"
                                x-transition:enter-end="opacity-99 translate-x-0"
                                class="inline-flex items-center text-gray-200 font-semibold group">
                                Read more
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </template>

            <div 
                @mouseenter="stopAutoplay()"
                @mouseleave="startAutoplay()"
                class="absolute bottom-0 left-0 right-0 h-24 bg-gradient-to-t from-black/50 to-transparent">
                <div class="absolute bottom-0 left-0 right-0 flex justify-center items-end space-x-4 md:space-x-8 px-4 pb-4">
                    <template x-for="(slide, index) in slides" :key="index">
                        <button @click="activeSlide = index" 
                                class="relative text-center py-2 transition-colors duration-300 overflow-hidden"
                                :class="{
                                    'text-white': activeSlide === index, 
                                    'text-gray-400 hover:text-white': activeSlide !== index
                                }">
                            <span class="text-sm font-medium" x-text="slide.title"></span>
                            
                            <div class="absolute bottom-0 left-0 w-full h-0.5 bg-white/20"></div>
                            
                            <div x-show="activeSlide === index"
                                    :key="activeSlide"
                                    class="absolute bottom-0 left-0 h-0.5 bg-indigo-500 progress-bar-animate">
                            </div>
                        </button>
                    </template>
                </div>
            </div>
        </section>

    </div> {{-- PENUTUP UNTUK KONTENER BARU --}}

    {{-- CSS untuk Animasi Progress Bar --}}
    <style>
        @keyframes progress-animation {
            from { width: 0%; }
            to { width: 100%; }
        }
        .progress-bar-animate {
            animation: progress-animation 5s linear;
        }
    </style>

{{-- <div class="relative isolate overflow-hidden bg-gray-900 py-24 sm:py-32">
  <img src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&crop=focalpoint&fp-y=.8&w=2830&h=1500&q=80&blend=111827&sat=-100&exp=15&blend-mode=multiply" alt="" class="absolute inset-0 -z-10 size-full object-cover object-right md:object-center" />
  <div aria-hidden="true" class="hidden sm:absolute sm:-top-10 sm:right-1/2 sm:-z-10 sm:mr-10 sm:block sm:transform-gpu sm:blur-3xl">
    <div style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)" class="aspect-1097/845 w-274.25 bg-linear-to-tr from-[#ff4694] to-[#776fff] opacity-20"></div>
  </div>
  <div aria-hidden="true" class="absolute -top-52 left-1/2 -z-10 -translate-x-1/2 transform-gpu blur-3xl sm:-top-112 sm:ml-16 sm:translate-x-0">
    <div style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)" class="aspect-1097/845 w-274.25 bg-linear-to-tr from-[#ff4694] to-[#776fff] opacity-20"></div>
  </div>
  <div class="mx-auto max-w-7xl px-6 lg:px-8">
    <div class="mx-auto max-w-2xl lg:mx-0">
      <h2 class="text-5xl font-semibold tracking-tight text-white sm:text-7xl">Work with us</h2>
      <p class="mt-8 text-lg font-medium text-pretty text-gray-300 sm:text-xl/8">Anim aute id magna aliqua ad ad non deserunt sunt. Qui irure qui lorem cupidatat commodo. Elit sunt amet fugiat veniam occaecat fugiat.</p>
    </div>
    <div class="mx-auto mt-10 max-w-2xl lg:mx-0 lg:max-w-none">
      <div class="grid grid-cols-1 gap-x-8 gap-y-6 text-base/7 font-semibold text-white sm:grid-cols-2 md:flex lg:gap-x-10">
        <a href="#">Open roles <span aria-hidden="true">&rarr;</span></a>
        <a href="#">Internship program <span aria-hidden="true">&rarr;</span></a>
        <a href="#">Our values <span aria-hidden="true">&rarr;</span></a>
        <a href="#">Meet our leadership <span aria-hidden="true">&rarr;</span></a>
      </div>
      <dl class="mt-16 grid grid-cols-1 gap-8 sm:mt-20 sm:grid-cols-2 lg:grid-cols-4">
        <div class="flex flex-col-reverse gap-1">
          <dt class="text-base/7 text-gray-300">Offices worldwide</dt>
          <dd class="text-4xl font-semibold tracking-tight text-white">12</dd>
        </div>
        <div class="flex flex-col-reverse gap-1">
          <dt class="text-base/7 text-gray-300">Full-time colleagues</dt>
          <dd class="text-4xl font-semibold tracking-tight text-white">300+</dd>
        </div>
        <div class="flex flex-col-reverse gap-1">
          <dt class="text-base/7 text-gray-300">Hours per week</dt>
          <dd class="text-4xl font-semibold tracking-tight text-white">40</dd>
        </div>
        <div class="flex flex-col-reverse gap-1">
          <dt class="text-base/7 text-gray-300">Paid time off</dt>
          <dd class="text-4xl font-semibold tracking-tight text-white">Unlimited</dd>
        </div>
      </dl>
    </div>
  </div>
</div> --}}


</x-layout>