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
        <div class="min-h-screen bg-gray-50 dark:bg-gray-900 dark:text-gray-100">
            <!-- Public Top Bar -->
            <div class="bg-white dark:bg-gray-800 dark:text-gray-100 border-b">
                <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                    <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-gray-800">
                        <x-application-logo class="h-8 w-auto" />
                        <span class="font-semibold">{{ config('app.name', 'Laravel') }}</span>
                    </a>
                    <div class="flex items-center gap-3">
                        <!-- Language Switcher -->
                        <x-language-switcher />
                        <!-- Theme Toggle -->
                        <x-theme-toggle />
                        @auth
                            <a href="{{ route('dashboard') }}" class="text-sm text-gray-700 hover:text-indigo-700">Admin</a>
                            <form method="POST" action="{{ route('logout') }}" class="inline-block ml-3">
                                @csrf
                                <button type="submit" class="text-sm text-gray-700 hover:text-rose-700">Log Out</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="text-sm text-gray-700 hover:text-indigo-700">Login</a>
                        @endauth
                    </div>
                </div>
            </div>

            <!-- Public Tabs -->
            <div class="bg-white border-b">
                <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center gap-4 overflow-x-auto py-2">
                        <a href="{{ url('/shop') }}" class="inline-flex items-center gap-2 px-3 py-2 text-sm rounded {{ request()->is('shop') ? 'bg-amber-50 text-amber-700' : 'text-gray-700 hover:bg-gray-50' }}">
                            <i class="ti ti-shopping-cart" aria-hidden="true"></i>
                            <span>Shop</span>
                        </a>
                        {{-- My Report tab removed per request --}}
                        {{-- Public Reports tab removed per request --}}
                        <a href="{{ url('/') }}" class="inline-flex items-center gap-2 px-3 py-2 text-sm rounded {{ request()->is('/') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-50' }}">
                            <i class="ti ti-home" aria-hidden="true"></i>
                            <span>Home</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Page Content -->
            <main class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8">
                {{ $slot }}
            </main>
        </div>
        @stack('scripts')
    </body>
</html>