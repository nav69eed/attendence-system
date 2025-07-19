<x-app-layout>
    <div class="container py-4">
        <x-success-message />

        <!-- Today's Statistics -->
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h6 class="card-title">Total Students</h6>
                        <h2 class="mb-0">{{ $todayStats['total'] }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h6 class="card-title">Present Today</h6>
                        <h2 class="mb-0">{{ $todayStats['present'] }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <h6 class="card-title">Late Today</h6>
                        <h2 class="mb-0">{{ $todayStats['late'] }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-danger text-white">
                    <div class="card-body">
                        <h6 class="card-title">Absent Today</h6>
                        <h2 class="mb-0">{{ $todayStats['absent'] }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Attendance Management Card -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-calendar-check text-success me-2"></i>Attendance
                        </h5>
                        <p class="card-text">View and manage student attendance records.</p>
                        <a href="{{ route('admin.attendance.index') }}" class="btn btn-success">
                            <i class="fas fa-list me-1"></i>View Records
                        </a>
                    </div>
                </div>
            </div>

            <!-- Leave Requests Card -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-calendar-minus text-warning me-2"></i>Leave Requests
                        </h5>
                        <p class="card-text mb-3">Recent pending requests:</p>
                        @forelse($pendingLeaves as $leave)
                            <div class="d-flex align-items-center mb-2">
                                <small class="text-muted me-2">{{ $leave->user->name }}</small>
                                <small class="ms-auto">{{ $leave->from_date->format('M d') }}</small>
                            </div>
                        @empty
                            <p class="text-muted small mb-3">No pending requests</p>
                        @endforelse
                        <a href="{{ route('admin.leaves.index') }}" class="btn btn-warning text-white">
                            <i class="fas fa-clock me-1"></i>View All
                        </a>
                    </div>
                </div>
            </div>

            <!-- Tasks Card -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-tasks text-primary me-2"></i>Tasks
                        </h5>
                        <p class="card-text mb-3">Recent submissions:</p>
                        @forelse($recentSubmissions as $task)
                            <div class="d-flex align-items-center mb-2">
                                <small class="text-muted me-2">{{ $task->assignedTo->name }}</small>
                                <small class="ms-auto">{{ $task->updated_at->format('M d') }}</small>
                            </div>
                        @empty
                            <p class="text-muted small mb-3">No recent submissions</p>
                        @endforelse
                        <div class="btn-group w-100">
                            <a href="{{ route('admin.tasks.index') }}" class="btn btn-primary">
                                <i class="fas fa-list me-1"></i>View All
                            </a>
                            <a href="{{ route('admin.tasks.create') }}" class="btn btn-success">
                                <i class="fas fa-plus me-1"></i>Create
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
