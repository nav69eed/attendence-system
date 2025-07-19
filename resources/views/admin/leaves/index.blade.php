<x-app-layout>
    @php
        $title = 'Manage Leave Requests';
    @endphp

    <div class="container mt-4">
        <div class="row mb-4">
            <div class="col-md-6">
                <h2><i class="fas fa-calendar-check"></i> {{ $title }}</h2>
            </div>
            <div class="col-md-6">
                <form action="{{ route('admin.leaves.index') }}" method="GET" class="d-flex gap-2">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved
                        </option>
                        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected
                        </option>
                    </select>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                </form>
            </div>
        </div>

        @if ($leaveRequests->isEmpty())
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> No leave requests found.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Student</th>
                            <th>Date Requested</th>
                            <th>Duration</th>
                            <th>Reason</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($leaveRequests as $leave)
                            <tr>
                                <td>{{ $leave->user->name }}</td>
                                <td>{{ $leave->created_at->format('M d, Y') }}</td>
                                <td>
                                    {{ $leave->from_date->format('M d') }} - {{ $leave->to_date->format('M d') }}
                                    <br>
                                    <small class="text-muted">{{ $leave->from_date->diffInDays($leave->to_date) + 1 }}
                                        day(s)</small>
                                </td>
                                <td>{{ Str::limit($leave->reason, 50) }}</td>
                                <td>
                                    @if ($leave->status === 'pending')
                                        <span class="badge bg-warning">Pending</span>
                                    @elseif($leave->status === 'approved')
                                        <span class="badge bg-success">Approved</span>
                                    @else
                                        <span class="badge bg-danger">Rejected</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.leaves.show', $leave->id) }}"
                                            class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if ($leave->status === 'pending')
                                            <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal"
                                                data-bs-target="#approveModal{{ $leave->id }}">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#rejectModal{{ $leave->id }}">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        @endif
                                    </div>

                                    <!-- Approve Modal -->
                                    <div class="modal fade" id="approveModal{{ $leave->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{ route('admin.leaves.update', $leave->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="approved">

                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Approve Leave Request</h5>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="remarks" class="form-label">Remarks
                                                                (optional)
                                                            </label>
                                                            <textarea class="form-control" id="remarks" name="remarks" rows="3"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-success">Approve</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Reject Modal -->
                                    <div class="modal fade" id="rejectModal{{ $leave->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{ route('admin.leaves.update', $leave->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="rejected">

                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Reject Leave Request</h5>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="remarks" class="form-label">Remarks
                                                                (required)</label>
                                                            <textarea class="form-control" id="remarks" name="remarks" rows="3" required></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-danger">Reject</button>
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
                {{ $leaveRequests->links() }}
            </div>
        @endif
    </div>

</x-app-layout>
