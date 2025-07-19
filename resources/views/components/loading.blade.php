@props([
    'type' => 'spinner', // spinner, skeleton, placeholder
    'variant' => 'border', // border, grow (for spinner only)
    'size' => null, // sm, lg
    'color' => 'primary',
    'fullscreen' => false,
    'text' => 'Loading...',
    'lines' => 3, // for skeleton/placeholder
    'animate' => true
])

@php
    $colorClass = match($color) {
        'success' => 'text-success',
        'danger' => 'text-danger',
        'warning' => 'text-warning',
        'info' => 'text-info',
        'secondary' => 'text-secondary',
        'light' => 'text-light',
        'dark' => 'text-dark',
        default => 'text-primary'
    };

    $sizeClass = match($size) {
        'sm' => 'spinner-' . $variant . '-sm',
        'lg' => 'spinner-' . $variant . '-lg',
        default => ''
    };
@endphp

@if($fullscreen)
    <div class="position-fixed top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center bg-white bg-opacity-75" style="z-index: 1060;">
@endif

@if($type === 'spinner')
    <div class="d-flex align-items-center gap-2 {{ !$fullscreen ? $attributes->get('class') : '' }}">
        <div class="spinner-{{ $variant }} {{ $colorClass }} {{ $sizeClass }}" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        @if($text)
            <span>{{ $text }}</span>
        @endif
    </div>
@elseif($type === 'skeleton')
    <div class="{{ !$fullscreen ? $attributes->get('class') : '' }}">
        @for($i = 0; $i < $lines; $i++)
            <div class="skeleton-line {{ $animate ? 'animate' : '' }} mb-2"></div>
        @endfor
    </div>
@else
    <div class="{{ !$fullscreen ? $attributes->get('class') : '' }}">
        @for($i = 0; $i < $lines; $i++)
            <p class="placeholder-glow mb-2">
                <span class="placeholder col-{{ rand(4, 12) }}"></span>
            </p>
        @endfor
    </div>
@endif

@if($fullscreen)
    </div>
@endif

<style>
.skeleton-line {
    height: 1rem;
    background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 37%, #f0f0f0 63%);
    background-size: 400% 100%;
    border-radius: 4px;
}

.skeleton-line.animate {
    animation: skeleton-loading 1.4s ease infinite;
}

@keyframes skeleton-loading {
    0% {
        background-position: 100% 50%;
    }
    100% {
        background-position: 0 50%;
    }
}

.placeholder {
    background-color: currentColor;
    opacity: 0.2;
    min-height: 1rem;
    border-radius: 4px;
}

.placeholder-glow .placeholder {
    animation: placeholder-glow 2s ease-in-out infinite;
}

@keyframes placeholder-glow {
    50% {
        opacity: 0.1;
    }
}

.spinner-border-lg {
    width: 3rem;
    height: 3rem;
    border-width: 0.25rem;
}

.spinner-grow-lg {
    width: 3rem;
    height: 3rem;
}
</style>