@extends('layouts.app')
@section('page-title', 'Tasks')

@section('topbar-actions')
    @if(auth()->user()->isLeader())
        <a href="{{ route('tasks.create') }}" class="btn-main">
            <i class="ti ti-plus"></i> New Task
        </a>
    @endif
@endsection

@section('content')

<div class="card" style="padding:0; overflow:hidden;">
    <table class="table table-dark">
        <thead>
            <tr>
                <th>Task</th>
                <th>Project</th>
                <th>Assigned To</th>
                <th>Status</th>
                <th>Priority</th>
                <th>Due Date</th>
                <th>Comments</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($tasks as $task)
            <tr>
                <td>
                    <div style="font-weight:500; color:var(--text-primary);">
                        {{ $task->title }}
                        @if($task->isOverdue())
                            <span class="overdue-tag"><i class="ti ti-alert-circle" style="font-size:11px;"></i> Overdue</span>
                        @endif
                    </div>
                    @if($task->description)
                        <div style="font-size:12px; color:var(--text-muted); margin-top:2px;">{{ Str::limit($task->description, 40) }}</div>
                    @endif
                    @if(auth()->user()->isLeader())
                        <div style="display:flex; gap:6px; margin-top:8px;">
                            <a href="{{ route('tasks.edit', $task->id) }}" class="btn-ghost">
                                <i class="ti ti-edit"></i> Edit
                            </a>
                            <form method="POST" action="{{ route('tasks.destroy', $task->id) }}">
                                @csrf @method('DELETE')
                                <button class="btn-danger-ghost"><i class="ti ti-trash"></i> Delete</button>
                            </form>
                        </div>
                    @endif
                </td>

                <td style="color:var(--text-secondary);">{{ $task->project->name }}</td>

                <td>
                    @if($task->assignedUser)
                        <div style="display:flex; align-items:center; gap:7px;">
                            <div style="width:24px;height:24px;border-radius:50%;background:var(--accent-dim);color:var(--accent);display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:600;">
                                {{ strtoupper(substr($task->assignedUser->name, 0, 1)) }}
                            </div>
                            <span style="color:var(--text-secondary);">{{ $task->assignedUser->name }}</span>
                        </div>
                    @else
                        <span style="color:var(--text-muted);">Unassigned</span>
                    @endif
                </td>

                <td>
                    @if(auth()->user()->isLeader() || $task->assigned_user_id == auth()->id())
                        <form method="POST" action="{{ route('tasks.updateStatus', $task->id) }}">
                            @csrf @method('PATCH')
                            <select name="status" onchange="this.form.submit()" class="form-select-dark">
                                @foreach(\App\Models\Task::$statuses as $status)
                                    <option {{ $task->status == $status ? 'selected' : '' }}>{{ $status }}</option>
                                @endforeach
                            </select>
                        </form>
                    @else
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
                    @endif
                </td>

                <td>
                    @php
                        $pcls = match(strtolower($task->priority)) {
                            'high'   => 'priority-high',
                            'low'    => 'priority-low',
                            default  => 'priority-medium',
                        };
                    @endphp
                    <span class="{{ $pcls }}">{{ $task->priority }}</span>
                </td>

                <td style="color:var(--text-secondary); font-size:13px;">
                    {{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}
                </td>

                <td>
                    <span style="display:inline-flex;align-items:center;gap:5px;font-size:12px;color:var(--text-muted);background:var(--bg-surface);padding:4px 9px;border-radius:6px;border:1px solid var(--border);">
                        <i class="ti ti-message" style="font-size:13px;"></i>
                        {{ $task->comments->count() }}
                    </span>
                </td>

                <td>
                    <a href="{{ route('tasks.show', $task->id) }}" class="btn-ghost">
                        View <i class="ti ti-arrow-right"></i>
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align:center; padding:40px; color:var(--text-muted);">
                    <i class="ti ti-inbox" style="font-size:32px; display:block; margin-bottom:8px;"></i>
                    No tasks yet.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection