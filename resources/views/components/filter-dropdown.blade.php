@props([
    'label',
    'name',
    'options' => [],
    'selected' => null,
    'placeholder' => 'Select an option',
    'multiple' => false,
    'searchable' => false
])

<div class="dropdown" data-filter-dropdown>
    <button class="btn btn-light dropdown-toggle d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fas fa-filter text-muted"></i>
        <span>{{ $label }}: </span>
        <span class="text-primary">
            @if($selected)
                @if(is_array($selected))
                    {{ count($selected) }} selected
                @else
                    {{ $options[$selected] ?? $selected }}
                @endif
            @else
                {{ $placeholder }}
            @endif
        </span>
    </button>

    <div class="dropdown-menu p-3" style="min-width: 250px;">
        @if($searchable)
            <div class="mb-3">
                <input type="text" 
                       class="form-control form-control-sm" 
                       placeholder="Search..." 
                       data-filter-search>
            </div>
        @endif

        @if($multiple)
            <div class="mb-3">
                <div class="btn-group btn-group-sm w-100">
                    <button type="button" class="btn btn-light" data-select-all>
                        Select All
                    </button>
                    <button type="button" class="btn btn-light" data-select-none>
                        Clear
                    </button>
                </div>
            </div>
        @endif

        <div class="overflow-auto" style="max-height: 300px;">
            @if($multiple)
                @foreach($options as $value => $label)
                    <div class="form-check">
                        <input type="checkbox" 
                               class="form-check-input" 
                               name="{{ $name }}[]" 
                               value="{{ $value }}" 
                               id="{{ $name }}_{{ $value }}" 
                               @if(is_array($selected) && in_array($value, $selected)) checked @endif>
                        <label class="form-check-label" for="{{ $name }}_{{ $value }}">
                            {{ $label }}
                        </label>
                    </div>
                @endforeach
            @else
                @foreach($options as $value => $label)
                    <div class="form-check">
                        <input type="radio" 
                               class="form-check-input" 
                               name="{{ $name }}" 
                               value="{{ $value }}" 
                               id="{{ $name }}_{{ $value }}" 
                               @if($selected == $value) checked @endif>
                        <label class="form-check-label" for="{{ $name }}_{{ $value }}">
                            {{ $label }}
                        </label>
                    </div>
                @endforeach
            @endif
        </div>

        <div class="mt-3 d-flex justify-content-end gap-2">
            <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="dropdown">
                Cancel
            </button>
            <button type="submit" class="btn btn-sm btn-primary">
                Apply
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.querySelectorAll('[data-filter-dropdown]').forEach(dropdown => {
        if (dropdown.querySelector('[data-filter-search]')) {
            const searchInput = dropdown.querySelector('[data-filter-search]');
            const options = dropdown.querySelectorAll('.form-check');

            searchInput.addEventListener('input', e => {
                const searchTerm = e.target.value.toLowerCase();
                options.forEach(option => {
                    const label = option.querySelector('label').textContent.toLowerCase();
                    option.style.display = label.includes(searchTerm) ? '' : 'none';
                });
            });
        }

        if (dropdown.querySelector('[data-select-all]')) {
            const selectAllBtn = dropdown.querySelector('[data-select-all]');
            const selectNoneBtn = dropdown.querySelector('[data-select-none]');
            const checkboxes = dropdown.querySelectorAll('input[type="checkbox"]');

            selectAllBtn.addEventListener('click', () => {
                checkboxes.forEach(checkbox => checkbox.checked = true);
            });

            selectNoneBtn.addEventListener('click', () => {
                checkboxes.forEach(checkbox => checkbox.checked = false);
            });
        }
    });
</script>
@endpush