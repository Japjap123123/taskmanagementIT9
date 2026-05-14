@extends('layouts.app')
@section('page-title', $task->title)

@section('topbar-actions')
    <a href="{{ route('tasks.index') }}" class="btn-ghost">
        <i class="ti ti-arrow-left"></i> Back to Tasks
    </a>
@endsection

@section('content')

<div class="row g-3">

    {{-- LEFT COLUMN --}}
    <div class="col-md-8">

        {{-- Task Info --}}
        <div class="card mb-3">
            <div style="display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:16px;">
                <div>
                    <h2 style="font-size:18px; font-weight:600; color:var(--text-primary); margin:0 0 6px;">{{ $task->title }}</h2>
                    @if($task->description)
                        <p style="color:var(--text-secondary); font-size:13.5px; margin:0;">{{ $task->description }}</p>
                    @endif
                </div>
                @php
                    $cls = match($task->status) {
                        'Completed'  => 'status-completed',
                        'In Progress'=> 'status-progress',
                        'On Hold'    => 'status-hold',
                        'Cancelled'  => 'status-cancelled',
                        default      => 'status-pending',
                    };
                @endphp
                <span class="badge-status {{ $cls }}">{{ $task->status }}</span>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:16px; padding-top:16px; border-top:1px solid var(--border);">
                <div>
                    <div style="font-size:11px; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.6px; margin-bottom:5px;">Priority</div>
                    @php $pcls = match(strtolower($task->priority)) { 'high'=>'priority-high','low'=>'priority-low',default=>'priority-medium' }; @endphp
                    <span class="{{ $pcls }}">{{ $task->priority }}</span>
                </div>
                <div>
                    <div style="font-size:11px; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.6px; margin-bottom:5px;">Due Date</div>
                    <div style="font-size:13px; color:var(--text-primary); font-weight:500;">
                        {{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}
                        @if($task->isOverdue())
                            <span class="overdue-tag"><i class="ti ti-alert-circle" style="font-size:11px;"></i> Overdue</span>
                        @endif
                    </div>
                </div>
                <div>
                    <div style="font-size:11px; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.6px; margin-bottom:5px;">Assigned To</div>
                    <div style="font-size:13px; color:var(--text-primary); font-weight:500;">
                        {{ $task->assignedUser?->name ?? 'Unassigned' }}
                    </div>
                </div>
            </div>
        </div>

        {{-- Update Status --}}
        @if(auth()->user()->isLeader() || $task->assigned_user_id == auth()->id())
        <div class="card mb-3">
            <div style="font-size:13px; font-weight:600; color:var(--text-primary); margin-bottom:12px;">Update Status</div>
            <form method="POST" action="{{ route('tasks.updateStatus', $task->id) }}" style="display:flex; gap:10px; align-items:center;">
                @csrf @method('PATCH')
                <select name="status" class="form-select" style="max-width:220px;">
                    @foreach(\App\Models\Task::$statuses as $status)
                        <option {{ $task->status == $status ? 'selected' : '' }}>{{ $status }}</option>
                    @endforeach
                </select>
                <button class="btn-main" type="submit"><i class="ti ti-check"></i> Update</button>
            </form>
        </div>
        @endif

        {{-- Comments --}}
        <div class="card">
            <div style="font-size:14px; font-weight:600; color:var(--text-primary); margin-bottom:16px; display:flex; align-items:center; gap:8px;">
                <i class="ti ti-message" style="color:var(--accent);"></i>
                Comments
                <span style="font-size:12px; color:var(--text-muted); background:var(--bg-surface); padding:2px 8px; border-radius:5px; border:1px solid var(--border);">{{ $task->comments->count() }}</span>
            </div>

            @forelse($task->comments as $comment)
            <div style="padding:14px 0; border-bottom:1px solid var(--border-light);">
                <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:7px;">
                    <div style="display:flex; align-items:center; gap:8px;">
                        <div style="width:28px;height:28px;border-radius:50%;background:var(--accent-dim);color:var(--accent);display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:600;">
                            {{ strtoupper(substr($comment->user->name ?? '?', 0, 1)) }}
                        </div>
                        <span style="font-size:13px; font-weight:500; color:var(--text-primary);">{{ $comment->user->name ?? 'Unknown' }}</span>
                    </div>
                    <span style="font-size:11px; color:var(--text-muted);">{{ $comment->created_at->diffForHumans() }}</span>
                </div>
                <p style="margin:0; font-size:13.5px; color:var(--text-secondary); padding-left:36px;">{{ $comment->comment }}</p>
            </div>
            @empty
            <p style="color:var(--text-muted); font-size:13px; text-align:center; padding:20px 0;">No comments yet. Be the first to add one!</p>
            @endforelse

            <form method="POST" action="{{ route('task-comments.store') }}" style="margin-top:16px;">
                @csrf
                <input type="hidden" name="task_id" value="{{ $task->id }}">
                <textarea name="comment" class="form-control mb-2" rows="3" placeholder="Write a comment..." required style="resize:none;"></textarea>
                <button class="btn-main" type="submit"><i class="ti ti-send"></i> Add Comment</button>
            </form>
        </div>

    </div>

    {{-- RIGHT COLUMN - Activity Log --}}
    <div class="col-md-4">
        <div class="card">
            <div style="font-size:14px; font-weight:600; color:var(--text-primary); margin-bottom:16px; display:flex; align-items:center; gap:8px;">
                <i class="ti ti-history" style="color:var(--accent);"></i>
                Activity Log
            </div>

            @forelse($task->activities as $activity)
            @php
                $icon = match($activity->activity_type) {
                    'created'        => ['ti-plus', '#4ade80', '#0a2212'],
                    'status_changed' => ['ti-refresh', '#60a5fa', '#0c1e3a'],
                    'reassigned'     => ['ti-user', '#f59e0b', '#2a2000'],
                    default          => ['ti-edit', '#a78bfa', '#1e1a40'],
                };
            @endphp
            <div class="activity-item">
                <div class="activity-dot" style="background:{{ $icon[2] }}; color:{{ $icon[1] }};">
                    <i class="ti {{ $icon[0] }}" style="font-size:13px;"></i>
                </div>
                <div style="flex:1;">
                    <p style="margin:0 0 3px; font-size:13px; color:var(--text-secondary);">{{ $activity->description }}</p>
                    <span style="font-size:11px; color:var(--text-muted);">{{ $activity->created_at->diffForHumans() }}</span>
                </div>
            </div>
            @empty
            <p style="color:var(--text-muted); font-size:13px; text-align:center; padding:16px 0;">No activity yet.</p>
            @endforelse
        </div>
    </div>

</div>

@endsection