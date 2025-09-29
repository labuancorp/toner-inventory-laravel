{{-- Agency brand (logo) --}}
@php($agencyLogo = \App\Models\Setting::get('agency_logo_path'))
<li class="win11-nav-section" aria-label="Agency">
    <div class="win11-flex win11-items-center win11-justify-start win11-px-2 win11-py-3">
        @if($agencyLogo)
            <img src="{{ asset('storage/'.$agencyLogo) }}" alt="Agency Logo" class="win11-img-fluid" style="max-height: 40px; width: auto; object-fit: contain;" />
        @else
            <img src="{{ asset('images/pl-logo.svg') }}" alt="Agency Logo" class="win11-img-fluid" style="max-height: 40px; width: auto; object-fit: contain;" />
        @endif
    </div>
    <ul class="win11-nav-section-list" role="list">
        <li class="win11-nav-item">
            <a class="win11-nav-link" href="{{ route('admin.settings.index') }}">
                <svg class="win11-nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="3"></circle>
                    <path d="M12 1v6m0 6v6m11-7h-6m-6 0H1m15.5-3.5L19 4l-1.5 1.5M5 20l1.5-1.5L5 17m0-11l1.5 1.5L5 6"></path>
                </svg>
                <span class="win11-nav-link-text">Agency Settings</span>
            </a>
        </li>
    </ul>
</li>

{{-- General Section --}}
<li class="win11-nav-section" aria-label="General">
    <span class="win11-nav-section-title">General</span>
    <ul class="win11-nav-section-list" role="list">
        <li class="win11-nav-item">
            <a class="win11-nav-link {{ request()->routeIs('dashboard') ? 'win11-nav-link-active' : '' }}" href="{{ route('dashboard') }}" @if(request()->routeIs('dashboard')) aria-current="page" @endif>
                <svg class="win11-nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="3" width="7" height="7"></rect>
                    <rect x="14" y="3" width="7" height="7"></rect>
                    <rect x="14" y="14" width="7" height="7"></rect>
                    <rect x="3" y="14" width="7" height="7"></rect>
                </svg>
                <span class="win11-nav-link-text">Dashboard</span>
            </a>
        </li>
        @if(Auth::check() && in_array(Auth::user()->role, ['admin','manager']))
        <li class="win11-nav-item">
            <a class="win11-nav-link {{ request()->routeIs('admin.dashboard') ? 'win11-nav-link-active' : '' }}" href="{{ route('admin.dashboard') }}" @if(request()->routeIs('admin.dashboard')) aria-current="page" @endif>
                <svg class="win11-nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                    <path d="M9 12l2 2 4-4"></path>
                </svg>
                <span class="win11-nav-link-text">Admin Dashboard</span>
            </a>
        </li>
        @endif
        <li class="win11-nav-item">
            <a class="win11-nav-link {{ request()->is('shop') ? 'win11-nav-link-active' : '' }}" href="{{ url('/shop') }}" @if(request()->is('shop')) aria-current="page" @endif>
                <svg class="win11-nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="9" cy="21" r="1"></circle>
                    <circle cx="20" cy="21" r="1"></circle>
                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                </svg>
                <span class="win11-nav-link-text">Shop</span>
            </a>
        </li>
    </ul>
</li>

