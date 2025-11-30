<!DOCTYPE html>
<html lang="id" class="h-full bg-white dark:bg-gray-900">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Kata Sandi - TVRI Yogyakarta</title>
    
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
        
        {{-- Banner Image --}}
        <div class="relative hidden lg:block h-full w-full bg-gray-100 dark:bg-gray-800">
            <img src="{{ asset('img/loginbanner.jpeg') }}" 
                 alt="TVRI Yogyakarta Banner" 
                 class="absolute inset-0 h-full w-full object-cover" />
            <div class="absolute inset-0 bg-gradient-to-br from-blue-900/40 via-indigo-900/30 to-transparent"></div>
        </div>

        {{-- Form Lupa Password --}}
        <div class="flex items-center justify-center p-8 sm:p-12 lg:p-16 bg-white dark:bg-gray-900">
            <div class="w-full max-w-md space-y-8">
                
                {{-- Logo --}}
                <div class="flex items-center justify-center">
                    <a href="/" class="flex items-center gap-2">
                        <img src="{{ asset('img/logolight.png') }}" 
                            class="h-9 md:h-12 w-auto block dark:hidden" 
                            alt="TVRI Yogyakarta Logo" />
                        <img src="{{ asset('img/logodark.png') }}" 
                            class="h-9 md:h-12 w-auto hidden dark:block" 
                            alt="TVRI Yogyakarta Logo" />
                        <span class="text-gray-900 dark:text-white font-bold text-xl sm:text-2xl whitespace-nowrap">
                            Yogyakarta
                        </span>
                    </a>
                </div>
                
                {{-- Header --}}
                <div class="text-center">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                        Lupa Kata Sandi?
                    </h1>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Masukkan email Anda dan kami akan mengirimkan link reset password.
                    </p>
                </div>

                {{-- Notifikasi --}}
                @if (session('status'))
                    <div class="p-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-green-900/20 dark:text-green-400 border border-green-200 dark:border-green-800">
                        <div class="flex items-start">
                            <svg class="flex-shrink-0 w-5 h-5 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>{{ session('status') }}</span>
                        </div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="p-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-red-900/20 dark:text-red-400 border border-red-200 dark:border-red-800">
                        <div class="flex items-start">
                            <svg class="flex-shrink-0 w-5 h-5 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            <div class="flex-1">
                                @foreach ($errors->all() as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Form --}}
                <form class="mt-8 space-y-6" action="{{ route('password.email') }}" method="POST">
                    @csrf

                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Alamat Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" 
                            placeholder="nama@email.com" 
                            required 
                            autofocus>
                    </div>

                    <button type="submit" 
                        class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center transition-colors duration-300">
                        Kirim Link Reset Password
                    </button>

                    {{-- Link Kembali ke Login --}}
                    <div class="flex justify-start mt-2">
                        <a href="{{ route('login') }}" 
                        class="px-4 py-2 text-sm font-medium text-blue-600 bg-gray-100 rounded-lg hover:bg-gray-200 dark:bg-gray-700 dark:text-blue-400 dark:hover:bg-gray-600 transition-colors">
                            Kembali ke Login
                        </a>
                    </div>
                </form>

                {{-- Footer --}}
                <div class="mt-6 text-center text-xs text-gray-400 dark:text-gray-500">
                    <p>&copy; {{ date('Y') }} TVRI D.I. Yogyakarta | All rights reserved.</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>