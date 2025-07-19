@props([
    'headers' => [],
    'rows' => collect(),
    'sortColumn' => null,
    'sortDirection' => 'asc',
    'actions' => false,
    'checkboxes' => false,
    'striped' => true,
    'hover' => true,
    'responsive' => true
])

@php
    $tableClasses = [
        'table',
        $striped ? 'table-striped' : '',
        $hover ? 'table-hover' : '',
        $responsive ? 'table-responsive' : ''
    ];
@endphp

<div class="card">
    @if($rows->isEmpty())
        <x-empty-state />
    @else
        <div class="table-responsive">
            <table class="{{ implode(' ', array_filter($tableClasses)) }}">
                <thead>
                    <tr>
                        @if($checkboxes)
                            <th width="40">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="selectAll">
                                </div>
                            </th>
                        @endif

                        @foreach($headers as $key => $header)
                            <th @if($sortColumn === $key) class="sorting_{{ $sortDirection }}" @endif>
                                @if(is_array($header) && isset($header['sortable']) && $header['sortable'])
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => $key, 'direction' => $sortColumn === $key && $sortDirection === 'asc' ? 'desc' : 'asc']) }}" 
                                       class="text-decoration-none text-dark">
                                        {{ is_array($header) ? $header['label'] : $header }}
                                        @if($sortColumn === $key)
                                            <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ms-1"></i>
                                        @else
                                            <i class="fas fa-sort text-muted ms-1"></i>
                                        @endif
                                    </a>
                                @else
                                    {{ is_array($header) ? $header['label'] : $header }}
                                @endif
                            </th>
                        @endforeach

                        @if($actions)
                            <th width="120">Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    {{ $slot }}
                </tbody>
            </table>
        </div>

        @if(method_exists($rows, 'links'))
            <div class="card-footer bg-white">
                {{ $rows->links() }}
            </div>
        @endif
    @endif
</div>

@if($checkboxes)
    @push('scripts')
    <script>
        document.getElementById('selectAll').addEventListener('change', function() {
            document.querySelectorAll('tbody input[type="checkbox"]')
                .forEach(checkbox => checkbox.checked = this.checked);
        });
    </script>
    @endpush
@endif