{{-- Inventory Section (for Admin/Manager) --}}
@if(Auth::check() && in_array(Auth::user()->role, ['admin','manager']))
<li class="win11-nav-section" aria-label="Inventory">
    <span class="win11-nav-section-title">Inventory</span>
    <ul class="win11-nav-section-list" role="list">
        <li class="win11-nav-item">
            <a class="win11-nav-link {{ request()->routeIs('items.index') ? 'win11-nav-link-active' : '' }}" href="{{ route('items.index') }}" @if(request()->routeIs('items.index')) aria-current="page" @endif>
                <svg class="win11-nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                    <polyline points="3.27,6.96 12,12.01 20.73,6.96"></polyline>
                    <line x1="12" y1="22.08" x2="12" y2="12"></line>
                </svg>
                <span class="win11-nav-link-text">Items</span>
                <span class="win11-badge" aria-label="Items count">{{ \App\Models\Item::count() }}</span>
            </a>
        </li>
        <li class="win11-nav-item">
            <a class="win11-nav-link {{ request()->routeIs('items.trashed') ? 'win11-nav-link-active' : '' }}" href="{{ route('items.trashed') }}" @if(request()->routeIs('items.trashed')) aria-current="page" @endif>
                <svg class="win11-nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="3,6 5,6 21,6"></polyline>
                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                    <line x1="10" y1="11" x2="10" y2="17"></line>
                    <line x1="14" y1="11" x2="14" y2="17"></line>
                </svg>
                <span class="win11-nav-link-text">Trashed Items</span>
                <span class="win11-badge" aria-label="Trashed items count">{{ \App\Models\Item::onlyTrashed()->count() }}</span>
            </a>
        </li>
        <li class="win11-nav-item">
            <a class="win11-nav-link {{ request()->routeIs('items.reorder') ? 'win11-nav-link-active' : '' }}" href="{{ route('items.reorder') }}" @if(request()->routeIs('items.reorder')) aria-current="page" @endif>
                <svg class="win11-nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                </svg>
                <span class="win11-nav-link-text">{{ __('app.nav.reorder_suggestions') }}</span>
            </a>
        </li>
        <li class="win11-nav-item">
            <a class="win11-nav-link {{ request()->routeIs('items.scan') ? 'win11-nav-link-active' : '' }}" href="{{ route('items.scan') }}" @if(request()->routeIs('items.scan')) aria-current="page" @endif>
                <svg class="win11-nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 5a2 2 0 0 1 2-2h3m13 0h-3a2 2 0 0 1 2 2v3m0 13v-3a2 2 0 0 1-2 2h-3m-13 0h3a2 2 0 0 1-2-2v-3"></path>
                    <path d="M8 12h8"></path>
                    <path d="M8 8h8"></path>
                    <path d="M8 16h8"></path>
                </svg>
                <span class="win11-nav-link-text">{{ __('app.nav.scan_barcode') }}</span>
            </a>
        </li>
        <li class="win11-nav-item">
            <a class="win11-nav-link {{ request()->routeIs('reports.analytics') ? 'win11-nav-link-active' : '' }}" href="{{ route('reports.analytics') }}" @if(request()->routeIs('reports.analytics')) aria-current="page" @endif>
                <svg class="win11-nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="12" y1="20" x2="12" y2="10"></line>
                    <line x1="18" y1="20" x2="18" y2="4"></line>
                    <line x1="6" y1="20" x2="6" y2="16"></line>
                </svg>
                <span class="win11-nav-link-text">{{ __('app.nav.advanced_analytics') }}</span>
            </a>
        </li>
        <li class="win11-nav-item">
            <a class="win11-nav-link {{ request()->routeIs('shop.history') ? 'win11-nav-link-active' : '' }}" href="{{ route('shop.history') }}" @if(request()->routeIs('shop.history')) aria-current="page" @endif>
                <svg class="win11-nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12,6 12,12 16,14"></polyline>
                </svg>
                <span class="win11-nav-link-text">Shop History</span>
            </a>
        </li>
        <li class="win11-nav-item">
            <a class="win11-nav-link {{ request()->routeIs('printers.*') ? 'win11-nav-link-active' : '' }}" href="{{ route('printers.index') }}" @if(request()->routeIs('printers.*')) aria-current="page" @endif>
                <svg class="win11-nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="6,9 6,2 18,2 18,9"></polyline>
                    <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                    <rect x="6" y="14" width="12" height="8"></rect>
                </svg>
                <span class="win11-nav-link-text">Printers</span>
            </a>
        </li>
        <li class="win11-nav-item">
            <a class="win11-nav-link {{ request()->routeIs('categories.*') ? 'win11-nav-link-active' : '' }}" href="{{ route('categories.index') }}" @if(request()->routeIs('categories.*')) aria-current="page" @endif>
                <svg class="win11-nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path>
                    <line x1="7" y1="7" x2="7.01" y2="7"></line>
                </svg>
                <span class="win11-nav-link-text">Categories</span>
            </a>
        </li>
    </ul>
