<x-layouts.public>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
        @if(session('status'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('status') }}
            </div>
        @endif

        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ __('app.shop.title') }}</h1>
            <div class="flex items-center gap-2" aria-label="View toggle">
                <button id="shopToggleComfortable" type="button" class="px-4 py-2 rounded-md bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">{{ __('app.shop.comfortable') }}</button>
                <button id="shopToggleCompact" type="button" class="px-4 py-2 rounded-md bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">{{ __('app.shop.compact') }}</button>
            </div>
        </div>
        <div>
            <!-- safelist classes for Tailwind build -->
            <div class="hidden">
                <span class="grid grid-cols-4"></span>
                <span class="grid grid-cols-3"></span>
            </div>
            <div class="mb-6">
                {{ $items->links() }}
            </div>
            <div id="shopGrid" class="grid grid-cols-4 gap-4">
                @foreach($items as $item)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 p-4">
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <div class="font-semibold text-gray-900 dark:text-gray-100">{{ $item->name }}</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">SKU: {{ $item->sku }} • {{ $item->category->name }}</div>
                            </div>
                            <span class="px-2 py-1 text-xs rounded-full {{ $item->quantity > 0 ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">Qty: {{ $item->quantity }}</span>
                        </div>
                        <div>
                            @auth
                            <form method="POST" action="{{ route('order.store') }}" class="flex flex-col gap-4">
                                @csrf
                                <input type="hidden" name="item_id" value="{{ $item->id }}" />
                                <div>
                                    <label for="quantity-{{ $item->id }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('app.shop.quantity') }}</label>
                                    <input id="quantity-{{ $item->id }}" type="number" name="quantity" min="1" max="{{ max($item->quantity, 1) }}" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100" aria-label="Order quantity for {{ $item->name }}" />
                                </div>
                                <div>
                                    <input type="text" name="customer_name" placeholder="{{ __('app.form.customer_name_placeholder') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100" />
                                </div>
                                <div>
                                    <input type="text" name="shipping_address" placeholder="{{ __('app.form.shipping_address_placeholder') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100" />
                                </div>
                                <div>
                                    <input type="text" name="notes" placeholder="{{ __('app.form.notes_placeholder') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100" />
                                </div>
                                @error('quantity')
                                    <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                                <button class="px-4 py-2 rounded-md bg-blue-600 text-white hover:bg-blue-700 transition-colors flex items-center gap-2">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.293 2.293c-.63.63-.184 1.707.707 1.707H19M7 13v4a2 2 0 002 2h2m3-6v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m6 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01" />
                                    </svg>
                                    <span>{{ __('app.shop.order') }}</span>
                                </button>
                            </form>
                            @else
                            <div class="flex flex-col gap-4">
                                <p class="text-gray-600 dark:text-gray-400">{{ __('app.shop.please_login') }}</p>
                                <div class="flex gap-2">
                                    <a href="{{ route('login') }}" class="px-4 py-2 rounded-md bg-blue-600 text-white hover:bg-blue-700 transition-colors flex items-center gap-2">
                                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                        </svg>
                                        <span>{{ __('app.nav.login') }}</span>
                                    </a>
                                    <a href="{{ route('register') }}" class="px-4 py-2 rounded-md bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors flex items-center gap-2">
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