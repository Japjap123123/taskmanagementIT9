@extends('layouts.app')

@section('content')

<h1 class="mb-3">Create Project</h1>

<form method="POST" action="{{ route('projects.store') }}">
    @csrf

    <div class="mb-3">
        <input name="name" class="form-control" placeholder="Project Name" required>
    </div>

    <div class="mb-3">
        <textarea name="description" class="form-control" placeholder="Description"></textarea>
    </div>

    <div class="mb-3">
        <input type="date" name="due_date" class="form-control" required>
    </div>

    <div class="mb-3">
        <input name="status" class="form-control" placeholder="Status" required>
    </div>

    <div class="mb-3">
        <input name="priority" class="form-control" placeholder="Priority" required>
    </div>

    <button class="btn btn-success">Create</button>

</form>

@endsection