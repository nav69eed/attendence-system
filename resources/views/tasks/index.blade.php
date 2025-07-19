<x-app-layout>
    @php
        $title = 'My Tasks';
    @endphp

    <div class="container mt-4">
        <div class="row mb-4">
            <div class="col-md-6">
                <h2><i class="fas fa-tasks"></i> {{ $title }}</h2>
            </div>
        </div>

        @if ($tasks->isEmpty())
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> No tasks assigned yet.
            </div>
        @else
            <div class="row">
                @foreach ($tasks as $task)
                    <div class="col-md-6 mb-4">
                        <div
                            class="card h-100 {{ $task->due_date->isPast() && !$task->response ? 'border-danger' : '' }}">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">{{ $task->title }}</h5>
                                @if ($task->response)
                                    <span class="badge bg-success">Submitted</span>
                                @elseif($task->due_date->isPast())
                                    <span class="badge bg-danger">Overdue</span>
                                @else
                                    <span class="badge bg-warning">Pending</span>
                                @endif
                            </div>
                            <div class="card-body">
                                <p class="card-text">{{ Str::limit($task->description, 150) }}</p>

                                <div class="mb-3">
                                    <small class="text-muted">
                                        <i class="fas fa-calendar-alt"></i> Due:
                                        {{ $task->due_date->format('M d, Y h:i A') }}
                                        <br>
                                        <i class="fas fa-user"></i> Assigned by: {{ $task->assignedBy->name }}
                                    </small>
                                </div>

                                @if ($task->response)
                                    <div class="alert alert-success mb-3">
                                        <strong>Your Response:</strong><br>
                                        {{ Str::limit($task->response, 100) }}
                                        @if ($task->feedback)
                                            <hr>
                                            <strong>Feedback:</strong><br>
                                            {{ $task->feedback }}
                                        @endif
                                    </div>
                                @endif

                                <div class="d-grid gap-2">
                                    <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-primary">
                                        @if ($task->response)
                                            <i class="fas fa-eye"></i> View Details
                                        @else
                                            <i class="fas fa-paper-plane"></i> Submit Response
                                        @endif
                                    </a>
                                </div>
                            </div>
                            <div class="card-footer text-muted">
                                <small>Assigned: {{ $task->created_at->format('M d, Y') }}</small>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $tasks->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
