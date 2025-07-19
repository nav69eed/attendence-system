@php
    $title = 'Edit Task';
@endphp

<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2><i class="fas fa-edit"></i> {{ $title }}</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.tasks.update', $task->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="title" class="form-label">Task Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                id="title" name="title" value="{{ old('title', $task->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                id="description" name="description" rows="5" required>{{ old('description', $task->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="grade_level_id" class="form-label">Grade Level</label>
                            <select class="form-select @error('grade_level_id') is-invalid @enderror" 
                                id="grade_level_id" name="grade_level_id" required>
                                <option value="">Select Grade Level</option>
                                @foreach($gradeLevels as $level)
                                    <option value="{{ $level->id }}" 
                                        {{ old('grade_level_id', $task->grade_level_id) == $level->id ? 'selected' : '' }}>
                                        {{ $level->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('grade_level_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="due_date" class="form-label">Due Date</label>
                            <input type="datetime-local" class="form-control @error('due_date') is-invalid @enderror" 
                                id="due_date" name="due_date" 
                                value="{{ old('due_date', $task->due_date->format('Y-m-d\TH:i')) }}" required>
                            @error('due_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        @if($task->attachment_path)
                            <div class="mb-3">
                                <label class="form-label">Current Attachment</label>
                                <div class="d-flex align-items-center gap-2">
                                    <a href="{{ Storage::url($task->attachment_path) }}" target="_blank" class="btn btn-sm btn-info">
                                        <i class="fas fa-file-download"></i> View Attachment
                                    </a>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="remove_attachment" name="remove_attachment">
                                        <label class="form-check-label" for="remove_attachment">Remove current attachment</label>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label for="attachment" class="form-label">New Attachment (optional)</label>
                            <input type="file" class="form-control @error('attachment') is-invalid @enderror" 
                                id="attachment" name="attachment">
                            @error('attachment')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Accepted formats: PDF, DOC, DOCX, JPG, PNG (max: 5MB)</small>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Task
                            </button>
                            <a href="{{ route('admin.tasks.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to Tasks
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>