@props([
    'placeholder' => 'Search...',
    'value' => null,
    'name' => 'search',
    'filters' => [],
    'advancedSearch' => false
])

<div class="search-wrapper">
    <form method="GET" class="w-100" action="{{ request()->url() }}">
        @foreach(request()->except(['search', 'page']) as $key => $value)
            @if(is_array($value))
                @foreach($value as $arrayValue)
                    <input type="hidden" name="{{ $key }}[]" value="{{ $arrayValue }}">
                @endforeach
            @else
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endif
        @endforeach

        <div class="input-group">
            <span class="input-group-text bg-white border-end-0">
                <i class="fas fa-search text-muted"></i>
            </span>
            <input type="search" 
                   name="{{ $name }}" 
                   value="{{ $value }}" 
                   class="form-control border-start-0 ps-0" 
                   placeholder="{{ $placeholder }}"
                   {{ $attributes }}
            >
            @if($advancedSearch && count($filters) > 0)
                <button class="btn btn-light border" type="button" data-bs-toggle="collapse" data-bs-target="#advancedSearch">
                    <i class="fas fa-sliders-h"></i>
                </button>
            @endif
        </div>

        @if($advancedSearch && count($filters) > 0)
            <div class="collapse mt-3" id="advancedSearch">
                <div class="card card-body">
                    <div class="row g-3">
                        @foreach($filters as $filter)
                            <div class="col-md-{{ $filter['col'] ?? '4' }}">
                                @if($filter['type'] === 'select')
                                    <label class="form-label">{{ $filter['label'] }}</label>
                                    <select name="{{ $filter['name'] }}" class="form-select">
                                        <option value="">{{ $filter['placeholder'] ?? 'Select ' . $filter['label'] }}</option>
                                        @foreach($filter['options'] as $value => $label)
                                            <option value="{{ $value }}" @if(request($filter['name']) == $value) selected @endif>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                @elseif($filter['type'] === 'date')
                                    <label class="form-label">{{ $filter['label'] }}</label>
                                    <input type="date" 
                                           name="{{ $filter['name'] }}" 
                                           class="form-control"
                                           value="{{ request($filter['name']) }}"
                                    >
                                @elseif($filter['type'] === 'daterange')
                                    <label class="form-label">{{ $filter['label'] }}</label>
                                    <div class="input-group">
                                        <input type="date" 
                                               name="{{ $filter['name'] }}_from" 
                                               class="form-control"
                                               value="{{ request($filter['name'] . '_from') }}"
                                               placeholder="From"
                                        >
                                        <span class="input-group-text">to</span>
                                        <input type="date" 
                                               name="{{ $filter['name'] }}_to" 
                                               class="form-control"
                                               value="{{ request($filter['name'] . '_to') }}"
                                               placeholder="To"
                                        >
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-3 text-end">
                        <a href="{{ request()->url() }}" class="btn btn-light">
                            <i class="fas fa-undo me-1"></i>Reset
                        </a>
                        <button type="submit" class="btn btn-primary ms-2">
                            <i class="fas fa-search me-1"></i>Search
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </form>
</div>