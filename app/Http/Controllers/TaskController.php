<?php

namespace App\Http\Controllers;

use App\Models\GradeLevel;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    /**
     * Display student's tasks.
     */
    public function index()
    {
        $tasks = Task::with('submissions')
            ->whereHas('gradeLevel', function ($query) {
                $query->where('id', Auth::user()->grade_level_id);
            })
            ->latest()
            ->paginate(10);

        return view('tasks.index', compact('tasks'));
    }

    /**
     * Display a specific task.
     */
    public function show(Task $task)
    {
        $submission = $task->submissions()
            ->where('user_id', Auth::id())
            ->first();

        return view('tasks.show', compact('task', 'submission'));
    }

    /**
     * Submit task solution.
     */
    public function submit(Request $request, Task $task)
    {
        $request->validate([
            'solution' => ['required_without:attachment', 'nullable', 'string', 'max:1000'],
            'attachment' => ['required_without:solution', 'nullable', 'file', 'max:5120']
        ]);

        // Check if task is still open
        if ($task->due_date && now()->greaterThan($task->due_date)) {
            return back()->with('error', 'This task has expired.');
        }

        // Handle file upload
        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')
                ->store('task-submissions', 'public');
        }

        // Create or update submission
        $task->submissions()->updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'solution' => $request->solution,
                'attachment' => $attachmentPath,
                'submitted_at' => now()
            ]
        );

        return back()->with('success', 'Task submitted successfully.');
    }

    /**
     * Display all tasks for admin.
     */
    public function adminIndex()
    {
        $tasks = Task::with(['gradeLevel', 'submissions'])
            ->latest()
            ->paginate(15);

        $gradeLevels = GradeLevel::all();
        return view('admin.tasks.index', compact('tasks', 'gradeLevels'));
    }

    /**
     * Show task creation form.
     */
    public function create()
    {
        $gradeLevels = GradeLevel::all();
        return view('admin.tasks.create', compact('gradeLevels'));
    }

    /**
     * Store a new task.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'grade_level_id' => ['required', 'exists:grade_levels,id'],
            'due_date' => ['date', 'after:today'],
            'attachments' => ['nullable', 'array'],
            'attachments.*' => ['file', 'max:5120']
        ]);

        $validated['assigned_by'] = Auth::id();
        $validated['assigned_to'] = null; // Set assigned_to to null if not provided
        // If no attachments are uploaded, ensure 'attachments' is an empty array for the JSON column
        if (!$request->hasFile('attachments')) {
            $validated['attachments'] = [];
        }
        // Ensure due_date is null if not provided in the request
        if (!isset($validated['due_date'])) {
            $validated['due_date'] = null;
        }
        $task = new Task($validated);

        if ($request->hasFile('attachments')) {
            $paths = [];
            foreach ($request->file('attachments') as $attachment) {
                $paths[] = $attachment->store('task-attachments', 'public');
            }
            $task->attachments = $paths;
        }

        $task->save();

        return redirect()
            ->route('admin.tasks.index')
            ->with('success', 'Task created successfully.');
    }

    /**
     * View task submissions.
     */
    public function viewSubmissions(Task $task)
    {
        $submissions = $task->submissions()
            ->with('user')
            ->latest('submitted_at')
            ->paginate(15);

        return view('admin.tasks.submissions', compact('task', 'submissions'));
    }
}
