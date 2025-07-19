@props([
    'title' => 'No Data Available',
    'message' => 'There are no items to display at the moment.',
    'icon' => 'inbox',
    'action' => null
])

<div {{ $attributes->merge(['class' => 'text-center py-5']) }}>
    <div class="display-1 text-muted mb-4">
        <i class="fas fa-{{ $icon }}"></i>
    </div>
    
    <h3 class="h4 text-muted mb-3">{{ $title }}</h3>
    <p class="text-muted mb-4">{{ $message }}</p>

    @if($action)
        <div class="mt-4">
            {{ $action }}
        </div>
    @endif
</div>