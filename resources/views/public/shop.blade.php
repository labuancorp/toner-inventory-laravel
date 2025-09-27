<x-layouts.public>
    <div class="py-8">
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded p-6">
                @if(session('status'))
                    <div class="mb-4 p-3 rounded bg-emerald-50 text-emerald-700">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="flex items-center justify-between mb-4">
                    <h1 class="text-xl font-semibold">Order Toners</h1>
                </div>
                <div>
                    @php($topItems = $items->take(3))
                    @php($otherItems = $items->skip(3))

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-6 md:gap-8 xl:gap-10 justify-items-center md:justify-items-stretch max-w-[1600px] mx-auto">
                        @foreach($topItems as $item)
                            <div class="border rounded p-5 md:p-6 h-full flex flex-col w-full">
                            <div class="flex items-start justify-between">
                                <div>
                                    <div class="font-semibold">{{ $item->name }}</div>
                                    <div class="text-sm text-gray-500">SKU: {{ $item->sku }} • {{ $item->category->name }}</div>
                                </div>
                                <span class="px-2 py-1 text-xs rounded {{ $item->quantity > 0 ? 'bg-indigo-50 text-indigo-700' : 'bg-rose-50 text-rose-700' }}">Qty: {{ $item->quantity }}</span>
                            </div>
                            <div class="mt-3 mt-auto">
                                <form method="POST" action="{{ route('order.store') }}" class="space-y-2">
                                    @csrf
                                    <input type="hidden" name="item_id" value="{{ $item->id }}" />
                                    <div class="flex items-center gap-2">
                                        <label class="text-sm text-gray-700">Quantity</label>
                                        <input type="number" name="quantity" min="1" max="{{ max($item->quantity, 1) }}" class="border rounded px-2 py-1 w-24" />
                                    </div>
                                    <div>
                                        <input type="text" name="customer_name" placeholder="Your name (optional)" class="border rounded px-3 py-2 w-full" />
                                    </div>
                                    <div>
                                        <input type="text" name="notes" placeholder="Notes (optional)" class="border rounded px-3 py-2 w-full" />
                                    </div>
                                    @error('quantity')
                                        <p class="text-sm text-rose-600">{{ $message }}</p>
                                    @enderror
                                    <button class="inline-flex items-center gap-2 px-3 py-2 bg-amber-600 text-white rounded hover:bg-amber-700">
                                        <x-icon name="shopping-cart" class="w-4 h-4" />
                                        <span>Order</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                    </div>

                    @if($otherItems->count() > 0)
                        <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-4 xl:grid-cols-4 gap-6 md:gap-8 xl:gap-10 justify-items-center md:justify-items-stretch max-w-[1600px] mx-auto">
                            @foreach($otherItems as $item)
                                <div class="border rounded p-5 md:p-6 h-full flex flex-col w-full">
                                    <div class="flex items-start justify-between">
                                        <div>
                                            <div class="font-semibold">{{ $item->name }}</div>
                                            <div class="text-sm text-gray-500">SKU: {{ $item->sku }} • {{ $item->category->name }}</div>
                                        </div>
                                        <span class="px-2 py-1 text-xs rounded {{ $item->quantity > 0 ? 'bg-indigo-50 text-indigo-700' : 'bg-rose-50 text-rose-700' }}">Qty: {{ $item->quantity }}</span>
                                    </div>
                                    <div class="mt-3 mt-auto">
                                        <form method="POST" action="{{ route('order.store') }}" class="space-y-2">
                                            @csrf
                                            <input type="hidden" name="item_id" value="{{ $item->id }}" />
                                            <div class="flex items-center gap-2">
                                                <label class="text-sm text-gray-700">Quantity</label>
                                                <input type="number" name="quantity" min="1" max="{{ max($item->quantity, 1) }}" class="border rounded px-2 py-1 w-24" />
                                            </div>
                                            <div>
                                                <input type="text" name="customer_name" placeholder="Your name (optional)" class="border rounded px-3 py-2 w-full" />
                                            </div>
                                            <div>
                                                <input type="text" name="notes" placeholder="Notes (optional)" class="border rounded px-3 py-2 w-full" />
                                            </div>
                                            @error('quantity')
                                                <p class="text-sm text-rose-600">{{ $message }}</p>
                                            @enderror
                                            <button class="inline-flex items-center gap-2 px-3 py-2 bg-amber-600 text-white rounded hover:bg-amber-700">
                                                <x-icon name="shopping-cart" class="w-4 h-4" />
                                                <span>Order</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layouts.public>