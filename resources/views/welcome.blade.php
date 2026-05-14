<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Sistem Perpustakaan') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-gray-50 text-gray-800">
        <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0" style="background-image: url('{{ asset('images/perpus-ku.jpg') }}'); background-size: cover; background-position: center;">
            <div class="absolute inset-0 bg-black opacity-60"></div>
            
            <div class="relative z-10 max-w-3xl mx-auto text-center px-6">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-24 w-auto mx-auto mb-6 drop-shadow-lg">
                <h1 class="text-5xl font-extrabold text-white tracking-tight mb-4 drop-shadow-md">Sistem Peminjaman Buku</h1>
                <p class="text-xl text-gray-200 mb-8 drop-shadow">Akses ribuan literatur dan kelola sirkulasi buku dengan mudah, cepat, dan terintegrasi.</p>
                
                <div class="flex justify-center gap-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">Masuk ke Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-8 py-3 bg-white hover:bg-gray-50 text-blue-600 font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">Register</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </body>
</html>