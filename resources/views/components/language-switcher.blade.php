@php($current = app()->getLocale())
<div class="inline-flex items-center gap-1" role="group" aria-label="Language switcher">
    <form method="POST" action="{{ route('locale.switch') }}">
        @csrf
        <input type="hidden" name="locale" value="en">
        <button type="submit" class="px-2 py-1 text-sm rounded-md border {{ $current === 'en' ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50' }}" aria-pressed="{{ $current === 'en' ? 'true' : 'false' }}" aria-label="Switch to English">EN</button>
    </form>
    <form method="POST" action="{{ route('locale.switch') }}">
        @csrf
        <input type="hidden" name="locale" value="ms">
        <button type="submit" class="px-2 py-1 text-sm rounded-md border {{ $current === 'ms' ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50' }}" aria-pressed="{{ $current === 'ms' ? 'true' : 'false' }}" aria-label="Tukar ke Bahasa Melayu">BM</button>
    </form>
</div>