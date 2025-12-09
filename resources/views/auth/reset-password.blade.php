<!DOCTYPE html>
<html lang="id" class="h-full bg-white dark:bg-gray-900">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Kata Sandi - TVRI D.I. Yogyakarta</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Google+Sans+Flex:opsz,wght@6..144,1..1000&display=swap" rel="stylesheet">
    
    <link rel="icon" href="{{ asset('img/favicon.png') }}" type="image/png">
    
    <style>
        body { font-family: "Google Sans Flex", sans-serif; }
    </style>
</head>
<body class="h-full font-google-sans antialiased text-gray-900 dark:text-white">

    <div class="w-full min-h-screen grid grid-cols-1 lg:grid-cols-2">
        
        <div class="relative hidden lg:block h-full w-full bg-gray-100 dark:bg-gray-800">
            <img src="{{ asset('img/loginbanner.jpeg') }}" 
                 alt="TVRI D.I. Yogyakarta Banner" 
                 class="absolute inset-0 h-full w-full object-cover" />
            <div class="absolute inset-0 bg-gradient-to-br from-blue-900/40 via-indigo-900/30 to-transparent"></div>
        </div>

        <div class="flex items-center justify-center p-8 sm:p-12 lg:p-16 bg-white dark:bg-gray-900">
            <div class="w-full max-w-md space-y-8">
                
                {{-- Logo --}}
                <div class="flex items-center justify-center">
                    <a href="/" class="flex items-center gap-2">
                        <img src="{{ asset('img/logolight.png') }}" 
                            class="h-9 md:h-12 w-auto block dark:hidden" 
                            alt="TVRI D.I. Yogyakarta Logo" />
                        <img src="{{ asset('img/logodark.png') }}" 
                            class="h-9 md:h-12 w-auto hidden dark:block" 
                            alt="TVRI D.I. Yogyakarta Logo" />
                        <span class="text-gray-900 dark:text-white font-bold text-xl sm:text-2xl whitespace-nowrap">
                            Yogyakarta
                        </span>
                    </a>
                </div>
                
                {{-- Header --}}
                <div class="text-center">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                        Reset Kata Sandi
                    </h1>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Masukkan password baru Anda.
                    </p>
                </div>

                {{-- Errors --}}
                @if ($errors->any())
                    <div class="p-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-red-900/20 dark:text-red-400 border border-red-200 dark:border-red-800">
                        <div class="flex items-start">
                            <svg class="flex-shrink-0 w-5 h-5 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            <ul class="flex-1 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                {{-- Form --}}
                <form class="mt-8 space-y-6" action="{{ route('password.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="space-y-4">
                        {{-- Email --}}
                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" name="email" id="email" value="{{ old('email', $email ?? '') }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" 
                                placeholder="nama@email.com" 
                                required 
                                autofocus>
                        </div>

                        {{-- Password Baru --}}
                        <div>
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Password Baru <span class="text-red-500">*</span>
                            </label>
                            <input type="password" name="password" id="password" 
                                placeholder="••••••••" 
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" 
                                required>
                        </div>

                        {{-- Konfirmasi Password --}}
                        <div>
                            <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Konfirmasi Password <span class="text-red-500">*</span>
                            </label>
                            <input type="password" name="password_confirmation" id="password_confirmation" 
                                placeholder="••••••••" 
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" 
                                required>
                        </div>
                    </div>

                    <button type="submit" 
                        class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center transition-colors duration-300">
                        Reset Password
                    </button>
                </form>

                <div class="mt-6 text-center text-xs text-gray-400 dark:text-gray-500">
                    <p>Copyright {{ date('Y') }} TVRI D.I. Yogyakarta | All rights reserved.</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>