@extends('layouts.material')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-0">Item Details</h4>
                        <small class="text-muted">SKU: {{ $item->sku }} • Category: {{ $item->category->name }}</small>
                    </div>
                    <div class="d-flex gap-2">
                        @can('update', $item)
                            <a href="{{ route('items.edit', $item) }}" class="btn btn-outline-secondary btn-sm">Edit</a>
                        @endcan
                        @can('delete', $item)
                        <form action="{{ route('items.destroy', $item) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-outline-danger btn-sm">Delete</button>
                        </form>
                        @endcan
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3 class="mb-0">{{ $item->name }}</h3>
                        @if($item->needs_reorder)
                            <span class="badge bg-danger">Needs Reorder</span>
                        @endif
                    </div>
                    <p class="mb-3">Qty: <strong id="liveQty">{{ $item->quantity }}</strong> • Reorder level: <span id="liveReorder">{{ $item->reorder_level }}</span></p>

                    @if($item->image_path)
                        <div class="mb-4 text-center">
                            <img src="{{ asset('storage/'.$item->image_path) }}" alt="{{ $item->name }}" class="img-fluid rounded border" style="max-height: 240px; object-fit: contain;" />
                            @can('update', $item)
                                <form action="{{ route('items.image.destroy', $item) }}" method="POST" class="mt-2 d-inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-outline-danger btn-sm" onclick="return confirm('Remove current image?')">Delete Image</button>
                                </form>
                            @endcan
                        </div>
                    @endif

                    <div class="row g-4">
                        <div class="col-md-6">
                            <h5 class="mb-2">Barcode</h5>
                            <div class="border rounded p-3 bg-white">
                                @php
                                    $generator = new \Picqer\Barcode\BarcodeGeneratorSVG();
                                    $typeConst = \Picqer\Barcode\BarcodeGenerator::TYPE_CODE_128;
                                    echo $generator->getBarcode($item->sku, $typeConst);
                                @endphp
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h5 class="mb-2">QR Code</h5>
                            <div class="border rounded p-3 bg-white" style="width: 256px; height: 256px;">
                                @php
                                    $opts = new \chillerlan\QRCode\QROptions([
                                        'outputType'    => \chillerlan\QRCode\QRCode::OUTPUT_MARKUP_SVG,
                                        'eccLevel'      => \chillerlan\QRCode\QRCode::ECC_Q,
                                        'scale'         => 12,
                                        'addQuietzone'  => true,
                                        'quietzoneSize' => 4,
                                        'svgViewBox'    => true,
                                    ]);
                                    $payload = route('items.show', $item);
                                    $qrOutput = (new \chillerlan\QRCode\QRCode($opts))->render($payload);
                                @endphp
                                @if(\Illuminate\Support\Str::startsWith($qrOutput, 'data:image'))
                                    <img src="{{ $qrOutput }}" alt="QR Code" width="256" height="256" />
                                @else
                                    {!! $qrOutput !!}
                                @endif
                            </div>
                        </div>
                    </div>

                    @can('update', $item)
                    <div class="mt-4">
                        <h5 class="mb-2">Adjust Stock</h5>
                        <form action="{{ route('items.adjustStock', $item) }}" method="POST" class="row g-3 align-items-end">
                            @csrf
                            <div class="col-md-3">
                                <label class="form-label">Type</label>
                                <select name="type" class="form-select">
                                    <option value="in">Add (IN)</option>
                                    <option value="out">Remove (OUT)</option>
                                </select>
                                @error('type')<div class="text-danger small">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Quantity</label>
                                <input type="number" name="quantity" value="1" min="1" class="form-control" />
                                @error('quantity')<div class="text-danger small">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Reason (optional)</label>
                                <input name="reason" class="form-control" />
                                @error('reason')<div class="text-danger small">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-2 d-grid">
                                <button class="btn btn-primary">Apply</button>
                            </div>
                        </form>
                    </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script src="https://js.pusher.com/8.4/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.16.0/dist/echo.iife.js"></script>
<script>
(function(){
  const itemId = {{ $item->id }};
  const qtyEl = document.getElementById('liveQty');
  const reorderEl = document.getElementById('liveReorder');
  const needsBadge = document.querySelector('.badge.bg-danger');

  function applyUpdate(data){
    if(typeof data.new_quantity === 'number'){ qtyEl.textContent = data.new_quantity; }
    const needs = (data.new_quantity ?? parseInt(qtyEl.textContent, 10)) <= parseInt(reorderEl.textContent, 10);
    if(needs && !needsBadge){
      const badge = document.createElement('span');
      badge.className = 'badge bg-danger';
      badge.textContent = 'Needs Reorder';
      document.querySelector('.d-flex.justify-content-between.align-items-center.mb-3').appendChild(badge);
    } else if(!needs && needsBadge){
      needsBadge.remove();
    }
  }

  // Try to initialize Echo over Pusher if keys are present, else fallback to polling
  try {
    const PUSHER_KEY = '{{ config('broadcasting.connections.pusher.key') }}';
    if(PUSHER_KEY){
      window.Pusher = window.Pusher || Pusher;
      window.Echo = new Echo.Echo({
        broadcaster: 'pusher',
        key: PUSHER_KEY,
        wsHost: window.location.hostname,
        wsPort: 6001,
        forceTLS: false,
        disableStats: true,
        // with auth headers if needed
        auth: { headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } }
      });

      window.Echo.private('items.'+itemId)
        .listen('.StockAdjusted', (e) => {
          applyUpdate(e);
        });
      return; // websockets enabled
    }
  } catch(e) {
    // fall through to polling
  }

  // Polling fallback every 3s
  async function poll(){
    try{
      const res = await fetch('{{ route('items.show.json', $item) }}', { headers: { 'Accept': 'application/json' } });
      if(res.ok){
        const data = await res.json();
        applyUpdate({ new_quantity: data.quantity });
      }
    }catch(err){ /* ignore */ }
  }
  setInterval(poll, 3000);
})();
</script>
@endpush
@endsection