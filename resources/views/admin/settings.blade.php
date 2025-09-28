@extends('layouts.material')

@section('content')
<div class="container-fluid py-3">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-xl-7">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Agency Settings</h5>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-sm">Back</a>
                </div>
                <div class="card-body">
                    @if(session('status'))
                        <div class="alert alert-success" role="status">{{ session('status') }}</div>
                    @endif

                    <form method="POST" action="{{ route('admin.settings.logo.update') }}" enctype="multipart/form-data" class="mb-4" aria-labelledby="logoUploadHeading">
                        @csrf
                        <div class="mb-3">
                            <h6 id="logoUploadHeading" class="mb-2">Agency Logo</h6>
                            <p class="text-muted small mb-2">Supported formats: PNG, JPG, SVG. Max 2 MB.</p>
                            <div class="d-flex align-items-center gap-3">
                                <div>
                                    <input type="file" name="agency_logo" id="agencyLogoInput" accept=".png,.jpg,.jpeg,.svg" class="form-control" aria-describedby="logoHelp">
                                    <div id="logoHelp" class="form-text">Choose a logo to preview before saving.</div>
                                    @error('agency_logo')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">Save Logo</button>
                            </div>
                        </div>

                        <div class="mt-3">
                            <div class="fw-semibold mb-2">Preview</div>
                            <div class="border rounded p-3 bg-light d-inline-flex align-items-center justify-content-center" style="max-width: 240px; max-height: 72px; aspect-ratio: auto;">
                                <img id="agencyLogoPreview" src="{{ $logo ? asset('storage/'.$logo) : asset('images/pl-logo.svg') }}" alt="Agency logo preview" class="img-fluid" style="max-height: 64px; width: auto; object-fit: contain;" />
                            </div>
                        </div>
                    </form>

                    <div>
                        <h6 class="mb-2">Current Logo</h6>
                        <div class="border rounded p-3 bg-white d-inline-flex align-items-center justify-content-center" style="max-width: 240px; max-height: 72px;">
                            <img src="{{ $logo ? asset('storage/'.$logo) : asset('images/pl-logo.svg') }}" alt="Current agency logo" class="img-fluid" style="max-height: 64px; width: auto; object-fit: contain;" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('agencyLogoInput')?.addEventListener('change', function(e){
    const file = e.target.files && e.target.files[0];
    if(!file) return;
    const allowed = ['image/png','image/jpeg','image/svg+xml'];
    if(!allowed.includes(file.type)) return;
    const preview = document.getElementById('agencyLogoPreview');
    if(!preview) return;
    if(file.type === 'image/svg+xml'){
        const reader = new FileReader();
        reader.onload = function(ev){ preview.src = ev.target.result; };
        reader.readAsDataURL(file);
    } else {
        preview.src = URL.createObjectURL(file);
    }
});
</script>
@endpush
@endsection