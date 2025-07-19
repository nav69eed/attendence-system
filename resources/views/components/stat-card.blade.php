@props([
    'title',
    'value',
    'icon',
    'color' => 'primary',
    'trend' => null,
    'trendValue' => null,
    'subtitle' => null
])

@php
    $bgClass = match($color) {
        'success' => 'bg-success',
        'danger' => 'bg-danger',
        'warning' => 'bg-warning',
        'info' => 'bg-info',
        'secondary' => 'bg-secondary',
        'light' => 'bg-light text-dark',
        'dark' => 'bg-dark',
        default => 'bg-primary'
    };

    $trendClass = match($trend) {
        'up' => 'text-success',
        'down' => 'text-danger',
        default => 'text-muted'
    };

    $trendIcon = match($trend) {
        'up' => 'arrow-up',
        'down' => 'arrow-down',
        default => null
    };
@endphp

<div class="card">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col">
                <h6 class="card-title text-uppercase text-muted mb-2">{{ $title }}</h6>
                <span class="h2 mb-0">{{ $value }}</span>

                @if($trendValue)
                    <span class="ms-2 {{ $trendClass }}">
                        @if($trendIcon)
                            <i class="fas fa-{{ $trendIcon }} me-1"></i>
                        @endif
                        {{ $trendValue }}
                    </span>
                @endif

                @if($subtitle)
                    <p class="mt-2 mb-0 text-muted">
                        {{ $subtitle }}
                    </p>
                @endif
            </div>

            <div class="col-auto">
                <div class="icon-shape {{ $bgClass }} text-white rounded-3 p-3">
                    <i class="fas fa-{{ $icon }}"></i>
                </div>
            </div>
        </div>
    </div>
</div>