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
                            <i class="fas fa-graduation-cap"></i> Grade: {{ $task->gradeLevel->name }}
                            <br>
                            <i class="fas fa-calendar-alt"></i> Due: {{ $task->due_date->format('M d, Y h:i A') }}
                            <br>
                            <i class="fas fa-user"></i> Created by: {{ $task->assignedBy->name }}
                            <br>
                            <i class="fas fa-clock"></i> Created: {{ $task->created_at->format('M d, Y') }}
                        </small>
                    </div>

                    @if($task->attachment_path)
                        <div class="mb-3">
                            <a href="{{ Storage::url($task->attachment_path) }}" target="_blank" class="btn btn-sm btn-info">
                                <i class="fas fa-file-download"></i> View Task Attachment
                            </a>
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
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Student Submissions</h5>
                    <span class="badge bg-primary">{{ $task->submissions_count }} / {{ $task->total_students }} Submitted</span>
                </div>
                <div class="card-body">
                    @if($submissions->isEmpty())
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> No submissions yet.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Student</th>
                                        <th>Submitted</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($submissions as $submission)
                                        <tr>
                                            <td>{{ $submission->user->name }}</td>
                                            <td>{{ $submission->updated_at->format('M d, Y h:i A') }}</td>
                                            <td>
                                                @if($submission->feedback)
                                                    <span class="badge bg-success">Reviewed</span>
                                                @else
                                                    <span class="badge bg-warning">Pending Review</span>
                                                @endif
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-info" 
                                                    data-bs-toggle="modal" data-bs-target="#submissionModal{{ $submission->id }}">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </td>
                                        </tr>

                                        <!-- Submission Modal -->
                                        <div class="modal fade" id="submissionModal{{ $submission->id }}" tabindex="-1">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Submission Details</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <h6>Student Response</h6>
                                                            <p>{{ $submission->response }}</p>
                                                        </div>

                                                        @if($submission->attachment_path)
                                                            <div class="mb-3">
                                                                <h6>Attachment</h6>
                                                                <a href="{{ Storage::url($submission->attachment_path) }}" 
                                                                    target="_blank" class="btn btn-sm btn-info">
                                                                    <i class="fas fa-file-download"></i> View Attachment
                                                                </a>
                                                            </div>
                                                        @endif

                                                        <form action="{{ route('admin.tasks.feedback', [$task->id, $submission->user->id]) }}" 
                                                            method="POST" class="mt-4">
                                                            @csrf
                                                            @method('PUT')

                                                            <div class="mb-3">
                                                                <label for="feedback{{ $submission->id }}" class="form-label">Feedback</label>
                                                                <textarea class="form-control" id="feedback{{ $submission->id }}" 
                                                                    name="feedback" rows="3">{{ $submission->feedback }}</textarea>
                                                            </div>

                                                            <div class="text-end">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary">Save Feedback</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center mt-4">
                            {{ $submissions->links() }}
                        </div>
                    @endif
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