<x-app-layout>
    @php
        $title = 'Leave Requests';
    @endphp

    <div class="container mt-5">
        <div class="row align-items-center mb-4">
            <div class="col-md-6">
                <h2 class="fw-bold text-primary">
                    <i class="fas fa-calendar-minus me-2"></i>{{ $title }}
                </h2>
            </div>
            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <a href="{{ route('leaves.create') }}" class="btn btn-outline-primary shadow-sm">
                    <i class="fas fa-plus me-1"></i> Request Leave
                </a>
            </div>
        </div>

        @if ($leaveRequests->isEmpty())
            <div class="alert alert-info d-flex align-items-center gap-2">
                <i class="fas fa-info-circle fs-5"></i>
                <div>No leave requests found.</div>
            </div>
        @else
            <div class="table-responsive shadow-sm rounded">
                <table class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">Date Requested</th>
                            <th scope="col">Start Date</th>
                            <th scope="col">End Date</th>
                            <th scope="col">Reason</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($leaveRequests as $leave)
                            <tr>
                                <td>{{ $leave->created_at?->format('M d, Y') }}</td>
                                <td>{{ $leave->from_date?->format('M d, Y') }}</td>
                                <td>{{ $leave->to_date?->format('M d, Y') }}</td>
                                <td>{{ Str::limit($leave->reason, 50) }}</td>
                                <td>
                                    @if ($leave->status === 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @elseif($leave->status === 'approved')
                                        <span class="badge bg-success">Approved</span>
                                    @else
                                        <span class="badge bg-danger">Rejected</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('leaves.show', $leave->id) }}"
                                        class="btn btn-sm btn-outline-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $leaveRequests->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>

</x-app-layout>
