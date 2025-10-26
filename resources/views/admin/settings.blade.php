@extends('layouts.material')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Agency Settings</h2>
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 px-3 py-1.5 text-sm border border-gray-300 dark:border-gray-600 rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back
            </a>
        </div>
        <div class="p-6">
            @if(session('status'))
                <div class="mb-4 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200 rounded-md" role="status">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('admin.settings.logo.update') }}" enctype="multipart/form-data" class="space-y-6" aria-labelledby="logoUploadHeading">
                @csrf
                <div>
                    <h3 id="logoUploadHeading" class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Agency Logo</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">Supported formats: PNG, JPG, SVG. Max 2 MB.</p>
                    <div class="flex items-start gap-6">
                        <div class="flex-1">
                            <input type="file" name="agency_logo" id="agencyLogoInput" accept=".png,.jpg,.jpeg,.svg" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" aria-describedby="logoHelp">
                            <div id="logoHelp" class="text-gray-600 dark:text-gray-400 text-sm mt-1">Choose a logo to preview before saving.</div>
                            @error('agency_logo')
                                <div class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Save Logo
                        </button>
                    </div>
                </div>

                <div>
                    <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Preview</h4>
                    <div class="border border-gray-300 dark:border-gray-600 rounded-md p-4 bg-gray-50 dark:bg-gray-700 inline-flex items-center justify-center" style="max-width: 240px; max-height: 72px;">
                        <img id="agencyLogoPreview" src="{{ $logo ? asset('storage/'.$logo) : asset('images/pl-logo.svg') }}" alt="Agency logo preview" class="max-h-16 w-auto" style="object-fit: contain;" />
                    </div>
                </div>
            </form>

            <div class="mt-6">
                <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Current Logo</h4>
                <div class="border border-gray-300 dark:border-gray-600 rounded-md p-4 bg-white dark:bg-gray-800 inline-flex items-center justify-center" style="max-width: 240px; max-height: 72px;">
                    <img src="{{ $logo ? asset('storage/'.$logo) : asset('images/pl-logo.svg') }}" alt="Current agency logo" class="max-h-16 w-auto" style="object-fit: contain;" />
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