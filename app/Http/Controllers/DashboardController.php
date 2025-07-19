<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\LeaveRequest;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the student dashboard.
     */
    public function index()
    {
        // Redirect admin to admin dashboard
        if (Auth::user()->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }

        // Get today's attendance status
        $hasMarkedToday = Attendance::hasMarkedToday(Auth::id());
        $todayAttendance = null;
        if ($hasMarkedToday) {
            $todayAttendance = Attendance::where('user_id', Auth::id())
                ->whereDate('date', today())
                ->first();
        }

        // Get recent leave requests
        $leaveRequests = LeaveRequest::where('user_id', Auth::id())
            ->latest()
            ->take(5)
            ->get();

        // Get upcoming and recent tasks
        $tasks = Task::whereHas('gradeLevel', function ($query) {
                $query->where('id', Auth::user()->grade_level_id);
            })
            ->where(function ($query) {
                $query->whereNull('due_date')
                    ->orWhere('due_date', '>=', now()->subDays(7));
            })
            ->latest()
            ->take(5)
            ->get();

        // Get attendance statistics
        $thisMonth = now()->format('m');
        $attendanceStats = [
            'present' => Attendance::where('user_id', Auth::id())
                ->whereMonth('date', $thisMonth)
                ->where('status', 'present')
                ->count(),
            'late' => Attendance::where('user_id', Auth::id())
                ->whereMonth('date', $thisMonth)
                ->where('is_late', true)
                ->count(),
            'absent' => Attendance::where('user_id', Auth::id())
                ->whereMonth('date', $thisMonth)
                ->where('status', 'absent')
                ->count()
        ];

        return view('dashboard', compact(
            'hasMarkedToday',
            'todayAttendance',
            'leaveRequests',
            'tasks',
            'attendanceStats'
        ));
    }

    /**
     * Show the admin dashboard.
     */
    public function adminDashboard()
    {
        // Today's statistics
        $today = Carbon::today();
        $todayStats = [
            'total' => User::role('student')->count(),
            'present' => Attendance::whereDate('date', $today)
                ->where('status', 'present')
                ->count(),
            'late' => Attendance::whereDate('date', $today)
                ->where('is_late', true)
                ->count(),
            'absent' => Attendance::whereDate('date', $today)
                ->where('status', 'absent')
                ->count()
        ];

        // Pending leave requests
        $pendingLeaves = LeaveRequest::with('user')
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        // Recent task submissions
        $recentSubmissions = Task::whereNotNull('response')
            ->with('assignedTo') // Assuming 'assignedTo' is the user who submitted the task
            ->latest('updated_at')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'todayStats',
            'pendingLeaves',
            'recentSubmissions'
        ));
    }
}