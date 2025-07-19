@props([
    'text',
    'position' => 'top', // top, bottom, left, right
    'type' => 'tooltip', // tooltip, popover
    'title' => null,
    'trigger' => 'hover', // hover, click, focus
    'html' => false,
    'animation' => true,
    'delay' => 0
])

@php
    $attributes = $attributes->merge([
        'data-bs-toggle' => $type,
        'data-bs-placement' => $position,
        'data-bs-trigger' => $trigger,
        'data-bs-animation' => $animation ? 'true' : 'false',
        'data-bs-delay' => $delay,
        'data-bs-html' => $html ? 'true' : 'false'
    ]);

    if ($type === 'tooltip') {
        $attributes = $attributes->merge([
            'title' => $text
        ]);
    } else {
        $attributes = $attributes->merge([
            'data-bs-title' => $title ?? $text,
            'data-bs-content' => $text
        ]);
    }
@endphp

<span {{ $attributes }}>
    {{ $slot }}
</span>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

        const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]');
        const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl));

        // Clean up tooltips and popovers when their trigger elements are removed
        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                mutation.removedNodes.forEach((node) => {
                    if (node.nodeType === 1) {
                        const tooltips = node.querySelectorAll('[data-bs-toggle="tooltip"]');
                        tooltips.forEach((element) => {
                            const tooltip = bootstrap.Tooltip.getInstance(element);
                            if (tooltip) {
                                tooltip.dispose();
                            }
                        });

                        const popovers = node.querySelectorAll('[data-bs-toggle="popover"]');
                        popovers.forEach((element) => {
                            const popover = bootstrap.Popover.getInstance(element);
                            if (popover) {
                                popover.dispose();
                            }
                        });
                    }
                });
            });
        });

        observer.observe(document.body, {
            childList: true,
            subtree: true
        });
    });
</script>

<style>
.tooltip {
    --bs-tooltip-max-width: 200px;
    --bs-tooltip-font-size: 0.875rem;
}

.popover {
    --bs-popover-max-width: 276px;
    --bs-popover-font-size: 0.875rem;
    --bs-popover-border-radius: 0.5rem;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.popover-header {
    font-size: 1rem;
    font-weight: 600;
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
    border-top-left-radius: calc(0.5rem - 1px);
    border-top-right-radius: calc(0.5rem - 1px);
}
</style>
@endpush