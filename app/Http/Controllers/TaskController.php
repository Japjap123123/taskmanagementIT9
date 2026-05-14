<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use App\Models\TaskActivity;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with(['project', 'assignedUser', 'comments'])->get();
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        if (!auth()->user()->isLeader()) abort(403);
        $projects = Project::all();
        $users = User::all();
        return view('tasks.create', compact('projects', 'users'));
    }

    public function store(Request $request)
    {
        if (!auth()->user()->isLeader()) abort(403);

        $project = Project::findOrFail($request->project_id);

        $request->validate([
            'title'      => 'required|string|max:255',
            'project_id' => 'required|exists:projects,id',
            'due_date'   => [
                'required',
                'date',
                'after_or_equal:today',
                function ($attribute, $value, $fail) use ($project) {
                    if ($value > $project->due_date) {
                        $fail('Task due date cannot be later than the project due date (' . $project->due_date . ').');
                    }
                },
            ],
        ]);

        $task = Task::create([
            'project_id'       => $request->project_id,
            'title'            => $request->title,
            'description'      => $request->description,
            'status'           => 'Pending',
            'priority'         => $request->priority,
            'due_date'         => $request->due_date,
            'assigned_user_id' => $request->assigned_user_id,
            'created_by'       => auth()->id()
        ]);

        TaskActivity::create([
            'task_id'       => $task->id,
            'user_id'       => auth()->id(),
            'activity_type' => 'created',
            'description'   => auth()->user()->name . ' created this task.',
        ]);

        return redirect()->route('tasks.index');
    }

    public function show(Task $task)
    {
        $task = Task::with(['comments.user', 'assignedUser', 'activities.user'])->findOrFail($task->id);
        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        if (!auth()->user()->isLeader()) abort(403);
        $projects = Project::all();
        $users = User::all();
        return view('tasks.edit', compact('task', 'projects', 'users'));
    }

    public function update(Request $request, Task $task)
    {
        if (!auth()->user()->isLeader()) abort(403);

        $project = Project::findOrFail($request->project_id);

        $request->validate([
            'title'      => 'required|string|max:255',
            'project_id' => 'required|exists:projects,id',
            'due_date'   => [
                'required',
                'date',
                function ($attribute, $value, $fail) use ($project) {
                    if ($value > $project->due_date) {
                        $fail('Task due date cannot be later than the project due date (' . $project->due_date . ').');
                    }
                },
            ],
        ]);

        $old = $task->only(['assigned_user_id']);
        $task->update($request->all());

        if ($old['assigned_user_id'] != $request->assigned_user_id) {
            $newUser = User::find($request->assigned_user_id);
            TaskActivity::create([
                'task_id'       => $task->id,
                'user_id'       => auth()->id(),
                'activity_type' => 'reassigned',
                'description'   => auth()->user()->name . ' reassigned this task to ' . ($newUser?->name ?? 'nobody') . '.',
            ]);
        }

        TaskActivity::create([
            'task_id'       => $task->id,
            'user_id'       => auth()->id(),
            'activity_type' => 'updated',
            'description'   => auth()->user()->name . ' updated task details.',
        ]);

        return redirect()->route('tasks.index');
    }

    public function updateStatus(Request $request, Task $task)
    {
        if (auth()->user()->isLeader() || $task->assigned_user_id == auth()->id()) {
            $oldStatus = $task->status;
            $task->update(['status' => $request->status]);

            TaskActivity::create([
                'task_id'       => $task->id,
                'user_id'       => auth()->id(),
                'activity_type' => 'status_changed',
                'description'   => auth()->user()->name . ' changed status from "' . $oldStatus . '" to "' . $request->status . '".',
            ]);

            return back();
        }

        abort(403);
    }

    public function destroy(Task $task)
    {
        if (!auth()->user()->isLeader()) abort(403);
        $task->delete();
        return redirect()->route('tasks.index');
    }
}