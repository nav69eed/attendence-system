<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::where('assigned_to', Auth::id())
            ->with(['assignedBy', 'submissions'])
            ->latest()
            ->paginate(10);

        return view('tasks.index', compact('tasks'));
    }

    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    public function submit(Request $request, Task $task)
    {
        $validated = $request->validate([
            'submission_file' => 'file|max:10240'
        ]);

        $submission = new Submission();
        $submission->task_id = $task->id;
        $submission->user_id = Auth::id();
        $submission->submission_date = now();
        $submission->response=$request->response;

        if ($request->hasFile('submission_file')) {
            $path = $request->file('submission_file')
                ->store('task-submissions', 'public');
            $submission->file_path = $path;
        }

        $submission->save();

        return redirect()->route('tasks.show', $task)
            ->with('success', 'Task submitted successfully');
    }
}
