// ============================================
// FILE: resources/js/app.js (REVISED)
// ============================================

import * as Turbo from '@hotwired/turbo';
import Alpine from 'alpinejs';
import './bootstrap';
import 'flowbite';

// Jadikan Alpine global
window.Alpine = Alpine;

// 1. Langsung start Alpine.js di awal.
// Ini hanya perlu dijalankan sekali saat aplikasi dimuat pertama kali.
Alpine.start();

// 2. Gunakan 'turbo:load' HANYA untuk me-reinisialisasi library pihak ketiga
// yang bergantung pada elemen DOM baru setelah navigasi Turbo.
document.addEventListener('turbo:load', () => {
    if (typeof initFlowbite === 'function') {
        initFlowbite();
    }
    console.log("Turbo loaded, Flowbite re-initialized.");
});

// 3. (OPSIONAL TAPI SANGAT DIANJURKAN) Bersihkan state Alpine sebelum Turbo
// me-render halaman baru untuk menghindari state yang tumpang tindih.
document.addEventListener('turbo:before-render', () => {
    document.querySelectorAll('[x-data]').forEach(el => {
        // Hapus atau reset komponen Alpine. Cara paling aman adalah:
        // Jika Anda menggunakan plugin Persist, Anda mungkin perlu penanganan khusus.
        // Untuk kasus umum, membiarkan Turbo mengganti body sudah cukup.
        // Baris di bawah ini adalah pembersihan agresif jika diperlukan.
        // el._x_dataStack = [{}];
        // el._x_ignore = true;
    });
});

// PENTING: Start Alpine setelah Turbo load
document.addEventListener('turbo:load', () => {
    // Initialize Alpine jika belum
    if (!Alpine.isInitialized) {
        Alpine.start();
        Alpine.isInitialized = true;
    }
    
    // Re-initialize Flowbite untuk elemen baru
    if (window.initFlowbite) {
        window.initFlowbite();
    }
    
    console.log('Turbo loaded page');
});

// Handle form submissions
document.addEventListener('turbo:submit-start', (event) => {
    console.log('Form submission started');
    // Bisa tambahkan loading indicator di sini
});

document.addEventListener('turbo:submit-end', (event) => {
    console.log('Form submission ended');
    // Hide loading indicator
});

// Handle errors
document.addEventListener('turbo:fetch-request-error', (event) => {
    console.error('Turbo fetch error:', event.detail);
});

// Clean up before cache
document.addEventListener('turbo:before-cache', () => {
    // Close dropdowns, modals, etc sebelum page di-cache
    document.querySelectorAll('[x-data]').forEach(el => {
        // Reset Alpine components jika perlu
    });
});

// ============================================
// OPTIONAL: Handle Alpine components properly
// ============================================
document.addEventListener('turbo:before-render', (event) => {
    // Cleanup Alpine before new page renders
    Alpine.destroyTree(document.body);
});

// ============================================
// FILE: resources/views/layouts/app.blade.php
// ============================================
/*
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="turbo-cache-control" content="no-cache">
    <title>{{ $title ?? 'My App' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    {{ $slot }}
</body>
</html>
*/

// ============================================
// USAGE EXAMPLES
// ============================================

// 1. BASIC LINK - Turbo akan intercept otomatis
// <a href="/dashboard">Dashboard</a>

// 2. DISABLE TURBO untuk link tertentu
// <a href="/download" data-turbo="false">Download</a>

// 3. TURBO FRAME - Load sebagian halaman
/*
<turbo-frame id="messages">
    <a href="/messages/1">Message 1</a>
</turbo-frame>
*/

// 4. TURBO STREAM - Real-time updates
/*
// Controller:
return turbo_stream([
    turbo_stream()->append('messages', view('messages.item', ['message' => $message]))
]);
*/

// 5. FORM dengan Turbo
/*
<form action="/posts" method="POST" data-turbo="true">
    @csrf
    <input type="text" name="title">
    <button type="submit">Submit</button>
</form>
*/

// ============================================
// KONFIGURASI TAMBAHAN
// ============================================

// Disable Turbo untuk elemen tertentu
Turbo.session.drive = true; // Enable/disable globally

// Custom progress bar
Turbo.setProgressBarDelay(100); // ms before showing

// Handle redirects
document.addEventListener('turbo:before-visit', (event) => {
    // Bisa cancel visit jika perlu
    // event.preventDefault();
});

// ============================================
// TROUBLESHOOTING TIPS
// ============================================

// 1. Jika Alpine tidak bekerja setelah navigasi:
//    - Pastikan Alpine.start() dipanggil di turbo:load
//    - Gunakan x-init untuk komponen yang butuh re-init

// 2. Jika Flowbite dropdown tidak bekerja:
//    - Panggil initFlowbite() di turbo:load

// 3. Jika form tidak submit:
//    - Tambahkan data-turbo="true" di form
//    - Atau data-turbo-method="post"

// 4. Jika ingin disable Turbo untuk halaman tertentu:
//    - Tambahkan <meta name="turbo-visit-control" content="reload">

// 5. Cache issues:
//    - Tambahkan turbo:before-cache event listener
//    - Atau set <meta name="turbo-cache-control" content="no-cache">

// ============================================
// INSTALL TURBO (jika belum)
// ============================================
/*
npm install @hotwired/turbo
npm run dev
*/

// ============================================
// LARAVEL CONTROLLER RESPONSE untuk Turbo
// ============================================
/*
// Regular redirect (Turbo akan handle)
return redirect()->route('dashboard');

// Turbo Stream response
use Tonysm\TurboLaravel\Http\TurboResponseFactory;

return TurboResponseFactory::make([
    turbo_stream()->append('posts', view('posts.item', ['post' => $post]))
]);

// Atau install package:
// composer require tonysm/turbo-laravel
*/