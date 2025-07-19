@props([
    'name',
    'label' => null,
    'accept' => '*/*',
    'multiple' => false,
    'preview' => true,
    'value' => null,
    'help' => null,
    'maxSize' => 5, // in MB
    'maxFiles' => 1
])

<div class="file-upload-wrapper" data-file-upload>
    @if($label)
        <label class="form-label">{{ $label }}</label>
    @endif

    <div class="file-upload @error($name) is-invalid @enderror">
        <div class="file-upload-placeholder @if($value) d-none @endif">
            <input type="file" 
                   name="{{ $name }}@if($multiple)[]@endif" 
                   accept="{{ $accept }}" 
                   class="file-upload-input"
                   @if($multiple) multiple @endif
                   data-max-size="{{ $maxSize * 1024 * 1024 }}"
                   data-max-files="{{ $maxFiles }}"
                   {{ $attributes }}
            >
            <div class="text-center p-4">
                <div class="display-4 text-muted mb-3">
                    <i class="fas fa-cloud-upload-alt"></i>
                </div>
                <h5 class="mb-3">Drag and drop your files here</h5>
                <div class="btn btn-primary">
                    <i class="fas fa-folder-open me-2"></i>Browse Files
                </div>
                @if($help)
                    <div class="text-muted small mt-2">{{ $help }}</div>
                @endif
            </div>
        </div>

        @if($preview)
            <div class="file-preview-wrapper @if(!$value) d-none @endif">
                <div class="file-preview-list row g-3" data-preview-list>
                    @if($value)
                        @if(is_array($value))
                            @foreach($value as $file)
                                <div class="col-auto">
                                    <div class="file-preview-item">
                                        @if(Str::startsWith($file->getMimeType(), 'image/'))
                                            <img src="{{ $file->temporaryUrl() }}" alt="Preview">
                                        @else
                                            <div class="file-icon">
                                                <i class="fas fa-file"></i>
                                            </div>
                                        @endif
                                        <div class="file-info">
                                            <div class="file-name">{{ $file->getClientOriginalName() }}</div>
                                            <div class="file-size">{{ number_format($file->getSize() / 1024, 2) }} KB</div>
                                        </div>
                                        <button type="button" class="btn-remove" data-remove-file>
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="col-auto">
                                <div class="file-preview-item">
                                    @if(Str::startsWith($value->getMimeType(), 'image/'))
                                        <img src="{{ $value->temporaryUrl() }}" alt="Preview">
                                    @else
                                        <div class="file-icon">
                                            <i class="fas fa-file"></i>
                                        </div>
                                    @endif
                                    <div class="file-info">
                                        <div class="file-name">{{ $value->getClientOriginalName() }}</div>
                                        <div class="file-size">{{ number_format($value->getSize() / 1024, 2) }} KB</div>
                                    </div>
                                    <button type="button" class="btn-remove" data-remove-file>
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        @endif
    </div>

    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<style>
.file-upload {
    border: 2px dashed #dee2e6;
    border-radius: 0.5rem;
    position: relative;
    transition: all 0.3s ease;
}

.file-upload.is-invalid {
    border-color: #dc3545;
}

.file-upload.dragover {
    border-color: #0d6efd;
    background-color: rgba(13, 110, 253, 0.05);
}

.file-upload-input {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
    z-index: 2;
}

.file-preview-item {
    position: relative;
    border: 1px solid #dee2e6;
    border-radius: 0.375rem;
    padding: 0.5rem;
    background: #fff;
}

.file-preview-item img {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border-radius: 0.25rem;
}

.file-icon {
    width: 100px;
    height: 100px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8f9fa;
    border-radius: 0.25rem;
    font-size: 2rem;
    color: #6c757d;
}

.file-info {
    margin-top: 0.5rem;
    text-align: center;
}

.file-name {
    font-size: 0.875rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 100px;
}

.file-size {
    font-size: 0.75rem;
    color: #6c757d;
}

.btn-remove {
    position: absolute;
    top: -0.5rem;
    right: -0.5rem;
    width: 1.5rem;
    height: 1.5rem;
    border-radius: 50%;
    background: #dc3545;
    color: #fff;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-remove:hover {
    background: #bb2d3b;
}
</style>

@push('scripts')
<script>
    document.querySelectorAll('[data-file-upload]').forEach(wrapper => {
        const upload = wrapper.querySelector('.file-upload');
        const input = wrapper.querySelector('.file-upload-input');
        const placeholder = wrapper.querySelector('.file-upload-placeholder');
        const previewWrapper = wrapper.querySelector('.file-preview-wrapper');
        const previewList = wrapper.querySelector('[data-preview-list]');
        const maxSize = parseInt(input.dataset.maxSize);
        const maxFiles = parseInt(input.dataset.maxFiles);

        ['dragenter', 'dragover'].forEach(eventName => {
            upload.addEventListener(eventName, e => {
                e.preventDefault();
                upload.classList.add('dragover');
            });
        });

        ['dragleave', 'drop'].forEach(eventName => {
            upload.addEventListener(eventName, e => {
                e.preventDefault();
                upload.classList.remove('dragover');
            });
        });

        input.addEventListener('change', e => {
            const files = Array.from(e.target.files);
            
            if (files.length > maxFiles) {
                alert(`You can only upload a maximum of ${maxFiles} files`);
                return;
            }

            const invalidFiles = files.filter(file => file.size > maxSize);
            if (invalidFiles.length > 0) {
                alert(`Some files exceed the maximum size of ${maxSize / (1024 * 1024)}MB`);
                return;
            }

            placeholder.classList.add('d-none');
            previewWrapper.classList.remove('d-none');
            previewList.innerHTML = '';

            files.forEach(file => {
                const reader = new FileReader();
                reader.onload = e => {
                    const preview = document.createElement('div');
                    preview.className = 'col-auto';
                    preview.innerHTML = `
                        <div class="file-preview-item">
                            ${file.type.startsWith('image/') 
                                ? `<img src="${e.target.result}" alt="Preview">` 
                                : `<div class="file-icon"><i class="fas fa-file"></i></div>`
                            }
                            <div class="file-info">
                                <div class="file-name">${file.name}</div>
                                <div class="file-size">${(file.size / 1024).toFixed(2)} KB</div>
                            </div>
                            <button type="button" class="btn-remove" data-remove-file>
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    `;
                    previewList.appendChild(preview);

                    preview.querySelector('[data-remove-file]').addEventListener('click', () => {
                        preview.remove();
                        if (previewList.children.length === 0) {
                            placeholder.classList.remove('d-none');
                            previewWrapper.classList.add('d-none');
                            input.value = '';
                        }
                    });
                };
                reader.readAsDataURL(file);
            });
        });

        wrapper.querySelectorAll('[data-remove-file]').forEach(btn => {
            btn.addEventListener('click', () => {
                btn.closest('.col-auto').remove();
                if (previewList.children.length === 0) {
                    placeholder.classList.remove('d-none');
                    previewWrapper.classList.add('d-none');
                    input.value = '';
                }
            });
        });
    });
</script>
@endpush