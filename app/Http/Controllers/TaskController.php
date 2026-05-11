<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        // ✅ FIX: added 'comments'
        $tasks = Task::with(['project', 'assignedUser', 'comments'])->get();
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        if (!auth()->user()->isLeader()) {
            abort(403);
        }

        $projects = Project::all();
        $users = User::all();
        return view('tasks.create', compact('projects', 'users'));
    }

    public function store(Request $request)
    {
        if (!auth()->user()->isLeader()) {
            abort(403);
        }

        Task::create([
            'project_id' => $request->project_id,
            'title' => $request->title,
            'description' => $request->description,
            'status' => 'Pending',
            'priority' => $request->priority,
            'due_date' => $request->due_date,
            'assigned_user_id' => $request->assigned_user_id,
            'created_by' => auth()->id()
        ]);

        return redirect()->route('tasks.index');
    }

    public function show(Task $task)
    {
        $task = Task::with(['comments.user', 'assignedUser'])->findOrFail($task->id);

        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        if (!auth()->user()->isLeader()) {
            abort(403);
        }

        $projects = Project::all();
        $users = User::all();
        return view('tasks.edit', compact('task', 'projects', 'users'));
    }

    public function update(Request $request, Task $task)
    {
        if (!auth()->user()->isLeader()) {
            abort(403);
        }

        $task->update($request->all());
        return redirect()->route('tasks.index');
    }

    public function updateStatus(Request $request, Task $task)
    {
        if (auth()->user()->isLeader()) {
            $task->update(['status' => $request->status]);
            return back();
        }

        if ($task->assigned_user_id == auth()->id()) {
            $task->update(['status' => $request->status]);
            return back();
        }

        abort(403);
    }

    public function destroy(Task $task)
    {
        if (!auth()->user()->isLeader()) {
            abort(403);
        }

        $task->delete();
        return redirect()->route('tasks.index');
    }

    
}