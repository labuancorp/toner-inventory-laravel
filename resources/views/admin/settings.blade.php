@extends('layouts.material')

@section('content')
<div class="win11-max-w-4xl win11-mx-auto">
    <div class="win11-card">
        <div class="win11-card-header win11-flex win11-justify-between win11-items-center">
            <h2 class="win11-text-xl win11-font-semibold">Agency Settings</h2>
            <a href="{{ route('admin.dashboard') }}" class="win11-btn win11-btn-outline win11-btn-sm">
                <svg class="win11-w-4 win11-h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back
            </a>
        </div>
        <div class="win11-card-body">
            @if(session('status'))
                <div class="win11-alert win11-alert-success" role="status">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('admin.settings.logo.update') }}" enctype="multipart/form-data" class="win11-space-y-lg" aria-labelledby="logoUploadHeading">
                @csrf
                <div>
                    <h3 id="logoUploadHeading" class="win11-text-lg win11-font-semibold win11-mb-sm">Agency Logo</h3>
                    <p class="win11-text-muted win11-text-sm win11-mb-md">Supported formats: PNG, JPG, SVG. Max 2 MB.</p>
                    <div class="win11-flex win11-items-start win11-gap-lg">
                        <div class="win11-flex-1">
                            <input type="file" name="agency_logo" id="agencyLogoInput" accept=".png,.jpg,.jpeg,.svg" class="win11-input" aria-describedby="logoHelp">
                            <div id="logoHelp" class="win11-text-muted win11-text-sm win11-mt-xs">Choose a logo to preview before saving.</div>
                            @error('agency_logo')
                                <div class="win11-error win11-mt-xs">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="win11-btn win11-btn-primary">
                            <svg class="win11-w-4 win11-h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Save Logo
                        </button>
                    </div>
                </div>

                <div>
                    <h4 class="win11-font-semibold win11-mb-sm">Preview</h4>
                    <div class="win11-border win11-rounded win11-p-md win11-bg-gray-50 win11-inline-flex win11-items-center win11-justify-center" style="max-width: 240px; max-height: 72px;">
                        <img id="agencyLogoPreview" src="{{ $logo ? asset('storage/'.$logo) : asset('images/pl-logo.svg') }}" alt="Agency logo preview" class="win11-max-h-16 win11-w-auto" style="object-fit: contain;" />
                    </div>
                </div>
            </form>

            <div class="win11-mt-lg">
                <h4 class="win11-font-semibold win11-mb-sm">Current Logo</h4>
                <div class="win11-border win11-rounded win11-p-md win11-bg-white win11-inline-flex win11-items-center win11-justify-center" style="max-width: 240px; max-height: 72px;">
                    <img src="{{ $logo ? asset('storage/'.$logo) : asset('images/pl-logo.svg') }}" alt="Current agency logo" class="win11-max-h-16 win11-w-auto" style="object-fit: contain;" />
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