</li>
@endif

{{-- Administration Section (for Admin/Manager) --}}
@if(Auth::check() && in_array(Auth::user()->role, ['admin','manager']))
<li class="win11-nav-section" aria-label="Administration">
    <span class="win11-nav-section-title">Administration</span>
    <ul class="win11-nav-section-list" role="list">
        <li class="win11-nav-item">
            <a class="win11-nav-link {{ request()->routeIs('admin.users.*') ? 'win11-nav-link-active' : '' }}" href="{{ route('admin.users.index') }}" @if(request()->routeIs('admin.users.*')) aria-current="page" @endif>
                <svg class="win11-nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
                <span class="win11-nav-link-text">User Management</span>
            </a>
        </li>
    </ul>
</li>
@endif

{{-- Account Section --}}
@auth
<li class="win11-nav-section" aria-label="Account">
    <span class="win11-nav-section-title">Account</span>
    <ul class="win11-nav-section-list" role="list">
        <li class="win11-nav-item">
            <a class="win11-nav-link {{ request()->routeIs('profile.edit') ? 'win11-nav-link-active' : '' }}" href="{{ route('profile.edit') }}" @if(request()->routeIs('profile.edit')) aria-current="page" @endif>
                <svg class="win11-nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
                <span class="win11-nav-link-text">Profile</span>
            </a>
        </li>
        <li class="win11-nav-item">
            <a class="win11-nav-link {{ request()->routeIs('reports.inventory') ? 'win11-nav-link-active' : '' }}" href="{{ route('reports.inventory') }}" @if(request()->routeIs('reports.inventory')) aria-current="page" @endif>
                <svg class="win11-nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14,2 14,8 20,8"></polyline>
                    <line x1="16" y1="13" x2="8" y2="13"></line>
                    <line x1="16" y1="17" x2="8" y2="17"></line>
                    <polyline points="10,9 9,9 8,9"></polyline>
                </svg>
                <span class="win11-nav-link-text">Reports</span>
            </a>
        </li>
        {{-- Note: Notifications are now handled in the sidebar-nav partial --}}
        @include('layouts.sidebar-notifications')
        <li class="win11-nav-item">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="win11-nav-link win11-w-full win11-text-start" type="submit">
                    <svg class="win11-nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                        <polyline points="16,17 21,12 16,7"></polyline>
                        <line x1="21" y1="12" x2="9" y2="12"></line>
                    </svg>
                    <span class="win11-nav-link-text">Log Out</span>
                </button>
            </form>
        </li>
    </ul>
</li>
@endauth

{{-- Appearance Section --}}
<li class="win11-nav-section" aria-label="Appearance">
    <span class="win11-nav-section-title">Appearance</span>
    <ul class="win11-nav-section-list" role="list">
        {{-- Link to the new Appearance Settings page --}}
        <li class="win11-nav-item">
            <a class="win11-nav-link {{ request()->routeIs('admin.settings.appearance') ? 'win11-nav-link-active' : '' }}" href="{{ route('admin.settings.appearance') }}">
                <svg class="win11-nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="13.5" cy="6.5" r=".5"></circle>
                    <circle cx="17.5" cy="10.5" r=".5"></circle>
                    <circle cx="8.5" cy="7.5" r=".5"></circle>
                    <circle cx="6.5" cy="12.5" r=".5"></circle>
                    <path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.555-2.503 5.555-5.554C21.965 6.012 17.461 2 12 2z"></path>
                </svg>
                <span class="win11-nav-link-text">Appearance</span>
            </a>
        </li>

        {{-- The one, correct theme toggle --}}
        <li class="win11-nav-item win11-flex win11-items-center win11-justify-between win11-px-3 win11-py-2">
            <div class="win11-flex win11-items-center win11-gap-2">
                <svg class="win11-nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="5"></circle>
                    <path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"></path>
                </svg>
                <span>Dark Mode</span>
            </div>
            <x-theme-toggle />
        </li>

        {{-- Language switcher remains --}}
        <li class="win11-nav-item">
            <div class="win11-px-2 win11-py-2">
                <x-language-switcher />
            </div>
        </li>
    </ul>
</li>