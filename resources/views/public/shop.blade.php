<x-layouts.public>
    <div class="py-8 md:py-10">
        <div class="px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
            <div class="bg-white/90 bg-gradient-soft backdrop-blur-sm shadow-sm rounded-lg p-6 md:p-8">
                @if(session('status'))
                    <div class="mb-4 p-3 rounded-lg bg-emerald-50 text-emerald-700">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="flex items-center justify-between mb-6">
                    <h1 class="text-2xl font-semibold tracking-tight">{{ __('app.shop.title') }}</h1>
                    <div class="flex items-center gap-2" aria-label="View toggle">
                        <button id="shopToggleComfortable" type="button" class="px-3 py-1 text-sm rounded border border-gray-300 bg-white text-gray-700 hover:bg-gray-50">{{ __('app.shop.comfortable') }}</button>
                        <button id="shopToggleCompact" type="button" class="px-3 py-1 text-sm rounded border border-gray-300 bg-white text-gray-700 hover:bg-gray-50">{{ __('app.shop.compact') }}</button>
                    </div>
                </div>
                <div>
                    <!-- safelist classes for Tailwind build -->
                    <div class="hidden">
                        <span class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-4 xl:grid-cols-4"></span>
                        <span class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-4"></span>
                    </div>
                    <div class="mt-6">
                        {{ $items->links() }}
                    </div>
                    <div id="shopGrid" class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-4 xl:grid-cols-4 gap-5 sm:gap-6 md:gap-8 xl:gap-10 justify-items-stretch">
                        @foreach($items as $item)
                            <div class="group rounded-lg border border-gray-200 bg-white/80 bg-gradient-card backdrop-blur-sm shadow-sm hover:shadow-md transition-shadow duration-200 h-full flex flex-col w-full p-5 md:p-6">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <div class="font-semibold text-gray-900">{{ $item->name }}</div>
                                        <div class="text-sm text-gray-500">SKU: {{ $item->sku }} • {{ $item->category->name }}</div>
                                    </div>
                                    <span class="px-2 py-1 text-xs rounded-lg {{ $item->quantity > 0 ? 'bg-indigo-50 text-indigo-700' : 'bg-rose-50 text-rose-700' }}">Qty: {{ $item->quantity }}</span>
                                </div>
                                <div class="mt-3 mt-auto">
                                    @auth
                                    <form method="POST" action="{{ route('order.store') }}" class="space-y-3">
                                        @csrf
                                        <input type="hidden" name="item_id" value="{{ $item->id }}" />
                                        <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-2">
                                            <label for="quantity-{{ $item->id }}" class="text-sm text-gray-700">{{ __('app.shop.quantity') }}</label>
                                            <input id="quantity-{{ $item->id }}" type="number" name="quantity" min="1" max="{{ max($item->quantity, 1) }}" required class="border rounded-md px-2 py-1 w-full sm:w-24 md:w-28 focus:outline-none focus:ring-2 focus:ring-indigo-500" aria-label="Order quantity for {{ $item->name }}" />
                                        </div>
                                        <div>
                                            <input type="text" name="customer_name" placeholder="{{ __('app.shop.customer_name_placeholder') }}" class="border rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                                        </div>
                                        <div>
                                            <input type="text" name="shipping_address" placeholder="{{ __('app.shop.shipping_address_placeholder') }}" class="border rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                                        </div>
                                        <div>
                                            <input type="text" name="notes" placeholder="{{ __('app.shop.notes_placeholder') }}" class="border rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                                        </div>
                                        @error('quantity')
                                            <p class="text-sm text-rose-600">{{ $message }}</p>
                                        @enderror
                                        <button class="inline-flex items-center gap-2 px-3 py-2 bg-amber-600 text-white rounded-md hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-amber-500 w-full sm:w-auto justify-center sm:justify-start">
                                            <x-icon name="shopping-cart" class="w-4 h-4" />
                                            <span>{{ __('app.shop.order') }}</span>
                                        </button>
                                    </form>
                                    @else
                                    <div class="space-y-3">
                                        <p class="text-sm text-gray-700">{{ __('app.shop.please_login') }}</p>
                                        <div class="flex flex-wrap gap-2">
                                            <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-3 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                                <i class="ti ti-login" aria-hidden="true"></i>
                                                <span>{{ __('app.nav.login') }}</span>
                                            </a>
                                            <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-3 py-2 bg-gray-100 text-gray-800 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300">
                                                <i class="ti ti-user-plus" aria-hidden="true"></i>
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