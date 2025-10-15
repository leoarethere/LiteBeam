<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    {{-- Header Halaman --}}
    <div class="bg-gray-800 py-12">
        <div class="text-center">
            <h1 class="text-4xl font-bold tracking-tight text-white sm:text-6xl">Hubungi Kami</h1>
            <p class="mt-6 text-lg leading-8 text-gray-300">Kami senang mendengar dari Anda. Silakan isi form di bawah ini.</p>
        </div>
    </div>

    {{-- Konten Utama --}}
    <div class="py-8 px-4 lg:py-16 lg:px-6">
        {{-- Anda bisa meletakkan form kontak atau informasi lainnya di sini --}}
        <h3 class="text-2xl text-center text-gray-900 dark:text-white">Formulir Kontak Akan Ditampilkan di Sini</h3>
    </div>

</x-layout>
