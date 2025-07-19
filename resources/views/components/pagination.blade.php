@props([
    'paginator',
    'onEachSide' => 2,
    'size' => null, // sm, lg
    'alignment' => null, // start, center, end
    'simple' => false
])

@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation">
        <ul class="pagination {{ $size ? 'pagination-' . $size : '' }} {{ $alignment ? 'justify-content-' . $alignment : '' }} mb-0">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link">
                        <i class="fas fa-chevron-left"></i>
                    </span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                </li>
            @endif

            @if(!$simple)
                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <li class="page-item disabled" aria-disabled="true">
                            <span class="page-link">{{ $element }}</span>
                        </li>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="page-item active" aria-current="page">
                                    <span class="page-link">{{ $page }}</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link">
                        <i class="fas fa-chevron-right"></i>
                    </span>
                </li>
            @endif
        </ul>

        @if(!$simple)
            <div class="d-none d-sm-block">
                <p class="text-muted small mt-2 mb-0">
                    Showing
                    <span class="fw-semibold">{{ $paginator->firstItem() }}</span>
                    to
                    <span class="fw-semibold">{{ $paginator->lastItem() }}</span>
                    of
                    <span class="fw-semibold">{{ $paginator->total() }}</span>
                    results
                </p>
            </div>
        @endif
    </nav>
@endif

<style>
.pagination {
    --bs-pagination-active-bg: #0d6efd;
    --bs-pagination-active-border-color: #0d6efd;
}

.page-link {
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 36px;
    height: 36px;
    padding: 0 0.5rem;
    font-size: 0.875rem;
    border-radius: 4px;
    margin: 0 2px;
}

.pagination-lg .page-link {
    min-width: 44px;
    height: 44px;
    font-size: 1rem;
}

.pagination-sm .page-link {
    min-width: 30px;
    height: 30px;
    font-size: 0.75rem;
}

.page-item:first-child .page-link,
.page-item:last-child .page-link {
    border-radius: 4px;
}

.page-item.active .page-link {
    font-weight: 600;
}

.page-item.disabled .page-link {
    opacity: 0.5;
}
</style>