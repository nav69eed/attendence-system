<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\GradeLevel;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class AdminTaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with(['assignedBy', 'assignedTo', 'submissions'])
            ->latest()
            ->paginate(10);
        return view('admin.tasks.index', compact('tasks'));
    }

    public function create()
    {
        $students = User::role('student')->get();
        return view('admin.tasks.create', compact('students'));
    }

    public function show(Task $task)
    {
        return view('admin.tasks.show', compact('task'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'assigned_to' => 'required|exists:users,id',
            'due_date' => 'required|date|after:today',
            'attachments.*' => 'nullable|file|max:10240'
        ]);

        $task = new Task($validated);
        $task->assigned_by = Auth::id();
        $task->status = "pending";

        if ($request->hasFile('attachments')) {
            $attachments = [];
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('task-attachments', 'public');
                $attachments[] = $path;
            }
            $task->attachments = $attachments;
        }

        $task->save();

        return redirect()->route('admin.tasks.index')
            ->with('success', 'Task created successfully');
    }

    public function edit(Task $task)
    {
        $students = User::role('student')->get();
        return view('admin.tasks.edit', compact('task', 'students'));
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'assigned_to' => 'required|exists:users,id',
            'due_date' => 'required|date',
            'attachments.*' => 'nullable|file|max:10240'
        ]);

        $task->update($validated);

        if ($request->hasFile('attachments')) {
            // Delete old attachments
            foreach ($task->attachments ?? [] as $attachment) {
                Storage::disk('public')->delete($attachment);
            }

            // Store new attachments
            $attachments = [];
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('task-attachments', 'public');
                $attachments[] = $path;
            }
            $task->attachments = $attachments;
            $task->save();
        }

        return redirect()->route('admin.tasks.index')
            ->with('success', 'Task updated successfully');
    }

    public function destroy(Task $task)
    {
        // Delete attachments
        foreach ($task->attachments ?? [] as $attachment) {
            Storage::disk('public')->delete($attachment);
        }

        $task->delete();

        return redirect()->route('admin.tasks.index')
            ->with('success', 'Task deleted successfully');
    }

    public function updateStatus($submission, Request $request)
    {
        $validated = $request->validate([
            'status' => 'required|string',
            'feedback' => 'required|string',
        ]);
        // Find the submission first
        $SS = Submission::findOrFail($submission);

        // Update the submission
        $SS->update([
            'status' => $validated['status'],
            'feedback' => $validated['feedback'],
        ]);

        $task = $SS->task; // 👈 Access as property, not method

        if ($validated['status'] === 'accepted') {
            $task->status = 'approved';
        } else {
            $task->status = 'pending';
        }

        $task->save(); // Now this works as expected

        return redirect()->back()->with('success', 'Submission status updated successfully');
    }
}
