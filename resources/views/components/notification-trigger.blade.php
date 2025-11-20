@php
    $message = null;
    $type = 'success';

    // Daftar semua kunci session yang mungkin dikirim oleh Controller Anda
    $keys = [
        'post_success' => 'success', 
        'post_error' => 'error',
        'broadcast_success' => 'success', 
        'broadcast_error' => 'error',
        'category_success' => 'success', 
        'category_error' => 'error',
        'success' => 'success', // Default
        'error' => 'error'      // Default
    ];

    // Cari pesan yang aktif
    foreach ($keys as $key => $t) {
        if (session()->has($key)) {
            $message = session($key);
            $type = $t;
            break;
        }
    }

    // Cek juga error validasi standar Laravel ($errors)
    if (!$message && $errors->any()) {
        $message = 'Terdapat kesalahan validasi. Mohon periksa kembali form.';
        $type = 'error';
    }
@endphp

{{-- Jika ada pesan, render elemen rahasia ini --}}
@if($message)
    <div id="flash-message-trigger" 
         data-message="{{ $message }}" 
         data-type="{{ $type }}"
         style="display: none;">
    </div>
@endif