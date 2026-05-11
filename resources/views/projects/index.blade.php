@extends('layouts.app')

@section('content')

<h2 class="mb-4">Projects</h2>

@if(auth()->user()->isLeader())
    <a href="{{ route('projects.create') }}" class="btn btn-main mb-3">+ New Project</a>
@endif

<div class="card">
<table class="table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Status</th>
            <th>Priority</th>
            <th>Due</th>
        </tr>
    </thead>
    <tbody>
        @foreach($projects as $project)
            <tr>
                <td>
                    {{ $project->name }}

                    @if(auth()->user()->isLeader())
                        <br>

                        <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-sm btn-main mt-1">Edit</a>

                        <form method="POST" action="{{ route('projects.destroy', $project->id) }}" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger mt-1">Delete</button>
                        </form>
                    @endif
                </td>

                <td>{{ $project->status }}</td>
                <td>{{ $project->priority }}</td>
                <td>{{ $project->due_date }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
</div>

@endsection