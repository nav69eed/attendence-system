@props([
    'type' => 'line',
    'data' => [],
    'options' => [],
    'height' => '300px',
    'width' => '100%'
])

@php
    $chartId = 'chart_' . uniqid();
    
    $defaultOptions = [
        'responsive' => true,
        'maintainAspectRatio' => false,
        'plugins' => [
            'legend' => [
                'position' => 'top',
                'labels' => [
                    'usePointStyle' => true,
                    'padding' => 20
                ]
            ]
        ]
    ];

    $mergedOptions = array_merge_recursive($defaultOptions, $options);
@endphp

<div style="height: {{ $height }}; width: {{ $width }}">
    <canvas id="{{ $chartId }}"></canvas>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('{{ $chartId }}').getContext('2d');
        
        new Chart(ctx, {
            type: '{{ $type }}',
            data: @json($data),
            options: @json($mergedOptions)
        });
    });
</script>
@endpush