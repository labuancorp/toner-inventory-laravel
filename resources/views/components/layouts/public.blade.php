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
    <body class="win11-layout">
        <div class="min-h-screen">
            <!-- Windows 11 Top Bar -->
            <div class="win11-topbar">
                <div class="win11-container win11-flex items-center justify-between w-full">
                    <a href="{{ url('/') }}" class="win11-nav-brand">
                        <x-application-logo class="h-6 w-auto" />
                        <span>{{ config('app.name', 'Laravel') }}</span>
                    </a>
                    <div class="win11-flex items-center win11-gap-sm">
                        <!-- Language Switcher -->
                        <x-language-switcher />
                        <!-- Windows 11 Theme Toggle -->
                        <button id="themeToggle" type="button" aria-pressed="false" aria-label="Toggle theme" title="Switch theme" onclick="toggleTheme()" class="win11-button win11-button-subtle">
                            <!-- Sun icon (light) -->
                            <svg class="w-4 h-4 light-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364-.707-.707M6.343 6.343l-.707-.707m12.728 0-.707.707M6.343 17.657l-.707.707M12 7a5 5 0 100 10 5 5 0 000-10z" />
                            </svg>
                            <!-- Moon icon (dark) -->
                            <svg class="w-4 h-4 dark-icon hidden" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M21.752 15.002A9.718 9.718 0 0112.001 21c-5.385 0-9.73-4.364-9.73-9.75 0-3.83 2.269-7.123 5.543-8.66a.75.75 0 01.967.967A8.251 8.251 0 0012.001 19.5c3.676 0 6.8-2.396 7.885-5.748a.75.75 0 011.866.25z" />
                            </svg>
                            <span class="hidden sm:inline" id="themeLabel">Light</span>
                        </button>
                        @auth
                            <a href="{{ route('dashboard') }}" class="win11-button win11-button-subtle">Admin</a>
                            <form method="POST" action="{{ route('logout') }}" class="inline-block">
                                @csrf
                                <button type="submit" class="win11-button win11-button-subtle">Log Out</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="win11-button win11-button-accent">Login</a>
                        @endauth
                    </div>
                </div>
            </div>

            <!-- Windows 11 Navigation Tabs -->
            <div class="win11-nav">
                <div class="win11-container">
                    <div class="win11-flex items-center win11-gap-sm overflow-x-auto py-2">
                        <a href="{{ url('/shop') }}" class="win11-nav-item {{ request()->is('shop') ? 'active' : '' }}">
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.293 2.293c-.63.63-.184 1.707.707 1.707H19M7 13v4a2 2 0 002 2h2m3-6v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m6 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01" />
                            </svg>
                            <span>Shop</span>
                        </a>
                        <a href="{{ url('/') }}" class="win11-nav-item {{ request()->is('/') ? 'active' : '' }}">
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            <span>Home</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Page Content -->
            <main class="win11-main-content">
                {{ $slot }}
            </main>
        </div>

        <!-- Windows 11 Theme Detection Script -->
        <script>
            // Windows 11 Theme Detection and Management
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