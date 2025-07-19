<x-app-layout>
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
                            <h5 class="card-title">Request Information</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <th style="width: 30%">Status</th>
                                        <td>
                                            @if ($leave->status === 'pending')
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
                                    @if ($leave->document_path)
                                        <tr>
                                            <th>Supporting Document</th>
                                            <td>
                                                <a href="{{ Storage::url($leave->document_path) }}" target="_blank"
                                                    class="btn btn-sm btn-info">
                                                    <i class="fas fa-file-download"></i> View Document
                                                </a>
                                            </td>
                                        </tr>
                                    @endif
                                    @if ($leave->admin_remarks)
                                        <tr>
                                            <th>Admin Remarks</th>
                                            <td>{{ $leave->admin_remarks }}</td>
                                        </tr>
                                    @endif
                                </table>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <a href="{{ route('leaves.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to Leave Requests
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
