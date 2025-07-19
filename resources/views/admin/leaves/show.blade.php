@php
    $title = 'Leave Request Details';
@endphp

<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2><i class="fas fa-calendar-day"></i> {{ $title }}</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-body">
                    <div class="mb-4">
                        <h5 class="card-title">Student Information</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th style="width: 30%">Name</th>
                                    <td>{{ $leave->user->name }}</td>
                                </tr>
                                <tr>
                                    <th>Grade Level</th>
                                    <td>{{ $leave->user->gradeLevel->name }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $leave->user->email }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h5 class="card-title">Request Information</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th style="width: 30%">Status</th>
                                    <td>
                                        @if($leave->status === 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif($leave->status === 'approved')
                                            <span class="badge bg-success">Approved</span>
                                        @else
                                            <span class="badge bg-danger">Rejected</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Requested On</th>
                                    <td>{{ $leave->created_at->format('M d, Y h:i A') }}</td>
                                </tr>
                                <tr>
                                    <th>Start Date</th>
                                    <td>{{ $leave->from_date->format('M d, Y') }}</td>
                                </tr>
                                <tr>
                                    <th>End Date</th>
                                    <td>{{ $leave->to_date->format('M d, Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Duration</th>
                                    <td>{{ $leave->from_date->diffInDays($leave->to_date) + 1 }} day(s)</td>
                                </tr>
                                <tr>
                                    <th>Reason</th>
                                    <td>{{ $leave->reason }}</td>
                                </tr>
                                @if($leave->document_path)
                                    <tr>
                                        <th>Supporting Document</th>
                                        <td>
                                            <a href="{{ Storage::url($leave->document_path) }}" target="_blank" class="btn btn-sm btn-info">
                                                <i class="fas fa-file-download"></i> View Document
                                            </a>
                                        </td>
                                    </tr>
                                @endif
                                @if($leave->admin_remarks)
                                    <tr>
                                        <th>Admin Remarks</th>
                                        <td>{{ $leave->admin_remarks }}</td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    </div>

                    @if($leave->status === 'pending')
                        <div class="d-grid gap-2">
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#approveModal">
                                <i class="fas fa-check"></i> Approve Request
                            </button>
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                                <i class="fas fa-times"></i> Reject Request
                            </button>
                        </div>

                        <!-- Approve Modal -->
                        <div class="modal fade" id="approveModal" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('admin.leaves.update', $leave->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="approved">

                                        <div class="modal-header">
                                            <h5 class="modal-title">Approve Leave Request</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="remarks" class="form-label">Remarks (optional)</label>
                                                <textarea class="form-control" id="remarks" name="remarks" rows="3"></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-success">Approve</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Reject Modal -->
                        <div class="modal fade" id="rejectModal" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('admin.leaves.update', $leave->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="rejected">

                                        <div class="modal-header">
                                            <h5 class="modal-title">Reject Leave Request</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="remarks" class="form-label">Remarks (required)</label>
                                                <textarea class="form-control" id="remarks" name="remarks" rows="3" required></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-danger">Reject</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="d-grid gap-2 mt-4">
                        <a href="{{ route('admin.leaves.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Leave Requests
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
