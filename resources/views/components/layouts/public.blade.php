<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Shop</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-50">
            <!-- Public Top Bar -->
            <div class="bg-white border-b">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                    <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-gray-800">
                        <x-application-logo class="h-8 w-auto" />
                        <span class="font-semibold">{{ config('app.name', 'Laravel') }}</span>
                    </a>
                    <div class="flex items-center gap-3">
                        <!-- Theme Toggle -->
                        <button id="themeToggle" type="button" aria-pressed="false" aria-label="Toggle theme" title="Switch theme" onclick="toggleTheme()" class="inline-flex items-center gap-2 px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-600 bg-white hover:text-gray-800 dark:text-gray-300 dark:bg-gray-800 dark:hover:text-white focus:outline-none transition-colors duration-200">
                            <!-- Sun icon (light) -->
                            <svg class="w-4 h-4 light-icon block dark:hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364-.707-.707M6.343 6.343l-.707-.707m12.728 0-.707.707M6.343 17.657l-.707.707M12 7a5 5 0 100 10 5 5 0 000-10z" />
                            </svg>
                            <!-- Moon icon (dark) -->
                            <svg class="w-4 h-4 dark-icon hidden dark:block" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M21.752 15.002A9.718 9.718 0 0112.001 21c-5.385 0-9.73-4.364-9.73-9.75 0-3.83 2.269-7.123 5.543-8.66a.75.75 0 01.967.967A8.251 8.251 0 0012.001 19.5c3.676 0 6.8-2.396 7.885-5.748a.75.75 0 011.866.25z" />
                            </svg>
                            <span class="hidden sm:inline" id="themeLabel">Light</span>
                        </button>
                        @auth
                            <a href="{{ route('dashboard') }}" class="text-sm text-gray-700 hover:text-indigo-700">Admin</a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm text-gray-700 hover:text-indigo-700">Login</a>
                        @endauth
                    </div>
                </div>
            </div>

            <!-- Public Tabs -->
            <div class="bg-white border-b">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center gap-4 overflow-x-auto py-2">
                        <a href="{{ url('/shop') }}" class="inline-flex items-center gap-2 px-3 py-2 text-sm rounded {{ request()->is('shop') ? 'bg-amber-50 text-amber-700' : 'text-gray-700 hover:bg-gray-50' }}">
                            <x-icon name="shopping-cart" class="w-4 h-4" />
                            <span>Shop</span>
                        </a>
                        <a href="{{ url('/') }}" class="inline-flex items-center gap-2 px-3 py-2 text-sm rounded {{ request()->is('/') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-50' }}">
                            <x-icon name="home" class="w-4 h-4" />
                            <span>Home</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>