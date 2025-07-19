<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{
    /**
     * Display student's leave requests.
     */
    public function index()
    {
        $leaveRequests = LeaveRequest::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        // return $leaveRequests;
        return view('leaves.index', compact('leaveRequests'));
    }

    /**
     * Show leave request creation form.
     */
    public function create()
    {
        return view('leaves.create');
    }

    /**
     * Store a new leave request.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'from_date' => ['required', 'date', 'after_or_equal:today'],
            'to_date' => ['required', 'date', 'after_or_equal:from_date'],
            'reason' => ['required', 'string', 'max:500'],
            'documents' => ['nullable', 'array'],
            'documents.*' => ['file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:2048']
        ]);

        $leaveRequest = new LeaveRequest([
            'user_id' => Auth::id(),
            'from_date' => $validated['from_date'],
            'to_date' => $validated['to_date'],
            'reason' => $validated['reason'],
            'status' => 'pending'
        ]);

        if ($request->hasFile('documents')) {
            $paths = [];
            foreach ($request->file('documents') as $document) {
                $paths[] = $document->store('leave-documents', 'public');
            }
            $leaveRequest->documents = $paths;
        }

        $leaveRequest->save();

        return redirect()
            ->route('leaves.show', $leaveRequest)
            ->with('success', 'Leave request submitted successfully.');
    }

    /**
     * Display a specific leave request.
     */
    public function show(LeaveRequest $leave)
    {
        // $this->authorize('view', $leave);
        return view('leaves.show', compact('leave'));
    }

    /**
     * Display all leave requests for admin.
     */
    public function adminIndex(Request $request)
    {




        $query = LeaveRequest::with('user')
            ->when($request->status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->when($request->from_date, function ($query, $date) {
                $query->where('start_date', '>=', $date);
            })
            ->when($request->to_date, function ($query, $date) {
                $query->where('end_date', '<=', $date);
            })
            ->latest();

        $leaveRequests = $query->paginate(15)->withQueryString();

        return view('admin.leaves.index', compact('leaveRequests'));
    }

    /**
     * Update leave request status.
     */
    public function updateStatus(Request $request, LeaveRequest $leave)
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'status' => ['required', 'in:approved,rejected'],
            'comment' => ['nullable', 'string', 'max:500']
        ]);

        $leave->update([
            'status' => $validated['status'],
            'admin_comment' => $validated['comment'] ?? null
        ]);

        return back()->with('success', 'Leave request status updated successfully.');
    }

    /**
     * Show the form for editing the specified leave request.
     */
    public function edit(LeaveRequest $leave)
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }
        return view('admin.leaves.edit', compact('leave'));
    }
}
