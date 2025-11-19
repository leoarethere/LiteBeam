@props(['href', 'mobile' => false])

@php
    // Cek apakah link ini sedang aktif.
    // Menangani kasus homepage ('/') dan halaman lainnya secara dinamis.
    $active = ($href === '/') ? request()->is('/') : request()->is(ltrim($href, '/'));
@endphp

{{-- Saya mengubah text-sm (14px) menjadi text-base (16px).Jika Anda ingin ukuran yang lebih besar lagi, Anda bisa menggunakan text-lg (18px). --}}

<a href="{{ $href }}"
   class="{{-- PERUBAHAN 2: Tambahkan 'underline' dan 'underline-offset-4' di sini --}}
          {{ $active ? 'text-white underline underline-offset-4' : 'text-gray-300 hover:bg-white/5 hover:text-white' }} 
          {{-- PERUBAHAN 1: Ubah 'text-sm' menjadi 'text-base' di sini --}}
          {{ $mobile ? 'block text-base' : 'text-base' }} 
          {{-- rounded-md px-3 py-2 font-medium transition-colors duration-200 ease-in-out" --}}
   aria-current="{{ $active ? 'page' : 'false' }}">
    {{ $slot }}
</a>