@php
    $message = null;
    $type = 'success';

    // Daftar kunci session (Sesuai dengan Controller Anda)
    $keys = [
        'post_success' => 'success', 
        'post_error' => 'error',
        'broadcast_success' => 'success', 
        'broadcast_error' => 'error',
        'success' => 'success',
        'error' => 'error'
    ];

    foreach ($keys as $key => $t) {
        if (session()->has($key)) {
            $message = session($key);
            $type = $t;
            break;
        }
    }

    if (!$message && $errors->any()) {
        $message = 'Terdapat kesalahan validasi. Mohon periksa inputan Anda.';
        $type = 'error';
    }
@endphp

@if($message)
    {{-- PERBAIKAN: ID diganti dari 'flash-message-trigger' menjadi 'notification-trigger' --}}
    {{-- Agar cocok dengan Javascript di dashboard-layout.blade.php --}}
    <div id="notification-trigger" 
         data-message="{{ $message }}" 
         data-type="{{ $type }}"
         style="display: none;">
    </div>
    
    {{-- DEBUG (Opsional): Hapus baris di bawah ini jika notifikasi sudah muncul --}}
    <script>console.log('📢 Server mengirim pesan: "{{ $message }}"');</script>
@endif