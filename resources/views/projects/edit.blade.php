@extends('layouts.app')

@section('content')

<h1>Edit Project</h1>

<form method="POST" action="{{ route('projects.update', $project->id) }}">
    @csrf
    @method('PATCH')

    <input name="name" class="form-control mb-2" value="{{ $project->name }}">
    <textarea name="description" class="form-control mb-2">{{ $project->description }}</textarea>
    <input type="date" name="due_date" class="form-control mb-2" value="{{ $project->due_date }}">
    <input name="status" class="form-control mb-2" value="{{ $project->status }}">
    <input name="priority" class="form-control mb-2" value="{{ $project->priority }}">

    <button class="btn btn-primary">Update</button>

</form>

@endsection