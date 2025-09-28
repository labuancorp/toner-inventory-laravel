<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ (Auth::check() && in_array(Auth::user()->role, ['admin','manager'])) ? route('dashboard') : route('shop') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links (Admin/Manager only) -->
                @if(Auth::check() && in_array(Auth::user()->role, ['admin','manager']))
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        <span class="inline-flex items-center gap-2">
                            <i class="ti ti-home" aria-hidden="true"></i>
                            {{ __('Dashboard') }}
                        </span>
                    </x-nav-link>
                    <x-nav-link :href="route('items.index')" :active="request()->routeIs('items.*')">
                        <span class="inline-flex items-center gap-2">
                            <i class="ti ti-box" aria-hidden="true"></i>
                            {{ __('Items') }}
                        </span>
                    </x-nav-link>
                    <x-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.*')">
                        <span class="inline-flex items-center gap-2">
                            <i class="ti ti-folder" aria-hidden="true"></i>
                            {{ __('Categories') }}
                        </span>
                    </x-nav-link>
                </div>
                @endif
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <!-- Theme Toggle -->
                <button id="themeToggle" type="button" aria-pressed="false" aria-label="Toggle theme" title="Switch theme" onclick="toggleTheme()" class="inline-flex items-center gap-2 px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-600 bg-white hover:text-gray-800 dark:text-gray-300 dark:bg-gray-800 dark:hover:text-white focus:outline-none transition-colors duration-200 me-3">
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
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Admin Tabs -->
    <div class="border-t bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-4 overflow-x-auto py-2">
                @if(Auth::check() && in_array(Auth::user()->role, ['admin','manager']))
                <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 px-3 py-2 text-sm rounded {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-50' }}">
                    <i class="ti ti-chart-bar" aria-hidden="true"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('items.index') }}" class="inline-flex items-center gap-2 px-3 py-2 text-sm rounded {{ request()->routeIs('items.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-50' }}">
                    <i class="ti ti-box" aria-hidden="true"></i>
                    <span>Items</span>
                </a>
                <a href="{{ route('categories.index') }}" class="inline-flex items-center gap-2 px-3 py-2 text-sm rounded {{ request()->routeIs('categories.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-50' }}">
                    <i class="ti ti-folder" aria-hidden="true"></i>
                    <span>Categories</span>
                </a>
                @endif
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 px-3 py-2 text-sm rounded {{ request()->routeIs('admin.dashboard') ? 'bg-purple-50 text-purple-700' : 'text-gray-700 hover:bg-gray-50' }}">
                    <i class="ti ti-shield-check" aria-hidden="true"></i>
                    <span>Admin</span>
                </a>
                @endif
                <a href="{{ url('/shop') }}" class="inline-flex items-center gap-2 px-3 py-2 text-sm rounded {{ request()->is('shop') ? 'bg-amber-50 text-amber-700' : 'text-gray-700 hover:bg-gray-50' }}">
                    <i class="ti ti-shopping-cart" aria-hidden="true"></i>
                    <span>Shop</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @if(Auth::check() && in_array(Auth::user()->role, ['admin','manager']))
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            @endif
            @if(Auth::check() && in_array(Auth::user()->role, ['admin','manager']))
            @if(Auth::check() && in_array(Auth::user()->role, ['admin','manager']))
            <x-responsive-nav-link :href="route('items.index')" :active="request()->routeIs('items.*')">
                {{ __('Items') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.*')">
                {{ __('Categories') }}
            </x-responsive-nav-link>
            @endif
            @if(Auth::check() && in_array(Auth::user()->role, ['admin','manager']))
            <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                {{ __('Admin') }}
            </x-responsive-nav-link>
            @endif
            @endif
            <x-responsive-nav-link :href="url('/shop')" :active="request()->is('shop')">
                {{ __('Shop') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>

<script>
    (function initTheme() {
        try {
            const stored = localStorage.getItem('theme') || 'light';
            const isDark = stored === 'dark';
            document.documentElement.classList.toggle('dark', isDark);
            const btn = document.getElementById('themeToggle');
            const label = document.getElementById('themeLabel');
            if (btn) btn.setAttribute('aria-pressed', String(isDark));
            if (label) label.textContent = isDark ? 'Dark' : 'Light';
        } catch (e) { /* noop */ }
    })();
    function toggleTheme() {
        const nowDark = !document.documentElement.classList.contains('dark');
        document.documentElement.classList.toggle('dark', nowDark);
        localStorage.setItem('theme', nowDark ? 'dark' : 'light');
        const btn = document.getElementById('themeToggle');
        const label = document.getElementById('themeLabel');
        if (btn) btn.setAttribute('aria-pressed', String(nowDark));
        if (label) label.textContent = nowDark ? 'Dark' : 'Light';
    }
</script>
