<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the attendance marking form.
     */
    public function create()
    {
        // Check if user has already marked attendance for today
        $hasMarkedToday = Attendance::hasMarkedToday(Auth::id());

        return view('attendance.create', compact('hasMarkedToday'));
    }

    /**
     * Store a new attendance record.
     */
    public function store(Request $request)
    {
        // Validate if user hasn't already marked attendance today
        if (Attendance::hasMarkedToday(Auth::id())) {
            return back()->with('error', 'You have already marked your attendance for today.');
        }

        $now = Carbon::now();
        $cutoffTime = Carbon::createFromTimeString('09:00:00'); // 9 AM cutoff time

        // Create attendance record
        $attendance = Attendance::create([
            'user_id' => Auth::id(),
            'date' => $now->toDateString(),
            'check_in_time' => $now->toTimeString(),
            'status' => 'present',
            'is_late' => $now->greaterThan($cutoffTime)
        ]);

        $message = $attendance->is_late
            ? 'Attendance marked successfully. Note: You are marked as late.'
            : 'Attendance marked successfully!';

        return redirect()->route('dashboard')
            ->with('success', $message);
    }

    /**
     * Display user's attendance history.
     */
    public function history(Request $request)
    {
        $query = Attendance::query()
            ->where('user_id', Auth::id())
            ->dateRange($request->from_date, $request->to_date)
            ->status($request->status)
            ->latest('date');

        $attendanceRecords = $query->paginate(10)
            ->withQueryString();

        return view('attendance.history', compact('attendanceRecords'));
    }

    /**
     * Display attendance records for admin.
     */
    public function index(Request $request)
    {
        $this->authorize('view attendance');

        $query = Attendance::query()
            ->with('user')
            ->when($request->user_id, function ($query) use ($request) {
                $query->where('user_id', $request->user_id);
            })
            ->dateRange($request->from_date, $request->to_date)
            ->status($request->status)
            ->latest('date');

        $attendanceRecords = $query->paginate(15)
            ->withQueryString();

        $users = User::role('student');

        return view('admin.attendance.index', compact('attendanceRecords', 'users'));
    }
}