<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance History - Attendance System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <x-student-nav />
    
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">
                <i class="fas fa-history text-primary me-2"></i>Attendance History
            </h2>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Date Range</label>
                        <div class="input-group">
                            <input type="date" 
                                   name="from_date" 
                                   class="form-control" 
                                   value="{{ request('from_date') }}">
                            <span class="input-group-text">to</span>
                            <input type="date" 
                                   name="to_date" 
                                   class="form-control" 
                                   value="{{ request('to_date') }}">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="">All Status</option>
                            <option value="present" {{ request('status') === 'present' ? 'selected' : '' }}>Present</option>
                            <option value="absent" {{ request('status') === 'absent' ? 'selected' : '' }}>Absent</option>
                            <option value="late" {{ request('status') === 'late' ? 'selected' : '' }}>Late</option>
                        </select>
                    </div>

                    <div class="col-md-2 d-flex align-items-end">
                        <div class="d-grid w-100">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-filter me-2"></i>Filter
                            </button>
                        </div>
                    </div>

                    @if(request()->hasAny(['from_date', 'to_date', 'status']))
                        <div class="col-md-2 d-flex align-items-end">
                            <div class="d-grid w-100">
                                <a href="{{ route('attendance.history') }}" class="btn btn-light">
                                    <i class="fas fa-times me-2"></i>Clear
                                </a>
                            </div>
                        </div>
                    @endif
                </form>
            </div>
        </div>

        @if($attendanceRecords->isEmpty())
            <x-empty-state 
                title="No Attendance Records" 
                message="There are no attendance records matching your filters." 
                icon="calendar-xmark"
            />
        @else
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Date</th>
                                <th>Check In Time</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($attendanceRecords as $record)
                                <tr>
                                    <td>{{ $record->date->format('M d, Y') }}</td>
                                    <td>{{ $record->check_in_time->format('h:i A') }}</td>
                                    <td>
                                        <x-status-badge :status="$record->is_late ? 'late' : $record->status" />
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($attendanceRecords->hasPages())
                    <div class="card-footer bg-white">
                        <x-pagination :paginator="$attendanceRecords" />
                    </div>
                @endif
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>