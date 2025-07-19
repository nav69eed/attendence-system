@props([
    'tabs' => [],
    'activeTab' => null,
    'type' => 'tabs', // tabs, pills, underline
    'vertical' => false,
    'justified' => false,
    'fade' => true
])

@php
    $tabsId = 'tabs_' . uniqid();
    $activeTab = $activeTab ?? array_key_first($tabs);
    
    $navClasses = [
        'nav',
        match($type) {
            'pills' => 'nav-pills',
            'underline' => 'nav-tabs nav-tabs-line',
            default => 'nav-tabs'
        },
        $vertical ? 'flex-column' : '',
        $justified ? 'nav-justified' : '',
        'mb-3'
    ];
@endphp

<div class="{{ $vertical ? 'row' : '' }}">
    <div class="{{ $vertical ? 'col-md-3' : '' }}">
        <nav class="{{ implode(' ', array_filter($navClasses)) }}" role="tablist">
            @foreach($tabs as $id => $tab)
                <button class="nav-link {{ $activeTab === $id ? 'active' : '' }}" 
                        id="{{ $tabsId }}-{{ $id }}-tab" 
                        data-bs-toggle="tab" 
                        data-bs-target="#{{ $tabsId }}-{{ $id }}" 
                        type="button" 
                        role="tab" 
                        aria-controls="{{ $tabsId }}-{{ $id }}" 
                        aria-selected="{{ $activeTab === $id ? 'true' : 'false' }}">
                    @if(isset($tab['icon']))
                        <i class="fas fa-{{ $tab['icon'] }} {{ isset($tab['title']) ? 'me-2' : '' }}"></i>
                    @endif
                    {{ $tab['title'] ?? '' }}
                    @if(isset($tab['badge']))
                        <span class="badge {{ $tab['badge']['class'] ?? 'bg-secondary' }} ms-2">
                            {{ $tab['badge']['text'] }}
                        </span>
                    @endif
                </button>
            @endforeach
        </nav>
    </div>

    <div class="{{ $vertical ? 'col-md-9' : '' }}">
        <div class="tab-content">
            @foreach($tabs as $id => $tab)
                <div class="tab-pane fade {{ $activeTab === $id ? 'show active' : '' }}" 
                     id="{{ $tabsId }}-{{ $id }}" 
                     role="tabpanel" 
                     aria-labelledby="{{ $tabsId }}-{{ $id }}-tab">
                    {{ $tab['content'] }}
                </div>
            @endforeach
        </div>
    </div>
</div>

<style>
.nav-tabs-line {
    border-bottom: 2px solid #dee2e6;
}

.nav-tabs-line .nav-link {
    border: none;
    border-bottom: 2px solid transparent;
    margin-bottom: -2px;
    border-radius: 0;
    padding: 0.75rem 1rem;
}

.nav-tabs-line .nav-link:hover {
    border-color: transparent;
    border-bottom-color: #a8b1b8;
}

.nav-tabs-line .nav-link.active {
    border-color: transparent;
    border-bottom-color: #0d6efd;
    color: #0d6efd;
}

.nav-pills .nav-link.active {
    background-color: #0d6efd;
}

.tab-content {
    padding: 1rem 0;
}

.fade {
    transition: opacity 0.15s linear;
}

@media (prefers-reduced-motion: reduce) {
    .fade {
        transition: none;
    }
}

.tab-pane.fade:not(.show) {
    display: none;
}
</style>