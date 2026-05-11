@extends('layouts.app')

@section('content')

<h2 class="mb-4">{{ $task->title }}</h2>

<div class="card mb-4">
    <p><strong>Status:</strong> {{ $task->status }}</p>
    <p><strong>Priority:</strong> {{ $task->priority }}</p>
    <p><strong>Due:</strong> {{ $task->due_date }}</p>
    <p><strong>Assigned:</strong> {{ $task->assignedUser?->name ?? 'Unassigned' }}</p>
</div>

{{-- STATUS UPDATE --}}
@if(auth()->user()->isLeader() || $task->assigned_user_id == auth()->id())
    <div class="card mb-4">
        <form method="POST" action="{{ route('tasks.update-status', $task->id) }}">
            @csrf
            @method('PATCH')

            <label class="mb-2">Update Status</label>

            <select name="status" class="form-control mb-2">
                <option {{ $task->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                <option {{ $task->status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                <option {{ $task->status == 'Completed' ? 'selected' : '' }}>Completed</option>
            </select>

            <button class="btn btn-main btn-sm">Update</button>
        </form>
    </div>
@endif

{{-- COMMENTS --}}
<div class="card">
    <h4 class="mb-3">Comments</h4>

    @if($task->comments->count() > 0)

        @foreach($task->comments as $comment)
            <div style="border-bottom:1px solid #222; padding:10px 0;">
                
                <div style="display:flex; justify-content:space-between;">
                    <strong>{{ $comment->user->name ?? 'Unknown' }}</strong>
                    <small style="color:#777;">
                        {{ $comment->created_at->diffForHumans() }}
                    </small>
                </div>

                <p style="margin:5px 0;">{{ $comment->comment }}</p>

            </div>
        @endforeach

    @else
        <p style="color:#777;">No comments yet.</p>
    @endif

    <hr>

    {{-- ADD COMMENT --}}
    <form method="POST" action="{{ route('task-comments.store') }}">
        @csrf

        <input type="hidden" name="task_id" value="{{ $task->id }}">

        <textarea 
            name="comment" 
            class="form-control mb-2" 
            placeholder="Write a comment..."
            required
        ></textarea>

        <button class="btn btn-main btn-sm">Add Comment</button>
    </form>
</div>

@endsection