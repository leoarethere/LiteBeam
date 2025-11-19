import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            // Tambahkan dashboard.js ke input
            input: [
                'resources/css/app.css', 
                'resources/js/app.js',
                'resources/js/dashboard.js' // File baru
            ],
            refresh: true,
        }),
    ],
});