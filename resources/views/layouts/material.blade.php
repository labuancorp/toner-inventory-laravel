<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin | Stock Manager</title>

    <!-- Vite assets: Tailwind CSS and JavaScript -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-surface-50 text-surface-900" data-theme="light">
    @php($isAuthPage = request()->routeIs('login') || request()->routeIs('register'))
    
    @unless($isAuthPage)
    <!-- Layout Container -->
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-soft border-r border-surface-200 fixed h-full z-30 lg:relative lg:translate-x-0 transform -translate-x-full transition-transform duration-300 ease-in-out" id="sidenav-main" aria-label="Admin sidebar navigation">
            <div class="p-6 border-b border-surface-200">
                <a class="flex items-center space-x-3" href="{{ route('admin.dashboard') }}">
                    <div class="w-8 h-8 bg-gradient-to-br from-brand-primary to-brand-accent rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <span class="text-lg font-semibold text-surface-900">Stock Manager</span>
                </a>
            </div>
            <div class="px-4 py-6">
                <nav aria-label="Primary">
                    <ul class="space-y-2" role="list">
                        @include('layouts.sidebar-nav')
                    </ul>
                </nav>
            </div>
        </aside>
        
        <!-- Mobile overlay -->
        <div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-20 lg:hidden hidden" aria-hidden="true"></div>
        
        <!-- Main content -->
        <main class="flex-1 lg:ml-0">
            <!-- Mobile topbar -->
            <div class="lg:hidden bg-white border-b border-surface-200 px-4 py-3">
                <div class="flex items-center justify-between">
                    <button id="sidebarToggle" class="inline-flex items-center px-3 py-2 border border-surface-300 rounded-md text-surface-500 bg-white hover:bg-surface-50 hover:text-surface-700 focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary transition-colors" type="button" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidebar">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <line x1="3" y1="12" x2="21" y2="12"></line>
                            <line x1="3" y1="18" x2="21" y2="18"></line>
                        </svg>
                        <span class="ml-2">Menu</span>
                    </button>
                    <a href="{{ route('admin.dashboard') }}" class="text-lg font-semibold text-surface-900 hover:text-brand-primary transition-colors">Admin</a>
                </div>
            </div>

            <div class="{{ $isAuthPage ? 'container mx-auto py-4 flex justify-center items-center min-h-screen' : 'p-6' }}">
                @yield('content')
            </div>
        </main>
    </div>
    @else
    <!-- Auth page content -->
    <div class="container mx-auto py-4 flex justify-center items-center min-h-screen">
        @yield('content')
    </div>
    @endunless

    <!-- Notification toast container -->
    <div id="notifToastContainer" class="fixed top-4 right-4 z-50 space-y-2" aria-live="polite" aria-atomic="true"></div>

    <!-- Logout Confirmation Modal -->
    @unless($isAuthPage)
        <x-logout-confirmation />
    @endunless

    @stack('scripts')
</body>
</html>
