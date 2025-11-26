{{-- 
    Component: responsive-image
    Usage: <x-responsive-image :path="$post->featured_image" :alt="$post->title" />
--}}

@props([
    'path' => null,
    'alt' => '',
    'sizes' => '(max-width: 640px) 300px, (max-width: 1024px) 600px, 1200px',
    'loading' => 'lazy',
    'class' => 'w-full h-full object-cover',
])

@php
    $imageService = app(\App\Services\ImageService::class);
    
    // Jika tidak ada path, gunakan placeholder
    if (!$path || !Storage::exists($path)) {
        $placeholder = true;
    } else {
        $placeholder = false;
        
        // Extract filename pattern
        $filename = preg_replace('/-\w+\.(jpg|webp)$/', '', basename($path));
        $folder = dirname($path);
        
        // Build URLs untuk different sizes
        $thumbJpg = Storage::url("{$folder}/{$filename}-thumbnail.jpg");
        $mediumJpg = Storage::url("{$folder}/{$filename}-medium.jpg");
        $largeJpg = Storage::url("{$folder}/{$filename}-large.jpg");
        
        $thumbWebp = Storage::url("{$folder}/{$filename}-thumbnail.webp");
        $mediumWebp = Storage::url("{$folder}/{$filename}-medium.webp");
        $largeWebp = Storage::url("{$folder}/{$filename}-large.webp");
        
        // Check jika WebP versions exist
        $hasWebp = Storage::exists("{$folder}/{$filename}-thumbnail.webp");
    }
@endphp

@if($placeholder)
    {{-- Placeholder SVG jika tidak ada gambar --}}
    <div class="{{ $class }} flex items-center justify-center bg-gray-100 dark:bg-gray-700">
        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
        </svg>
    </div>
@else
    {{-- Responsive Picture Element --}}
    <picture>
        @if($hasWebp)
            {{-- WebP sources (modern browsers) --}}
            <source 
                type="image/webp" 
                srcset="{{ $thumbWebp }} 300w, {{ $mediumWebp }} 768w, {{ $largeWebp }} 1200w"
                sizes="{{ $sizes }}">
        @endif
        
        {{-- JPG fallback (older browsers) --}}
        <source 
            type="image/jpeg" 
            srcset="{{ $thumbJpg }} 300w, {{ $mediumJpg }} 768w, {{ $largeJpg }} 1200w"
            sizes="{{ $sizes }}">
        
        {{-- Default img tag --}}
        <img 
            src="{{ $largeJpg }}" 
            alt="{{ $alt }}" 
            class="{{ $class }}"
            loading="{{ $loading }}"
            decoding="async"
            {{-- Low Quality Image Placeholder (LQIP) --}}
            @if($loading === 'lazy')
                style="background: linear-gradient(to right, #f3f4f6 0%, #e5e7eb 50%, #f3f4f6 100%); background-size: 200% 100%; animation: shimmer 1.5s infinite;"
            @endif
        >
    </picture>

    {{-- CSS Animation untuk loading placeholder --}}
    @once
        <style>
            @keyframes shimmer {
                0% { background-position: -200% 0; }
                100% { background-position: 200% 0; }
            }
        </style>
    @endonce
@endif