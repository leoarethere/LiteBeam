<!DOCTYPE html>
<html lang="id" class="h-full bg-gray-900">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    
    {{-- Menggabungkan Vite directives menjadi satu untuk efisiensi --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
</head>
<body class="h-full">
{{-- Asumsi Anda menggunakan layout component, tag <x-slot> ini bisa dipindahkan ke dalam file view utama --}}
{{-- <x-slot:title>Login</x-slot:title> --}}

<section class="bg-gray-50 dark:bg-gray-900">
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
        {{-- KEAMANAN: Menggunakan url() helper untuk link internal --}}
        <a href="{{ url('/') }}" class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
            <img class="w-8 h-8 mr-2" src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/logo.svg" alt="logo">
            TVRI Yogyakarta
        </a>
        <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                    Masuk ke akun Anda
                </h1>
                
                {{-- KEAMANAN: Atribut form method dan action diperbaiki --}}
                <form class="space-y-4 md:space-y-6" action="{{ route('login') }}" method="POST">
                    {{-- KEAMANAN WAJIB: Menambahkan token CSRF untuk melindungi dari serangan Cross-Site Request Forgery --}}
                    @csrf

                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email Anda</label>
                        {{-- PERBAIKAN: Kesalahan ketik 'border-grey-300' menjadi 'border-gray-300' --}}
                        <input type="email" name="email" id="email" 
                               class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('email') @enderror" 
                               placeholder="nama@email.com" autofocus required autocomplete="email" value="{{ old('email') }}">
                        
                        @error('email')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                        {{-- KEAMANAN: Menambahkan autocomplete="current-password" --}}
                        <input type="password" name="password" id="password" placeholder="••••••••" 
                               class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('email') @enderror" 
                               required autocomplete="current-password">
                        @error('password')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                              <input id="remember" name="remember" type="checkbox" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-primary-600 dark:ring-offset-gray-800">
                            </div>
                            <div class="ml-3 text-sm">
                              <label for="remember" class="text-gray-500 dark:text-gray-300">Ingat saya</label>
                            </div>
                        </div>
                        {{-- KEAMANAN: Menggunakan route() helper untuk link internal --}}
                        <a href="#" class="text-sm font-medium text-primary-600 hover:underline dark:text-primary-500">Lupa password?</a>
                    </div>
                    <button type="submit" class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Masuk</button>
                    <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                        Anda tidak memiliki akun? <a href="{{ route('register') }}" class="font-medium text-primary-600 hover:underline dark:text-primary-500">Daftar</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</section>

</body>
</html>
