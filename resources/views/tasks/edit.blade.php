@extends('layouts.app')

@section('content')

<h1>Edit Task</h1>

<form method="POST" action="{{ route('tasks.update', $task->id) }}">
    @csrf
    @method('PATCH')

    <select name="project_id" class="form-control mb-2">
        @foreach($projects as $project)
            <option value="{{ $project->id }}" {{ $task->project_id == $project->id ? 'selected' : '' }}>
                {{ $project->name }}
            </option>
        @endforeach
    </select>

    <select name="assigned_user_id" class="form-control mb-2">
        <option value="">None</option>
        @foreach($users as $user)
            <option value="{{ $user->id }}" {{ $task->assigned_user_id == $user->id ? 'selected' : '' }}>
                {{ $user->name }}
            </option>
        @endforeach
    </select>

    <input name="title" class="form-control mb-2" value="{{ $task->title }}">
    <textarea name="description" class="form-control mb-2">{{ $task->description }}</textarea>

    <select name="priority" class="form-control mb-2">
        <option {{ $task->priority == 'Low' ? 'selected' : '' }}>Low</option>
        <option {{ $task->priority == 'Medium' ? 'selected' : '' }}>Medium</option>
        <option {{ $task->priority == 'High' ? 'selected' : '' }}>High</option>
    </select>

    <input type="date" name="due_date" class="form-control mb-2" value="{{ $task->due_date }}">

    <button class="btn btn-primary">Update</button>

</form>

@endsection