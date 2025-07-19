@props(['status', 'icon' => null])

@php
    $classes = match(strtolower($status)) {
        'active', 'approved', 'completed', 'present' => 'bg-success',
        'pending', 'in progress', 'waiting' => 'bg-warning text-dark',
        'inactive', 'rejected', 'cancelled', 'absent' => 'bg-danger',
        'late' => 'bg-info',
        default => 'bg-secondary'
    };

    $icons = [
        'active' => 'check-circle',
        'inactive' => 'times-circle',
        'pending' => 'clock',
        'approved' => 'check',
        'rejected' => 'times',
        'completed' => 'check-double',
        'cancelled' => 'ban',
        'in progress' => 'spinner',
        'waiting' => 'hourglass',
        'present' => 'user-check',
        'absent' => 'user-times',
        'late' => 'user-clock'
    ];

    $statusIcon = $icon ?? ($icons[strtolower($status)] ?? null);
@endphp

<span {{ $attributes->merge(['class' => 'badge ' . $classes]) }}>
    @if($statusIcon)
        <i class="fas fa-{{ $statusIcon }} me-1"></i>
    @endif
    {{ ucfirst($status) }}
</span>