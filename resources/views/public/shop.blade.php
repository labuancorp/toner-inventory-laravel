<x-layouts.public>
    <div class="win11-page-card">
        @if(session('status'))
            <div class="win11-badge win11-badge-success win11-m-md">
                {{ session('status') }}
            </div>
        @endif

        <div class="win11-flex items-center justify-between win11-m-lg">
            <h1 style="font-size: var(--win11-font-size-title); font-weight: var(--win11-font-weight-semibold); color: var(--win11-text-primary);">{{ __('app.shop.title') }}</h1>
            <div class="win11-flex items-center win11-gap-sm" aria-label="View toggle">
                <button id="shopToggleComfortable" type="button" class="win11-button">{{ __('app.shop.comfortable') }}</button>
                <button id="shopToggleCompact" type="button" class="win11-button">{{ __('app.shop.compact') }}</button>
            </div>
        </div>
        <div>
            <!-- safelist classes for Tailwind build -->
            <div class="hidden">
                <span class="win11-grid win11-grid-cols-4"></span>
                <span class="win11-grid win11-grid-cols-3"></span>
            </div>
            <div class="win11-m-lg">
                {{ $items->links() }}
            </div>
            <div id="shopGrid" class="win11-grid win11-grid-cols-4">
                @foreach($items as $item)
                    <div class="win11-card win11-stagger-item win11-reveal">
                        <div class="win11-flex items-start justify-between win11-m-md">
                            <div>
                                <div style="font-weight: var(--win11-font-weight-semibold); color: var(--win11-text-primary);">{{ $item->name }}</div>
                                <div style="font-size: var(--win11-font-size-caption); color: var(--win11-text-secondary);">SKU: {{ $item->sku }} • {{ $item->category->name }}</div>
                            </div>
                            <span class="win11-badge {{ $item->quantity > 0 ? 'win11-badge-accent' : 'win11-badge-error' }}">Qty: {{ $item->quantity }}</span>
                        </div>
                        <div class="win11-m-md">
                            @auth
                            <form method="POST" action="{{ route('order.store') }}" class="win11-flex win11-flex-col win11-gap-md">
                                @csrf
                                <input type="hidden" name="item_id" value="{{ $item->id }}" />
                                <div class="win11-form-group">
                                    <label for="quantity-{{ $item->id }}" class="win11-form-label">{{ __('app.shop.quantity') }}</label>
                                    <input id="quantity-{{ $item->id }}" type="number" name="quantity" min="1" max="{{ max($item->quantity, 1) }}" required class="win11-input" aria-label="Order quantity for {{ $item->name }}" />
                                </div>
                                <div class="win11-form-group">
                                    <input type="text" name="customer_name" placeholder="{{ __('app.form.customer_name_placeholder') }}" class="win11-input" />
                                </div>
                                <div class="win11-form-group">
                                    <input type="text" name="shipping_address" placeholder="{{ __('app.form.shipping_address_placeholder') }}" class="win11-input" />
                                </div>
                                <div class="win11-form-group">
                                    <input type="text" name="notes" placeholder="{{ __('app.form.notes_placeholder') }}" class="win11-input" />
                                </div>
                                @error('quantity')
                                    <p style="font-size: var(--win11-font-size-caption); color: var(--win11-system-error-text);">{{ $message }}</p>
                                @enderror
                                <button class="win11-button win11-button-accent win11-flex items-center win11-gap-sm">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.293 2.293c-.63.63-.184 1.707.707 1.707H19M7 13v4a2 2 0 002 2h2m3-6v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m6 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01" />
                                    </svg>
                                    <span>{{ __('app.shop.order') }}</span>
                                </button>
                            </form>
                            @else
                            <div class="win11-flex win11-flex-col win11-gap-md">
                                <p style="font-size: var(--win11-font-size-body); color: var(--win11-text-secondary);">{{ __('app.shop.please_login') }}</p>
                                <div class="win11-flex win11-gap-sm">
                                    <a href="{{ route('login') }}" class="win11-button win11-button-accent win11-flex items-center win11-gap-sm">
                                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                        </svg>
                                        <span>{{ __('app.nav.login') }}</span>
                                    </a>
                                    <a href="{{ route('register') }}" class="win11-button win11-flex items-center win11-gap-sm">
                                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                        </svg>
                                        <span>{{ __('app.nav.register') }}</span>
                                    </a>
                                </div>
                            </div>
                            @endauth
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@push('scripts')
<script>
  (function(){
    const grid = document.getElementById('shopGrid');
    const btnCompact = document.getElementById('shopToggleCompact');
    const btnComfort = document.getElementById('shopToggleComfortable');
    if(!grid || !btnCompact || !btnComfort) return;

    const clsCompact = 'grid grid-cols-2 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-4 xl:grid-cols-4 gap-5 sm:gap-6 md:gap-8 xl:gap-10 justify-items-stretch';
    const clsComfort = 'grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-4 gap-5 sm:gap-6 md:gap-8 xl:gap-10 justify-items-stretch';

    function setActive(mode){
      if(mode === 'compact'){
        grid.className = clsCompact;
        btnCompact.classList.add('bg-amber-50','border-amber-300','text-amber-700');
        btnComfort.classList.remove('bg-amber-50','border-amber-300','text-amber-700');
      } else {
        grid.className = clsComfort;
        btnComfort.classList.add('bg-amber-50','border-amber-300','text-amber-700');
        btnCompact.classList.remove('bg-amber-50','border-amber-300','text-amber-700');
      }
    }

    const saved = localStorage.getItem('shopViewMode') || 'compact';
    setActive(saved);
    btnCompact.addEventListener('click', function(){ localStorage.setItem('shopViewMode','compact'); setActive('compact'); });
    btnComfort.addEventListener('click', function(){ localStorage.setItem('shopViewMode','comfortable'); setActive('comfortable'); });
  })();
</script>
@endpush
</x-layouts.public>