<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Shop</title>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/css/theme.css', 'resources/js/app.js'])
    </head>
    <body class="bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 transition-colors duration-300">
        <div class="min-h-screen">
            <!-- Top Bar -->
            <div class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 shadow-sm">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between w-full h-16">
                    <a href="{{ url('/') }}" class="flex items-center space-x-3 text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                        <x-application-logo class="h-6 w-auto" />
                        <span class="font-semibold text-lg">{{ config('app.name', 'Laravel') }}</span>
                    </a>
                    <div class="flex items-center space-x-3">
                        <!-- Language Switcher -->
                        <x-language-switcher />
                        <!-- Theme Toggle -->
                        <button id="themeToggle" type="button" aria-pressed="false" aria-label="Toggle theme" title="Switch theme" onclick="toggleTheme()" class="p-2 rounded-md text-gray-500 hover:text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-gray-200 dark:hover:bg-gray-700 transition-colors">
                            <!-- Sun icon (light) -->
                            <svg class="w-4 h-4 light-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364-.707-.707M6.343 6.343l-.707-.707m12.728 0-.707.707M6.343 17.657l-.707.707M12 7a5 5 0 100 10 5 5 0 000-10z" />
                            </svg>
                            <!-- Moon icon (dark) -->
                            <svg class="w-4 h-4 dark-icon hidden" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M21.752 15.002A9.718 9.718 0 0112.001 21c-5.385 0-9.73-4.364-9.73-9.75 0-3.83 2.269-7.123 5.543-8.66a.75.75 0 01.967.967A8.251 8.251 0 0012.001 19.5c3.676 0 6.8-2.396 7.885-5.748a.75.75 0 011.866.25z" />
                            </svg>
                            <span class="hidden sm:inline ml-2" id="themeLabel">Light</span>
                        </button>
                        @auth
                            <a href="{{ route('dashboard') }}" class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-100 dark:text-gray-300 dark:hover:text-white dark:hover:bg-gray-700 transition-colors">Admin</a>
                            <form method="POST" action="{{ route('logout') }}" class="inline-block">
                                @csrf
                                <button type="submit" class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-100 dark:text-gray-300 dark:hover:text-white dark:hover:bg-gray-700 transition-colors">Log Out</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="px-4 py-2 rounded-md text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">Login</a>
                        @endauth
                    </div>
                </div>
            </div>

            <!-- Navigation Tabs -->
            <div class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center space-x-6 overflow-x-auto py-2">
                        <a href="{{ url('/shop') }}" class="flex items-center space-x-2 px-3 py-2 rounded-md text-sm font-medium transition-colors {{ request()->is('shop') ? 'text-blue-600 bg-blue-50 dark:text-blue-400 dark:bg-blue-900/20' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50 dark:text-gray-400 dark:hover:text-gray-200 dark:hover:bg-gray-700' }}">
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.293 2.293c-.63.63-.184 1.707.707 1.707H19M7 13v4a2 2 0 002 2h2m3-6v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m6 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01" />
                            </svg>
                            <span>Shop</span>
                        </a>
                        <a href="{{ url('/') }}" class="flex items-center space-x-2 px-3 py-2 rounded-md text-sm font-medium transition-colors {{ request()->is('/') ? 'text-blue-600 bg-blue-50 dark:text-blue-400 dark:bg-blue-900/20' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50 dark:text-gray-400 dark:hover:text-gray-200 dark:hover:bg-gray-700' }}">
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            <span>Home</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Page Content -->
            <main class="flex-1 bg-gray-50 dark:bg-gray-900">
                {{ $slot }}
            </main>
        </div>

        <!-- Theme Detection Script -->
        <script>
            // Theme Detection and Management
            function initializeTheme() {
                const savedTheme = localStorage.getItem('theme');
                const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                const theme = savedTheme || (systemPrefersDark ? 'dark' : 'light');
                
                applyTheme(theme);
                
                // Listen for system theme changes
                window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
                    if (!localStorage.getItem('theme')) {
                        applyTheme(e.matches ? 'dark' : 'light');
                    }
                });
            }

            function applyTheme(theme) {
                document.documentElement.setAttribute('data-theme', theme);
                
                // Update theme toggle button
                const themeLabel = document.getElementById('themeLabel');
                const lightIcon = document.querySelector('.light-icon');
                const darkIcon = document.querySelector('.dark-icon');
                const themeToggle = document.getElementById('themeToggle');
                
                if (theme === 'dark') {
                    if (themeLabel) themeLabel.textContent = 'Dark';
                    if (lightIcon) lightIcon.classList.add('hidden');
                    if (darkIcon) darkIcon.classList.remove('hidden');
                    if (themeToggle) themeToggle.setAttribute('aria-pressed', 'true');
                } else {
                    if (themeLabel) themeLabel.textContent = 'Light';
                    if (lightIcon) lightIcon.classList.remove('hidden');
                    if (darkIcon) darkIcon.classList.add('hidden');
                    if (themeToggle) themeToggle.setAttribute('aria-pressed', 'false');
                }
            }

            function toggleTheme() {
                const currentTheme = document.documentElement.getAttribute('data-theme');
                const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                
                localStorage.setItem('theme', newTheme);
                applyTheme(newTheme);
            }

            // Initialize theme on page load
            document.addEventListener('DOMContentLoaded', initializeTheme);
        </script>

        @stack('scripts')
    </body>
</html>