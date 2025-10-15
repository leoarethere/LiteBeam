<x-layout>
    <x-slot:title>Halaman Home</x-slot:title>

    @php
      $slides = [
        ['image'=>asset('images/hero1.jpg'),'title'=>'Judul 1','subtitle'=>'Deskripsi 1','cta'=>['url'=>'#','text'=>'Learn more']],
        ['image'=>asset('images/hero2.jpg'),'title'=>'Judul 2','subtitle'=>'Deskripsi 2','cta'=>['url'=>'#','text'=>'Discover']],
      ];
    @endphp

    <x-hero-carousel :slides="$slides" />
</x-layout>
