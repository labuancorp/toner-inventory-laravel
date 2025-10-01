@props(['name' => 'home', 'class' => 'w-5 h-5'])

@php
    $icons = [
        'home' => '<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955a.75.75 0 011.06 0L21.218 12M4.5 10.5V21a.75.75 0 00.75.75h4.5a.75.75 0 00.75-.75v-4.5a.75.75 0 01.75-.75h2.25a.75.75 0 01.75.75V21a.75.75 0 00.75.75h4.5a.75.75 0 00.75-.75V10.5" />',
        'stack' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9.75l7.5-4.5 7.5 4.5m-15 4.5l7.5 4.5 7.5-4.5m-15-9v9a.75.75 0 00.375.65l7.5 4.5a.75.75 0 00.75 0l7.5-4.5a.75.75 0 00.375-.65v-9" />',
        'folder' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3 7.5A2.25 2.25 0 015.25 5.25h3.879a2.25 2.25 0 011.591.659l.621.621a2.25 2.25 0 001.591.659H18.75A2.25 2.25 0 0121 9.75v8.25A2.25 2.25 0 0118.75 20.25H5.25A2.25 2.25 0 013 18V7.5z" />',
        'shopping-cart' => '<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 2.25h1.386a.75.75 0 01.725.56l.691 2.763m0 0L6.75 14.25a2.25 2.25 0 002.25 1.5h7.5a2.25 2.25 0 002.24-1.97l.75-6a.75.75 0 00-.74-.83H5.052m0 0L4.5 3.75M6.75 18.75a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zm10.5 0a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />',
        'chart-bar' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 19.5h16.5M6 15.75v-6a.75.75 0 01.75-.75h1.5a.75.75 0 01.75.75v6A.75.75 0 019 16.5H6.75A.75.75 0 016 15.75zm6 0V7.5a.75.75 0 01.75-.75h1.5a.75.75 0 01.75.75v8.25a.75.75 0 01-.75.75H12.75a.75.75 0 01-.75-.75zm6 0v-3a.75.75 0 01.75-.75h1.5a.75.75 0 01.75.75v3a.75.75 0 01-.75.75H18.75a.75.75 0 01-.75-.75z" />',
        'bell' => '<path stroke-linecap="round" stroke-linejoin="round" d="M14.25 18.75a2.25 2.25 0 11-4.5 0m9-6a6.75 6.75 0 10-13.5 0v2.25a1.5 1.5 0 01-1.5 1.5h15a1.5 1.5 0 01-1.5-1.5V12.75z" />',
        'plus' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />',
        'eye' => '<path stroke-linecap="round" stroke-linejoin="round" d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z" /><circle cx="12" cy="12" r="3" />',
        'eye-off' => '<path stroke-linecap="round" stroke-linejoin="round" d="M17.94 17.94A10.94 10.94 0 0112 20c-7 0-11-8-11-8a21.58 21.58 0 015.06-6.94M9.88 4.12A10.94 10.94 0 0112 4c7 0 11 8 11 8a21.58 21.58 0 01-4.62 6.2" /><path d="M1 1l22 22" />',
        'brand-google' => '<path fill="#EA4335" d="M12 10.2v3.6h5.1c-.2 1.1-1.2 3.2-5.1 3.2-3 0-5.4-2.5-5.4-5.6s2.4-5.6 5.4-5.6c1.7 0 2.9.7 3.6 1.3l2.4-2.3C16.8 3.4 14.6 2.4 12 2.4 6.9 2.4 2.7 6.6 2.7 11.7s4.2 9.3 9.3 9.3c5.4 0 9-3.8 9-9.2 0-.6-.1-1-.2-1.5H12z"/>',
        'brand-microsoft' => '<path fill="#F25022" d="M11 11H3V3h8z"/><path fill="#7FBA00" d="M21 11h-8V3h8z"/><path fill="#00A4EF" d="M11 21H3v-8h8z"/><path fill="#FFB900" d="M21 21h-8v-8h8z"/>',
        'sun' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-6.364-.386l1.591-1.591M3 12h2.25m.386-6.364l1.591 1.591" />',
        'moon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" />',
    ];
    $svg = $icons[$name] ?? $icons['home'];
    $isBrand = str_starts_with($name, 'brand-');
@endphp

<svg {{ $attributes }} xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="{{ $class }}"
    @if(!$isBrand)
        fill="none"
        stroke="currentColor"
        stroke-width="2"
    @endif
>
    {!! $svg !!}
</svg>