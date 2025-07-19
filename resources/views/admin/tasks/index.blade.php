<x-app-layout>
    @php
        $title = 'Manage Tasks';
    @endphp

    <div class="container mt-4">
        <div class="row mb-4">
            <div class="col-md-6">
                <h2><i class="fas fa-tasks"></i> {{ $title }}</h2>
            </div>
            <div class="col-md-6 text-end">
                <a href="{{ route('admin.tasks.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Create New Task
                </a>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('admin.tasks.index') }}" method="GET" class="row g-3">
                    <div class="col-md-4">
                        <label for="grade_level" class="form-label">Grade Level</label>
                        <select name="grade_level" id="grade_level" class="form-select">
                            <option value="">All Grades</option>
                            @foreach ($gradeLevels as $level)
                                <option value="{{ $level->id }}"
                                    {{ request('grade_level') == $level->id ? 'selected' : '' }}>
                                    {{ $level->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="">All Status</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending
                            </option>
                            <option value="submitted" {{ request('status') === 'submitted' ? 'selected' : '' }}>
                                Submitted</option>
                            <option value="overdue" {{ request('status') === 'overdue' ? 'selected' : '' }}>Overdue
                            </option>
                        </select>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-filter"></i> Apply Filters
                        </button>
                    </div>
                </form>
            </div>
        </div>

        @if ($tasks->isEmpty())
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> No tasks found.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Title</th>
                            <th>Grade Level</th>
                            <th>Due Date</th>
                            <th>Submissions</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tasks as $task)
                            <tr>
                                <td>{{ Str::limit($task->title, 50) }}</td>
                                <td>{{ $task->gradeLevel->name }}</td>
                                <td>
                                    @if ($task->due_date)
                                         {{ $task->due_date->format('M d, Y h:i A') }}
                                         @if ($task->due_date && $task->due_date->isPast())
                                              <br>
                                              <small class="text-danger">Overdue</small>
                                          @elseif ($task->due_date)
                                              <br>
                                              <small class="text-muted">{{ $task->due_date->diffForHumans() }}</small>
                                          @endif
                                     @else
                                         N/A
                                     @endif
                                </td>
                                <td>
                                    {{ $task->submissions_count }} / {{ $task->total_students }}
                                    <div class="progress" style="height: 5px;">
                                         <div class="progress-bar" role="progressbar"
                                             style="width: {{ $task->total_students > 0 ? ($task->submissions_count / $task->total_students) * 100 : 0 }}%">
                                         </div>
                                     </div>
                                </td>
                                <td>
                                    @if ($task->due_date->isPast())
                                        <span class="badge bg-danger">Overdue</span>
                                    @elseif($task->submissions_count == $task->total_students)
                                        <span class="badge bg-success">All Submitted</span>
                                    @elseif($task->submissions_count > 0)
                                        <span class="badge bg-warning">Partial</span>
                                    @else
                                        <span class="badge bg-secondary">No Submissions</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.tasks.show', $task->id) }}"
                                            class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.tasks.edit', $task->id) }}"
                                            class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal{{ $task->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>

                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal{{ $task->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{ route('admin.tasks.destroy', $task->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')

                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Delete Task</h5>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Are you sure you want to delete this task? This action cannot
                                                            be undone.</p>
                                                        <p class="mb-0"><strong>Task:</strong> {{ $task->title }}
                                                        </p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $tasks->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
