@props(['size' => 'md', 'color' => 'primary'])

@php
    $sizeClass = match($size) {
        'sm' => 'spinner-border-sm',
        'lg' => 'spinner-border-lg',
        default => ''
    };

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
@endphp

<div {{ $attributes->merge(['class' => 'spinner-border ' . $sizeClass . ' ' . $colorClass]) }} role="status">
    <span class="visually-hidden">Loading...</span>
</div>