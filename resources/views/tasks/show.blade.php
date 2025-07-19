<x-app-layout>
    @php
        $title = 'Task Details';
    @endphp

    <div class="container mt-4">
        <div class="row mb-4">
            <div class="col-md-12">
                <h2><i class="fas fa-clipboard-list"></i> {{ $title }}</h2>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">{{ $task->title }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <h6 class="fw-bold">Description</h6>
                            <p class="card-text">{{ $task->description }}</p>
                        </div>

                        <div class="mb-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <small class="text-muted">
                                        <i class="fas fa-calendar-alt"></i> Due:
                                        {{ $task->due_date->format('M d, Y h:i A') }}
                                        <br>
                                        <i class="fas fa-user"></i> Assigned by: {{ $task->assignedBy->name }}
                                        <br>
                                        <i class="fas fa-clock"></i> Assigned: {{ $task->created_at->format('M d, Y') }}
                                    </small>
                                </div>
                                <div class="col-md-6 text-md-end">
                                    @if ($task->response)
                                        <span class="badge bg-success">Submitted</span>
                                    @elseif($task->due_date->isPast())
                                        <span class="badge bg-danger">Overdue</span>
                                    @else
                                        <span class="badge bg-warning">Pending</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        @if ($task->response)
                            <div class="mb-4">
                                <h6 class="fw-bold">Your Response</h6>
                                <p>{{ $task->response }}</p>

                                @if ($task->feedback)
                                    <div class="alert alert-info mt-3">
                                        <h6 class="fw-bold">Teacher's Feedback</h6>
                                        <p class="mb-0">{{ $task->feedback }}</p>
                                    </div>
                                @endif
                            </div>
                        @else
                            <form action="{{ route('tasks.submit', $task->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label for="response" class="form-label">Your Response</label>
                                    <textarea class="form-control @error('response') is-invalid @enderror" id="response" name="response" rows="5"
                                        required>{{ old('response') }}</textarea>
                                    @error('response')
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
                                    <small class="text-muted">Accepted formats: PDF, DOC, DOCX, JPG, PNG (max:
                                        5MB)</small>
                                </div>

                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-paper-plane"></i> Submit Response
                                    </button>
                                </div>
                            </form>
                        @endif

                        <div class="d-grid gap-2 mt-4">
                            <a href="{{ route('tasks.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to Tasks
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
