@extends('layouts.material')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Scan Barcode</h4>
                    <a href="{{ route('items.index') }}" class="btn btn-outline-secondary btn-sm">Back to Items</a>
                </div>
                <div class="card-body">
                    <p class="text-muted">Use your device camera to scan a barcode. On successful scan, we’ll look up the SKU and open the item.</p>
                    <div class="mb-3">
                        <video id="camera" playsinline class="w-100 rounded border" style="max-height: 320px;"></video>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Or enter SKU manually</label>
                        <div class="input-group">
                            <input id="manualSku" class="form-control" placeholder="Enter or scan SKU" />
                            <button id="goBtn" class="btn btn-primary">Go</button>
                        </div>
                    </div>

                    <div id="status" class="small text-muted">Initializing scanner…</div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
(function(){
  const statusEl = document.getElementById('status');
  const video = document.getElementById('camera');
  const manual = document.getElementById('manualSku');
  const goBtn = document.getElementById('goBtn');

  function navigateToSku(sku){
    if(!sku) return;
    window.location.href = `{{ route('items.lookup', '__SKU__') }}`.replace('__SKU__', encodeURIComponent(sku));
  }

  goBtn.addEventListener('click', () => navigateToSku(manual.value.trim()));
  manual.addEventListener('keydown', (e) => { if(e.key === 'Enter'){ navigateToSku(manual.value.trim()); }});

  const BarcodeDetectorSupported = 'BarcodeDetector' in window;
  if(!BarcodeDetectorSupported){
    statusEl.textContent = 'BarcodeDetector not supported. Use manual SKU input.';
    return;
  }

  const detector = new BarcodeDetector({ formats: ['code_128','ean_13','ean_8','upc_a','upc_e'] });

  async function startCamera(){
    try{
      const stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } });
      video.srcObject = stream;
      await video.play();
      statusEl.textContent = 'Point the camera at a barcode.';
      requestAnimationFrame(scanFrame);
    }catch(err){
      console.error(err);
      statusEl.textContent = 'Camera access failed. Use manual SKU input.';
    }
  }

  async function scanFrame(){
    try{
      // Detect directly from the video element for broader compatibility
      const codes = await detector.detect(video);
      if(codes && codes.length){
        const sku = codes[0].rawValue || codes[0].value;
        statusEl.textContent = `Scanned: ${sku}`;
        navigateToSku(sku);
        return; // stop scanning after first hit
      }
    }catch(err){
      // swallow per-frame errors
    }
    requestAnimationFrame(scanFrame);
  }

  startCamera();
})();
</script>
@endpush
@endsection