@extends('layouts.app')

@section('content')

<h1 class="mb-3">Create Task</h1>

<form method="POST" action="{{ route('tasks.store') }}">
    @csrf

    <div class="mb-3">
        <label>Project</label>
        <select name="project_id" class="form-control" required>
            @foreach($projects as $project)
                <option value="{{ $project->id }}">{{ $project->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Assign User</label>
        <select name="assigned_user_id" class="form-control">
            <option value="">None</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <input name="title" class="form-control" placeholder="Task Title" required>
    </div>

    <div class="mb-3">
        <textarea name="description" class="form-control" placeholder="Description"></textarea>
    </div>

    <div class="mb-3">
        <select name="priority" class="form-control">
            <option>Low</option>
            <option>Medium</option>
            <option>High</option>
        </select>
    </div>

    <div class="mb-3">
        <input type="date" name="due_date" class="form-control" required>
    </div>

    <button class="btn btn-success">Create</button>

</form>

@endsection