@props(['name' => 'home', 'class' => 'w-5 h-5'])

@php
    $icons = [
        'home' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 12l8.954-8.955a.75.75 0 011.06 0L21.218 12M4.5 10.5V21a.75.75 0 00.75.75h4.5a.75.75 0 00.75-.75v-4.5a.75.75 0 01.75-.75h2.25a.75.75 0 01.75.75V21a.75.75 0 00.75.75h4.5a.75.75 0 00.75-.75V10.5" />',
        'stack' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.75 9.75l7.5-4.5 7.5 4.5m-15 4.5l7.5 4.5 7.5-4.5m-15-9v9a.75.75 0 00.375.65l7.5 4.5a.75.75 0 00.75 0l7.5-4.5a.75.75 0 00.375-.65v-9" />',
        'folder' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7.5A2.25 2.25 0 015.25 5.25h3.879a2.25 2.25 0 011.591.659l.621.621a2.25 2.25 0 001.591.659H18.75A2.25 2.25 0 0121 9.75v8.25A2.25 2.25 0 0118.75 20.25H5.25A2.25 2.25 0 013 18V7.5z" />',
        'shopping-cart' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 2.25h1.386a.75.75 0 01.725.56l.691 2.763m0 0L6.75 14.25a2.25 2.25 0 002.25 1.5h7.5a2.25 2.25 0 002.24-1.97l.75-6a.75.75 0 00-.74-.83H5.052m0 0L4.5 3.75M6.75 18.75a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zm10.5 0a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />',
        'chart-bar' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.75 19.5h16.5M6 15.75v-6a.75.75 0 01.75-.75h1.5a.75.75 0 01.75.75v6A.75.75 0 019 16.5H6.75A.75.75 0 016 15.75zm6 0V7.5a.75.75 0 01.75-.75h1.5a.75.75 0 01.75.75v8.25a.75.75 0 01-.75.75H12.75a.75.75 0 01-.75-.75zm6 0v-3a.75.75 0 01.75-.75h1.5a.75.75 0 01.75.75v3a.75.75 0 01-.75.75H18.75a.75.75 0 01-.75-.75z" />',
        'bell' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.25 18.75a2.25 2.25 0 11-4.5 0m9-6a6.75 6.75 0 10-13.5 0v2.25a1.5 1.5 0 01-1.5 1.5h15a1.5 1.5 0 01-1.5-1.5V12.75z" />',
        'plus' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.5v15m7.5-7.5h-15" />',
    ];
    $svg = $icons[$name] ?? $icons['home'];
@endphp

<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="{{ $class }}">
    {!! $svg !!}
</svg>