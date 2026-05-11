<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::all();
        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        if (!auth()->user()->isLeader()) {
            abort(403);
        }

        return view('projects.create');
    }

    public function store(Request $request)
    {
        if (!auth()->user()->isLeader()) {
            abort(403);
        }

        Project::create([
            'name' => $request->name,
            'description' => $request->description,
            'start_date' => now(),
            'due_date' => $request->due_date,
            'status' => $request->status,
            'priority' => $request->priority,
            'manager_id' => auth()->id()
        ]);

        return redirect()->route('projects.index');
    }

    public function edit(Project $project)
    {
        if (!auth()->user()->isLeader()) {
            abort(403);
        }

        return view('projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        if (!auth()->user()->isLeader()) {
            abort(403);
        }

        $project->update($request->all());
        return redirect()->route('projects.index');
    }

    public function destroy(Project $project)
    {
        if (!auth()->user()->isLeader()) {
            abort(403);
        }

        $project->delete();
        return redirect()->route('projects.index');
    }
}