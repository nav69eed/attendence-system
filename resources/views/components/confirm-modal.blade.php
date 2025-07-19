@props([
    'id',
    'title' => 'Confirm Action',
    'message' => 'Are you sure you want to perform this action?',
    'confirmText' => 'Confirm',
    'cancelText' => 'Cancel',
    'confirmButtonClass' => 'btn-danger',
    'icon' => 'exclamation-triangle',
    'iconClass' => 'text-warning'
])

<div class="modal fade" id="{{ $id }}" tabindex="-1" aria-labelledby="{{ $id }}Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center py-4">
                <div class="display-1 mb-4 {{ $iconClass }}">
                    <i class="fas fa-{{ $icon }}"></i>
                </div>
                <h5 class="modal-title mb-3" id="{{ $id }}Label">{{ $title }}</h5>
                <p class="text-muted mb-0">{{ $message }}</p>
            </div>
            <div class="modal-footer border-0 pt-0 justify-content-center gap-2">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>{{ $cancelText }}
                </button>
                {{ $slot }}
            </div>
        </div>
    </div>
</div>