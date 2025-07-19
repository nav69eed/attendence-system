<x-app-layout>
    @php
        $title = 'Create New Task';
    @endphp

    <div class="container mt-4">
        <div class="row mb-4">
            <div class="col-md-12">
                <h2><i class="fas fa-plus-circle"></i> {{ $title }}</h2>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.tasks.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="title" class="form-label">Task Title</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                    id="title" name="title" value="{{ old('title') }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                    rows="5" required>{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="grade_level_id" class="form-label">Grade Level</label>
                                <select class="form-select @error('grade_level_id') is-invalid @enderror"
                                    id="grade_level_id" name="grade_level_id" required>
                                    <option value="">Select Grade Level</option>
                                    @foreach ($gradeLevels as $level)
                                        <option value="{{ $level->id }}"
                                            {{ old('grade_level_id') == $level->id ? 'selected' : '' }}>
                                            {{ $level->grade }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('grade_level_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="due_date" class="form-label">Due Date</label>
                                <input type="date"
                                    class="form-control @error('due_date') is-invalid @enderror" id="due_date"
                                    name="due_date" value="{{ old('due_date') }}" required>
                                @error('due_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="attachment" class="form-label">Attachment (optional)</label>
                                <input type="file" class="form-control @error('attachment') is-invalid @enderror"
                                    id="attachment" name="attachment">
                                @error('attachment')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Accepted formats: PDF, DOC, DOCX, JPG, PNG (max: 5MB)</small>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Create Task
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
</x-app-layout>
