@props(['class' => ''])

<button
    id="themeToggle"
    type="button"
    aria-pressed="false"
    aria-label="Toggle theme"
    onclick="toggleTheme()"
    {{ $attributes->merge(['class' => 'inline-flex items-center justify-center p-2 rounded-md text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500 ' . $class]) }}
>
    <span class="sr-only">Toggle theme</span>

    <x-icon name="sun" class="h-6 w-6 block dark:hidden" />
    <x-icon name="moon" class="h-6 w-6 hidden dark:block" />

    {{-- Screen-reader-friendly label that is updated by JS --}}
    <span id="themeLabel" class="sr-only">Light Mode</span>
</button>