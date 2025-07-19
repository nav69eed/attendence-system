@props([
    'items' => [],
    'divider' => 'chevron-right',
    'home' => true,
    'homeIcon' => 'home',
    'homeUrl' => '/'
])

<nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
        @if($home)
            <li class="breadcrumb-item">
                <a href="{{ $homeUrl }}" class="text-decoration-none">
                    <i class="fas fa-{{ $homeIcon }}"></i>
                </a>
            </li>
        @endif

        @foreach($items as $item)
            @if($loop->last)
                <li class="breadcrumb-item active" aria-current="page">
                    @if(isset($item['icon']))
                        <i class="fas fa-{{ $item['icon'] }} me-1"></i>
                    @endif
                    {{ $item['title'] }}
                </li>
            @else
                <li class="breadcrumb-item">
                    <a href="{{ $item['url'] }}" class="text-decoration-none">
                        @if(isset($item['icon']))
                            <i class="fas fa-{{ $item['icon'] }} me-1"></i>
                        @endif
                        {{ $item['title'] }}
                    </a>
                </li>
            @endif
        @endforeach
    </ol>
</nav>

<style>
.breadcrumb {
    padding: 0.5rem 0;
}

.breadcrumb-item + .breadcrumb-item::before {
    font-family: "Font Awesome 5 Free";
    font-weight: 900;
    content: "\f054"; /* chevron-right */
    font-size: 0.75rem;
}

.breadcrumb-item a {
    color: #6c757d;
}

.breadcrumb-item a:hover {
    color: #0d6efd;
}

.breadcrumb-item.active {
    color: #212529;
}
</style>