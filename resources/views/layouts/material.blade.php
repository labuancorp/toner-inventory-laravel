<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin | Material Dashboard</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Icons (optional) -->
    <!-- Bootstrap/Tabler CSS is loaded via Vite in material.css -->
    <!-- Vite local assets (include Tailwind app.css to style existing components) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Keep Material styles scoped to this layout where possible */
        body.material-layout { background: #f8f9fa; }
    </style>
</head>
<body class="material-layout bg-gray-100" data-theme="light">
    <!-- Sidebar (WCAG-compliant nav) -->
    <aside class="sidenav navbar navbar-vertical bg-white fixed-start" id="sidenav-main" aria-label="Admin sidebar navigation">
        <div class="sidenav-header">
            <a class="navbar-brand m-0" href="{{ route('admin.dashboard') }}">
                <span class="ms-1 font-weight-bold">Stock Manager Admin</span>
            </a>
        </div>
        <hr class="horizontal dark mt-0" aria-hidden="true">
        <div id="sidenav-scrollbar" class="w-auto h-100">
            <nav class="px-2" aria-label="Primary">
                <ul class="navbar-nav" role="list">
                    @include('layouts.sidebar-nav')
                </ul>
            </nav>
        </div>
    </aside>

    <!-- Main content -->
    <main class="main-content position-relative border-radius-lg">
        <!-- No top navbar; all navigation is in the sidebar for clarity -->

        <div class="content-container container-fluid py-4">
            @yield('content')
        </div>
    </main>

    <!-- Notification toast container -->
    <div id="notifToastContainer" class="position-fixed bottom-0 end-0 p-3" aria-live="polite" aria-atomic="true" style="z-index: 1080;"></div>

    <!-- Using Vite-bundled local JS; CDN scripts removed -->
    @stack('scripts')
</body>
</html>
