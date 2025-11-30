<!DOCTYPE html>
<html lang="id" class="h-full bg-white dark:bg-gray-900">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Login' }}</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    {{-- Google Sans Flex Font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Google+Sans+Flex:opsz,wght@6..144,1..1000&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: "Google Sans Flex", sans-serif;
        }
    </style>
</head>
<body class="h-full font-google-sans antialiased text-gray-900 dark:text-white">

    <div class="w-full min-h-screen grid grid-cols-1 lg:grid-cols-2">
        
        {{-- BAGIAN 1: Banner Image (Tampil Full di Desktop, Sembunyi di Mobile) --}}
        <div class="relative hidden lg:block h-full w-full bg-gray-100 dark:bg-gray-800">
            <img src="{{ asset('img/loginbanner.jpeg') }}" 
                 alt="Login Banner" 
                 class="absolute inset-0 h-full w-full object-cover" />
        </div>

        {{-- BAGIAN 2: Form Login --}}
        <div class="flex items-center justify-center p-8 sm:p-12 lg:p-16 bg-white dark:bg-gray-900">
            <div class="w-full max-w-md space-y-8">
                {{-- Bagian Kiri: Logo --}}
                <div class="items-center justify-center flex">
                    <a href="/" class="flex items-center gap-2">
                        {{-- 1. Logo Gelap (Tampil di Light Mode, Hilang di Dark Mode) --}}
                        <img src="{{ asset('img/logolight.png') }}" 
                            class="h-9 md:h-12 w-auto block dark:hidden" 
                            alt="LiteBeam Logo Dark" />

                        {{-- 2. Logo Terang (Hilang di Light Mode, Tampil di Dark Mode) --}}
                        <img src="{{ asset('img/logodark.png') }}" 
                            class="h-9 md:h-12 w-auto hidden dark:block" 
                            alt="LiteBeam Logo Light" />

                        <span class="text-gray-900 dark:text-white font-bold text-xl sm:text-2xl whitespace-nowrap">
                            Yogyakarta
                        </span>
                    </a>
                </div>
                {{-- Header / Logo --}}
                <div class="text-center">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Selamat datang kembali, silakan login terlebih dahulu.
                    </p>
                </div>

                {{-- Form --}}
                <form class="mt-8 space-y-6" action="{{ route('login') }}" method="POST">
                    @csrf

                    <div class="space-y-4">
                        {{-- Email --}}
                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Alamat email</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                                placeholder="nama@email.com" required autofocus>
                            @error('email')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div>
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kata sandi</label>
                            <input type="password" name="password" id="password" placeholder="••••••••" 
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                                required>
                            @error('password')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Remember Me & Forgot Password --}}
                    <div class="flex items-center justify-between">
                        <div class="flex items-center h-5">
                            <input id="remember" name="remember" type="checkbox" 
                                class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800">
                            <label for="remember" class="ml-2 text-sm font-medium text-gray-500 dark:text-gray-300">Ingat saya</label>
                        </div>
                        <a href="#" class="text-sm font-medium text-blue-600 hover:underline dark:text-blue-500">Lupa kata sandi?</a>
                    </div>

                    {{-- Submit Button --}}
                    <button type="submit" 
                        class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition-colors">
                        Masuk
                    </button>
                </form>

                {{-- Footer Kecil --}}
                <div class="mt-6 text-center text-xs text-gray-400 dark:text-gray-500">
                    &copy; {{ date('Y') }} Lembaga Penyiaran Publik TVRI D.I. Yogyakarta | All rights reserved.
                </div>
            </div>
        </div>
    </div>
</body>
</html>