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
                            {{ __('app.nav.dashboard') }}
                        </span>
                    </x-nav-link>
                    <x-nav-link :href="route('items.index')" :active="request()->routeIs('items.*')">
                        <span class="inline-flex items-center gap-2">
                            <i class="ti ti-box" aria-hidden="true"></i>
                            {{ __('app.nav.items') }}
                        </span>
                    </x-nav-link>
                    <x-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.*')">
                        <span class="inline-flex items-center gap-2">
                            <i class="ti ti-folder" aria-hidden="true"></i>
                            {{ __('app.nav.categories') }}
                        </span>
                    </x-nav-link>
                </div>
                @endif
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <!-- Language Switcher -->
                <x-language-switcher />
                <!-- Theme Toggle -->
                <x-theme-toggle class="me-3" />
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
                        <button type="button" 
                                @click="$dispatch('logout-trigger')"
                                class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                {{ __('Log Out') }}
                            </div>
                        </button>
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
                    <i class="ti ti-chart-bar icon-gradient" aria-hidden="true"></i>
                    <span>{{ __('app.nav.dashboard') }}</span>
                </a>
                <a href="{{ route('items.index') }}" class="inline-flex items-center gap-2 px-3 py-2 text-sm rounded {{ request()->routeIs('items.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-50' }}">
                    <i class="ti ti-box icon-gradient" aria-hidden="true"></i>
                    <span>{{ __('app.nav.items') }}</span>
                </a>
                <a href="{{ route('categories.index') }}" class="inline-flex items-center gap-2 px-3 py-2 text-sm rounded {{ request()->routeIs('categories.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-50' }}">
                    <i class="ti ti-folder icon-gradient" aria-hidden="true"></i>
                    <span>{{ __('app.nav.categories') }}</span>
                </a>
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 px-3 py-2 text-sm rounded {{ request()->routeIs('admin.dashboard') ? 'bg-purple-50 text-purple-700' : 'text-gray-700 hover:bg-gray-50' }}">
                    <i class="ti ti-shield-check icon-gradient warm" aria-hidden="true"></i>
                    <span>{{ __('app.nav.admin') }}</span>
                </a>
                @endif
                <a href="{{ url('/shop') }}" class="inline-flex items-center gap-2 px-3 py-2 text-sm rounded {{ request()->is('shop') ? 'bg-amber-50 text-amber-700' : 'text-gray-700 hover:bg-gray-50' }}">
                    <i class="ti ti-shopping-cart" aria-hidden="true"></i>
                    <span>{{ __('app.nav.shop') }}</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @if(Auth::check() && in_array(Auth::user()->role, ['admin','manager']))
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('app.nav.dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('items.index')" :active="request()->routeIs('items.*')">
                {{ __('app.nav.items') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.*')">
                {{ __('app.nav.categories') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                {{ __('app.nav.admin') }}
            </x-responsive-nav-link>
            @endif
            <x-responsive-nav-link :href="url('/shop')" :active="request()->is('shop')">
                {{ __('app.nav.shop') }}
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

