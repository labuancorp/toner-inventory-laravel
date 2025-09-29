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
                        <button id="theme-toggle" class="win11-button win11-flex items-center win11-gap-sm">
                            <svg class="w-5 h-5 theme-sun" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            <svg class="w-5 h-5 theme-moon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                            </svg>
                        </button>
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
        
        <script>
            // Enhanced Windows 11 Theme Detection and Management
            class Win11ThemeManager {
                constructor() {
                    this.themeToggle = document.getElementById('theme-toggle');
                    this.html = document.documentElement;
                    this.mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
                    
                    this.init();
                }
                
                init() {
                    // Set initial theme
                    this.setInitialTheme();
                    
                    // Listen for system theme changes
                    this.mediaQuery.addEventListener('change', (e) => {
                        if (!localStorage.getItem('theme')) {
                            this.applyTheme(e.matches ? 'dark' : 'light');
                        }
                    });
                    
                    // Theme toggle click handler
                    this.themeToggle.addEventListener('click', () => {
                        this.toggleTheme();
                    });
                    
                    // Add Windows 11 reveal effect to theme toggle
                    this.addRevealEffect();
                }
                
                setInitialTheme() {
                    const savedTheme = localStorage.getItem('theme');
                    const systemPrefersDark = this.mediaQuery.matches;
                    
                    if (savedTheme) {
                        this.applyTheme(savedTheme);
                    } else {
                        this.applyTheme(systemPrefersDark ? 'dark' : 'light');
                    }
                }
                
                applyTheme(theme) {
                    this.html.setAttribute('data-theme', theme);
                    
                    // Add smooth transition class
                    this.html.classList.add('win11-theme-transition');
                    
                    // Update theme toggle icon with animation
                    this.updateThemeIcon(theme);
                    
                    // Remove transition class after animation
                    setTimeout(() => {
                        this.html.classList.remove('win11-theme-transition');
                    }, 300);
                }
                
                toggleTheme() {
                    const currentTheme = this.html.getAttribute('data-theme');
                    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                    
                    this.applyTheme(newTheme);
                    localStorage.setItem('theme', newTheme);
                    
                    // Add micro-interaction
                    this.themeToggle.classList.add('win11-micro-bounce');
                    setTimeout(() => {
                        this.themeToggle.classList.remove('win11-micro-bounce');
                    }, 200);
                }
                
                updateThemeIcon(theme) {
                    const sunIcon = this.themeToggle.querySelector('.theme-sun');
                    const moonIcon = this.themeToggle.querySelector('.theme-moon');
                    
                    if (theme === 'dark') {
                        sunIcon.style.opacity = '1';
                        moonIcon.style.opacity = '0';
                    } else {
                        sunIcon.style.opacity = '0';
                        moonIcon.style.opacity = '1';
                    }
                }
                
                addRevealEffect() {
                    this.themeToggle.classList.add('win11-reveal');
                }
            }
            
            // Initialize theme manager when DOM is loaded
            document.addEventListener('DOMContentLoaded', () => {
                new Win11ThemeManager();
            });
            
            // Add Windows 11 page entrance animation
            document.addEventListener('DOMContentLoaded', () => {
                document.body.classList.add('win11-page-enter');
            });
        </script>
        
        <style>
            /* Windows 11 Theme Transition */
            .win11-theme-transition {
                transition: background-color var(--win11-duration-normal) var(--win11-easing-standard),
                            color var(--win11-duration-normal) var(--win11-easing-standard);
            }
            
            .win11-theme-transition * {
                transition: background-color var(--win11-duration-normal) var(--win11-easing-standard),
                            color var(--win11-duration-normal) var(--win11-easing-standard),
                            border-color var(--win11-duration-normal) var(--win11-easing-standard);
            }
            
            /* Theme toggle icon transitions */
            #theme-toggle svg {
                transition: opacity var(--win11-duration-fast) var(--win11-easing-standard);
            }
        </style>
    </body>
</html>