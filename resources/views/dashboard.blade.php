<x-app-layout>
    <div class="container py-4">
        <x-success-message />

        <div class="row g-4">
            <!-- Mark Attendance Card -->
            <div class="col-md-6 col-lg-3">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-calendar-check text-success me-2"></i>Mark Attendance
                        </h5>
                        <p class="card-text">Mark your daily attendance record.</p>
                        @if(!$hasMarkedToday)
                            <a href="{{ route('attendance.create') }}" class="btn btn-success">
                                <i class="fas fa-check me-1"></i>Mark Present
                            </a>
                        @else
                            <div class="alert alert-success mb-0">
                                <i class="fas fa-check-circle me-1"></i>
                                Marked at {{ $todayAttendance->check_in_time->format('h:i A') }}
                                @if($todayAttendance->is_late)
                                    <span class="badge bg-warning ms-1">Late</span>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Leave Request Card -->
            <div class="col-md-6 col-lg-3">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-calendar-minus text-warning me-2"></i>Leave Requests
                        </h5>
                        <p class="card-text mb-3">Recent leave requests:</p>
                        @forelse($leaveRequests as $leave)
                            <div class="d-flex align-items-center mb-2">
                                <x-status-badge :status="$leave->status" />
                                <small class="ms-2">{{ $leave->from_date?->format('M d') }}</small>
                            </div>
                        @empty
                            <p class="text-muted small mb-3">No recent leave requests</p>
                        @endforelse
                        <a href="{{ route('leaves.create') }}" class="btn btn-warning text-white">
                            <i class="fas fa-plus me-1"></i>New Request
                        </a>
                    </div>
                </div>
            </div>

            <!-- Tasks Card -->
            <div class="col-md-6 col-lg-3">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-tasks text-primary me-2"></i>Tasks
                        </h5>
                        <p class="card-text mb-3">Recent tasks:</p>
                        @forelse($tasks as $task)
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-circle text-{{ $task->due_date && $task->due_date->isPast() ? 'danger' : 'success' }} small me-2"></i>
                                <small>{{ Str::limit($task->title, 20) }}</small>
                            </div>
                        @empty
                            <p class="text-muted small mb-3">No recent tasks</p>
                        @endforelse
                        <a href="{{ route('tasks.index') }}" class="btn btn-primary">
                            <i class="fas fa-clipboard-list me-1"></i>View All
                        </a>
                    </div>
                </div>
            </div>

            <!-- Attendance Stats Card -->
            <div class="col-md-6 col-lg-3">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-chart-pie text-info me-2"></i>This Month
                        </h5>
                        <div class="mt-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-success">Present</span>
                                <span class="badge bg-success">{{ $attendanceStats['present'] }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-warning">Late</span>
                                <span class="badge bg-warning">{{ $attendanceStats['late'] }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-danger">Absent</span>
                                <span class="badge bg-danger">{{ $attendanceStats['absent'] }}</span>
                            </div>
                        </div>
                        <a href="{{ route('attendance.history') }}" class="btn btn-info text-white mt-3 w-100">
                            <i class="fas fa-history me-1"></i>View History
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
