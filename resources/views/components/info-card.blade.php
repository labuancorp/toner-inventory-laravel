@props([
    'title',        // The main label for the card, e.g., "Total Items"
    'value',        // The primary metric to display, e.g., "1,234"
    'description' => null, // Optional sub-text, e.g., "Across all categories"
    'icon' => null,        // Optional Tabler icon name (e.g., 'box')
    'href' => null,        // Optional URL to make the card a clickable link
])

@php
    // Define the classes for the card wrapper.
    // h-100 ensures cards in a row have the same height.
    // card-link and card-hover-lift add interactivity if a link is provided.
    $wrapperClasses = 'card h-100';
    if ($href) {
        $wrapperClasses .= ' card-link card-hover-lift';
    }
@endphp

{{-- Use an anchor tag if href is provided, otherwise use a div --}}
@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $wrapperClasses]) }}>
@else
    <div {{ $attributes->merge(['class' => $wrapperClasses]) }}>
@endif

    <div class="card-body">
        <div class="d-flex align-items-center">
            {{-- Icon (if provided) --}}
            @if($icon)
            <div class="me-3">
                <span class="avatar bg-primary-lt rounded">
                    <i class="ti ti-{{ $icon }}" aria-hidden="true"></i>
                </span>
            </div>
            @endif

            {{-- Main content (title and value) --}}
            <div>
                <div class="text-muted">{{ $title }}</div>
                <div class="fw-bold fs-3">{{ $value }}</div>
            </div>
        </div>

        {{-- Optional description text --}}
        @if($description)
            <div class="mt-2 text-muted small">
                {{ $description }}
            </div>
        @endif
    </div>

@if($href)
    </a>
@else
    </div>
@endif