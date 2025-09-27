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
                    <h1 class="text-2xl font-semibold tracking-tight">Order Toners</h1>
                </div>
                <div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-4 xl:grid-cols-4 gap-5 sm:gap-6 md:gap-8 xl:gap-10 justify-items-stretch">
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
                                    <form method="POST" action="{{ route('order.store') }}" class="space-y-3">
                                        @csrf
                                        <input type="hidden" name="item_id" value="{{ $item->id }}" />
                                        <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-2">
                                            <label for="quantity-{{ $item->id }}" class="text-sm text-gray-700">Quantity</label>
                                            <input id="quantity-{{ $item->id }}" type="number" name="quantity" min="1" max="{{ max($item->quantity, 1) }}" required class="border rounded-md px-2 py-1 w-full sm:w-24 md:w-28 focus:outline-none focus:ring-2 focus:ring-indigo-500" aria-label="Order quantity for {{ $item->name }}" />
                                        </div>
                                        <div>
                                            <input type="text" name="customer_name" placeholder="Your name (optional)" class="border rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                                        </div>
                                        <div>
                                            <input type="text" name="notes" placeholder="Notes (optional)" class="border rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                                        </div>
                                        @error('quantity')
                                            <p class="text-sm text-rose-600">{{ $message }}</p>
                                        @enderror
                                        <button class="inline-flex items-center gap-2 px-3 py-2 bg-amber-600 text-white rounded-md hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-amber-500 w-full sm:w-auto justify-center sm:justify-start">
                                            <x-icon name="shopping-cart" class="w-4 h-4" />
                                            <span>Order</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.public>