@extends('layouts.app')

@section('content')

<h2 class="mb-4">Tasks</h2>

@if(auth()->user()->isLeader())
    <a href="{{ route('tasks.create') }}" class="btn btn-main mb-3">+ New Task</a>
@endif

<div class="card">
<table class="table">
    <thead>
        <tr>
            <th>Title</th>
            <th>Project</th>
            <th>Assigned</th>
            <th>Status</th>
            <th>Priority</th>
            <th>Comments</th>
            <th>Action</th> <!-- NEW -->
        </tr>
    </thead>
    <tbody>
        @foreach($tasks as $task)
            <tr>
                <td>
                    {{ $task->title }}

                    @if(auth()->user()->isLeader())
                        <br>

                        <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-sm btn-main mt-1">Edit</a>

                        <form method="POST" action="{{ route('tasks.destroy', $task->id) }}" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger mt-1">Delete</button>
                        </form>
                    @endif
                </td>

                <td>{{ $task->project->name }}</td>

                <td>
                    {{ $task->assignedUser?->name ?? 'Unassigned' }}
                </td>

                <td>
                    @if(auth()->user()->isLeader() || $task->assigned_user_id == auth()->id())
                        <form method="POST" action="{{ route('tasks.updateStatus', $task->id) }}">
                            @csrf
                            @method('PATCH')

                            <select name="status" onchange="this.form.submit()" class="form-select-dark">
                                <option {{ $task->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option {{ $task->status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                <option {{ $task->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                        </form>
                    @else
                        <span class="badge status-pending">{{ $task->status }}</span>
                    @endif
                </td>

                <td>{{ $task->priority }}</td>

                <!-- COMMENTS -->
                <td>
                    <span class="badge bg-secondary">
                        {{ $task->comments->count() }} comments
                    </span>

                    @if($task->comments->last())
                        <div style="font-size: 12px; color: #aaa; margin-top:5px;">
                            "{{ \Illuminate\Support\Str::limit($task->comments->last()->comment, 30) }}"
                        </div>
                    @endif
                </td>

                <!-- ✅ VIEW BUTTON -->
                <td>
                    <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-sm btn-main">
                        View
                    </a>
                </td>

            </tr>
        @endforeach
    </tbody>
</table>
</div>

@endsection