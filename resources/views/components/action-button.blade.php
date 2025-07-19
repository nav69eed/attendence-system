@props([
    'type' => 'button',
    'href' => null,
    'color' => 'primary',
    'size' => null,
    'icon' => null,
    'loading' => false,
    'disabled' => false,
    'confirm' => false,
    'confirmMessage' => 'Are you sure you want to perform this action?'
])

@php
    $tag = $href ? 'a' : 'button';
    $baseClass = 'btn';
    
    $colorClass = match($color) {
        'success' => 'btn-success',
        'danger' => 'btn-danger',
        'warning' => 'btn-warning',
        'info' => 'btn-info',
        'secondary' => 'btn-secondary',
        'light' => 'btn-light',
        'dark' => 'btn-dark',
        'link' => 'btn-link',
        'outline-primary' => 'btn-outline-primary',
        'outline-success' => 'btn-outline-success',
        'outline-danger' => 'btn-outline-danger',
        'outline-warning' => 'btn-outline-warning',
        'outline-info' => 'btn-outline-info',
        'outline-secondary' => 'btn-outline-secondary',
        'outline-light' => 'btn-outline-light',
        'outline-dark' => 'btn-outline-dark',
        default => 'btn-primary'
    };

    $sizeClass = match($size) {
        'sm' => 'btn-sm',
        'lg' => 'btn-lg',
        default => ''
    };

    $classes = [
        $baseClass,
        $colorClass,
        $sizeClass
    ];
@endphp

<{{ $tag }}
    @if($href) href="{{ $href }}" @endif
    @if($type !== 'link') type="{{ $type }}" @endif
    @if($disabled) disabled @endif
    @if($confirm)
        onclick="return confirm('{{ $confirmMessage }}');"
    @endif
    {{ $attributes->merge(['class' => implode(' ', array_filter($classes))]) }}
>
    @if($loading)
        <x-spinner size="sm" class="me-1" />
    @elseif($icon)
        <i class="fas fa-{{ $icon }} me-1"></i>
    @endif
    {{ $slot }}
</{{ $tag }}>