<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="px-4 sm:px-6 lg:px-8 pt-8">

        {{-- Judul Halaman Dinamis --}}
        <h1 class="text-3xl font-bold tracking-tight text-gray-100 sm:text-4xl mb-8 border-b border-gray-700 pb-4">
            {{ $title }}
        </h1>

        {{-- Grid untuk Menampilkan Postingan --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-8">
            @forelse ($posts as $post)
                {{-- 
                    Memanggil komponen Post Card yang sudah ada untuk menampilkan setiap post.
                    Ini membuat kode lebih bersih dan mudah dikelola.
                --}}
                <x-post-card :post="$post" />
            @empty
                {{-- Pesan yang ditampilkan jika tidak ada postingan ditemukan --}}
                <div class="md:col-span-2 lg:col-span-3 text-center py-16">
                    <div class="inline-block p-4 bg-gray-700/50 rounded-full mb-4">
                        <svg class="w-12 h-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-semibold text-gray-300">Belum Ada Postingan</h3>
                    <p class="text-gray-500 mt-2">Tidak ada postingan yang ditemukan di sini. Coba kembali lagi nanti.</p>
                    <a href="/posts" class="mt-6 inline-block px-5 py-3 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">
                        Lihat Semua Postingan
                    </a>
                </div>
            @endforelse
        </div>

        {{-- Tautan Paginasi --}}
        <div class="mt-4">
            {{ $posts->links() }}
        </div>

    </div>
</x-layout>