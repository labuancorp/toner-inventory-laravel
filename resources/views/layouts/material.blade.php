<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin | Stock Manager</title>

    <!-- Windows 11 Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    
    <!-- Vite local assets with Windows 11 theme -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="win11-body win11-page-enter" data-theme="light">
    @php($isAuthPage = request()->routeIs('login') || request()->routeIs('register'))
    
    @unless($isAuthPage)
    <!-- Layout Container -->
    <div class="win11-flex win11-min-h-screen">
        <!-- Windows 11 Sidebar -->
        <aside class="win11-sidebar" id="sidenav-main" aria-label="Admin sidebar navigation">
        <div class="win11-sidebar-header">
            <a class="win11-sidebar-brand" href="{{ route('admin.dashboard') }}">
                <span class="win11-text-lg win11-font-semibold">Stock Manager Admin</span>
            </a>
        </div>
        <div class="win11-sidebar-divider"></div>
        <div class="win11-sidebar-content">
            <nav aria-label="Primary">
                <ul class="win11-nav-list" role="list">
                    @include('layouts.sidebar-nav')
                </ul>
            </nav>
        </div>
        </aside>
        <!-- Mobile overlay -->
        <div id="sidebarOverlay" class="win11-overlay" aria-hidden="true"></div>
        
        <!-- Main content -->
        <main class="win11-main-content win11-flex-1">
        <!-- Mobile topbar -->
        <div class="win11-mobile-topbar lg:win11-hidden">
            <div class="win11-flex win11-items-center win11-justify-between">
                <button id="sidebarToggle" class="win11-button win11-button-ghost" type="button" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidebar">
                    <svg class="win11-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <line x1="3" y1="12" x2="21" y2="12"></line>
                        <line x1="3" y1="18" x2="21" y2="18"></line>
                    </svg>
                    <span class="win11-ml-2">Menu</span>
                </button>
                <a href="{{ route('admin.dashboard') }}" class="win11-text-decoration-none win11-font-semibold">Admin</a>
            </div>
        </div>

            <div class="{{ $isAuthPage ? 'win11-container win11-py-4 win11-flex win11-justify-center win11-items-center win11-min-h-screen' : 'win11-content-container win11-container-fluid win11-py-4' }}">
                @yield('content')
            </div>
        </main>
    </div>
    @else
    <!-- Auth page content -->
    <div class="win11-container win11-py-4 win11-flex win11-justify-center win11-items-center win11-min-h-screen">
        @yield('content')
    </div>
    @endunless

    <!-- Notification toast container -->
    <div id="notifToastContainer" class="win11-notification-container" aria-live="polite" aria-atomic="true"></div>

    <!-- Windows 11 Theme Management -->
    <script>
        class Win11AdminThemeManager {
            constructor() {
                this.init();
            }

            init() {
                // Set initial theme
                const savedTheme = localStorage.getItem('theme');
                const systemTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
                const theme = savedTheme || systemTheme;
                
                this.setTheme(theme);
                
                // Listen for system theme changes
                window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
                    if (!localStorage.getItem('theme')) {
                        this.setTheme(e.matches ? 'dark' : 'light');
                    }
                });

                // Setup sidebar toggle
                this.setupSidebarToggle();
            }

            setTheme(theme) {
                document.body.setAttribute('data-theme', theme);
                document.documentElement.setAttribute('data-theme', theme);
            }

            setupSidebarToggle() {
                const toggle = document.getElementById('sidebarToggle');
                const sidebar = document.getElementById('sidenav-main');
                const overlay = document.getElementById('sidebarOverlay');

                if (toggle && sidebar && overlay) {
                    toggle.addEventListener('click', () => {
                        sidebar.classList.toggle('win11-sidebar-open');
                        overlay.classList.toggle('win11-overlay-active');
                        toggle.setAttribute('aria-expanded', sidebar.classList.contains('win11-sidebar-open'));
                    });

                    overlay.addEventListener('click', () => {
                        sidebar.classList.remove('win11-sidebar-open');
                        overlay.classList.remove('win11-overlay-active');
                        toggle.setAttribute('aria-expanded', 'false');
                    });
                }
            }
        }

        // Initialize theme manager when DOM is ready
        document.addEventListener('DOMContentLoaded', () => {
            new Win11AdminThemeManager();
        });
    </script>

    @stack('scripts')
</body>
</html>
