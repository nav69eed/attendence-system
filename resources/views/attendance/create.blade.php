<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mark Attendance - Attendance System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <x-student-nav />
    
    <div class="container py-4">
        <x-validation-errors />
        <x-success-message />

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body text-center p-5">
                        <div class="display-1 mb-4 {{ $hasMarkedToday ? 'text-success' : 'text-primary' }}">
                            <i class="fas fa-{{ $hasMarkedToday ? 'check-circle' : 'calendar-check' }}"></i>
                        </div>

                        @if($hasMarkedToday)
                            <h3 class="card-title mb-4">Attendance Already Marked</h3>
                            <p class="text-muted mb-4">You have already marked your attendance for today.</p>
                            <a href="{{ route('dashboard') }}" class="btn btn-primary">
                                <i class="fas fa-home me-2"></i>Back to Dashboard
                            </a>
                        @else
                            <h3 class="card-title mb-4">Mark Your Attendance</h3>
                            <p class="text-muted mb-4">Click the button below to mark your attendance for today.</p>
                            
                            <form action="{{ route('attendance.store') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-check me-2"></i>Mark Present
                                </button>
                            </form>

                            @if(now()->format('H:i') > '09:00')
                                <div class="alert alert-warning mt-4">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    Note: You are marking attendance after 9:00 AM. This will be recorded as a late attendance.
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>