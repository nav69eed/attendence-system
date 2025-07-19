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
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Task Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <h6 class="fw-bold">{{ $task->title }}</h6>
                            <p class="card-text">{{ $task->description }}</p>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted">
                                <i class="fas fa-user"></i> Assigned to: {{ $task->assignedTo->name }}
                                <br>
                                <i class="fas fa-calendar-alt"></i> Due: {{ $task->due_date->format('M d, Y h:i A') }}
                                <br>
                                <i class="fas fa-user"></i> Created by: {{ $task->assignedBy->name }}
                                <br>
                                <i class="fas fa-clock"></i> Created: {{ $task->created_at->format('M d, Y') }}
                            </small>
                        </div>

                        @if ($task->attachments)
                            <div class="mb-3">
                                @foreach($task->attachments as $attachment)
                                    <a href="{{ Storage::url($attachment) }}" target="_blank" class="btn btn-sm btn-info mb-2">
                                        <i class="fas fa-file-download"></i> View Attachment {{ $loop->iteration }}
                                    </a>
                                @endforeach
                            </div>
                        @endif

                        <div class="d-grid gap-2">
                            <a href="{{ route('admin.tasks.edit', $task->id) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Edit Task
                            </a>
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                <i class="fas fa-trash"></i> Delete Task
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="mb-0">Student Submissions</h5>
                    </div>
                    <div class="card-body">
                        @forelse($task->submissions as $submission)
                            <div class="border-bottom pb-3 mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="mb-0">{{ $submission->user->name }}</h6>
                                    <span class="badge bg-{{ $submission->status === 'pending' ? 'warning' : ($submission->status === 'accepted' ? 'success' : 'danger') }}">
                                        {{ ucfirst($submission->status) }}
                                    </span>
                                </div>
                                <p class="mb-2">{{ $submission->response }}</p>
                                @if($submission->file_path)
                                    <a href="{{ Storage::url($submission->file_path) }}" class="btn btn-sm btn-info mb-3" target="_blank">
                                        <i class="fas fa-download"></i> View Attachment
                                    </a>
                                @endif

                                @if ($submission->status =="pending")
                                    <form action="{{ route('admin.tasks.update-status', $submission->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="user_id" value="{{ $submission->user_id }}">

                                    <div class="mb-3">
                                        <label class="form-label">Feedback</label>
                                        <textarea name="feedback" class="form-control" rows="3" required>{{ $submission->feedback }}</textarea>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <button type="submit" name="status" value="accepted" class="btn btn-success">
                                            <i class="fas fa-check"></i> Accept
                                        </button>
                                        <button type="submit" name="status" value="rejected" class="btn btn-danger">
                                            <i class="fas fa-times"></i> Reject
                                        </button>
                                    </div>
                                </form>
                                @endif
                            </div>
                        @empty
                            <p class="text-muted mb-0">No submissions yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Modal -->
        <div class="modal fade" id="deleteModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('admin.tasks.destroy', $task->id) }}" method="POST">
                        @csrf
                        @method('DELETE')

                        <div class="modal-header">
                            <h5 class="modal-title">Delete Task</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to delete this task? This action cannot be undone.</p>
                            <p class="mb-0"><strong>Task:</strong> {{ $task->title }}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.tasks.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Tasks
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
