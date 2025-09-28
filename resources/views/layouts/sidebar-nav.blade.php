{{-- General Section --}}
<li class="nav-section" aria-label="General">
    <span class="nav-section-title">General</span>
    <ul class="nav-section-list" role="list">
        @if(Auth::check() && in_array(Auth::user()->role, ['admin','manager']))
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}" @if(request()->routeIs('dashboard')) aria-current="page" @endif>
                <i class="ti ti-layout-dashboard" aria-hidden="true"></i>
                <span class="nav-link-text">Dashboard</span>
            </a>
        </li>
        @endif
        @if(Auth::check() && in_array(Auth::user()->role, ['admin','manager']))
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}" @if(request()->routeIs('admin.dashboard')) aria-current="page" @endif>
                <i class="ti ti-shield" aria-hidden="true"></i>
                <span class="nav-link-text">Admin Dashboard</span>
            </a>
        </li>
        @endif
        <li class="nav-item">
            <a class="nav-link {{ request()->is('shop') ? 'active' : '' }}" href="{{ url('/shop') }}" @if(request()->is('shop')) aria-current="page" @endif>
                <i class="ti ti-shopping-cart" aria-hidden="true"></i>
                <span class="nav-link-text">Shop</span>
            </a>
        </li>
    </ul>
</li>

{{-- Inventory Section (for Admin/Manager) --}}
@if(Auth::check() && in_array(Auth::user()->role, ['admin','manager']))
<li class="nav-section" aria-label="Inventory">
    <span class="nav-section-title">Inventory</span>
    <ul class="nav-section-list" role="list">
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('items.index') ? 'active' : '' }}" href="{{ route('items.index') }}" @if(request()->routeIs('items.index')) aria-current="page" @endif>
                <i class="ti ti-box" aria-hidden="true"></i>
                <span class="nav-link-text">Items</span>
                <span class="badge bg-secondary ms-auto" aria-label="Items count">{{ \App\Models\Item::count() }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('items.trashed') ? 'active' : '' }}" href="{{ route('items.trashed') }}" @if(request()->routeIs('items.trashed')) aria-current="page" @endif>
                <i class="ti ti-trash" aria-hidden="true"></i>
                <span class="nav-link-text">Trashed Items</span>
                <span class="badge bg-secondary ms-auto" aria-label="Trashed items count">{{ \App\Models\Item::onlyTrashed()->count() }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('items.reorder') ? 'active' : '' }}" href="{{ route('items.reorder') }}" @if(request()->routeIs('items.reorder')) aria-current="page" @endif>
                <i class="ti ti-arrows-down-up" aria-hidden="true"></i>
                <span class="nav-link-text">Reorder Suggestions</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('items.scan') ? 'active' : '' }}" href="{{ route('items.scan') }}" @if(request()->routeIs('items.scan')) aria-current="page" @endif>
                <i class="ti ti-barcode" aria-hidden="true"></i>
                <span class="nav-link-text">Scan Barcode</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('reports.analytics') ? 'active' : '' }}" href="{{ route('reports.analytics') }}" @if(request()->routeIs('reports.analytics')) aria-current="page" @endif>
                <i class="ti ti-chart-bar" aria-hidden="true"></i>
                <span class="nav-link-text">Advanced Analytics</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('printers.*') ? 'active' : '' }}" href="{{ route('printers.index') }}" @if(request()->routeIs('printers.*')) aria-current="page" @endif>
                <i class="ti ti-printer" aria-hidden="true"></i>
                <span class="nav-link-text">Printers</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}" href="{{ route('categories.index') }}" @if(request()->routeIs('categories.*')) aria-current="page" @endif>
                <i class="ti ti-tags" aria-hidden="true"></i>
                <span class="nav-link-text">Categories</span>
            </a>
        </li>
    </ul>
</li>
@endif

{{-- Administration Section (for Admin/Manager) --}}
@if(Auth::check() && in_array(Auth::user()->role, ['admin','manager']))
<li class="nav-section" aria-label="Administration">
    <span class="nav-section-title">Administration</span>
    <ul class="nav-section-list" role="list">
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}" @if(request()->routeIs('admin.users.*')) aria-current="page" @endif>
                <i class="ti ti-users" aria-hidden="true"></i>
                <span class="nav-link-text">User Management</span>
            </a>
        </li>
    </ul>
</li>
@endif

{{-- Account Section --}}
@auth
<li class="nav-section" aria-label="Account">
    <span class="nav-section-title">Account</span>
    <ul class="nav-section-list" role="list">
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}" href="{{ route('profile.edit') }}" @if(request()->routeIs('profile.edit')) aria-current="page" @endif>
                <i class="ti ti-user" aria-hidden="true"></i>
                <span class="nav-link-text">Profile</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('reports.inventory') ? 'active' : '' }}" href="{{ route('reports.inventory') }}" @if(request()->routeIs('reports.inventory')) aria-current="page" @endif>
                <i class="ti ti-report-analytics" aria-hidden="true"></i>
                <span class="nav-link-text">Reports</span>
            </a>
        </li>
        {{-- Note: Notifications are now handled in the sidebar-nav partial --}}
        @include('layouts.sidebar-notifications')
        <li class="nav-item">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="nav-link w-100 text-start" type="submit">
                    <i class="ti ti-logout" aria-hidden="true"></i>
                    <span class="nav-link-text">Log Out</span>
                </button>
            </form>
        </li>
    </ul>
</li>
@endauth

{{-- Appearance Section --}}
<li class="nav-section" aria-label="Appearance">
    <span class="nav-section-title">Appearance</span>
    <ul class="nav-section-list" role="list">
        <li class="nav-item d-flex align-items-center">
            <div class="form-check form-switch mb-0">
                <input class="form-check-input" type="checkbox" id="themeSwitch" aria-label="Toggle dark mode">
                <label class="form-check-label d-flex align-items-center gap-2" for="themeSwitch">
                    <i class="ti ti-sun-moon" aria-hidden="true"></i>
                    <span>Dark mode</span>
                </label>
            </div>
        </li>
    </ul>
</li>