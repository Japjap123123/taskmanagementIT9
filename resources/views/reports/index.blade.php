@extends('layouts.app')
@section('page-title', 'Reports')

@section('topbar-actions')
    <div style="display:flex; gap:8px;">
        <a href="{{ route('reports.export', ['type' => 'all']) }}" class="btn-ghost">
            <i class="ti ti-download"></i> Export All
        </a>
        <a href="{{ route('reports.export', ['type' => 'overdue']) }}" class="btn-ghost">
            <i class="ti ti-download"></i> Export Overdue
        </a>
    </div>
@endsection

@section('content')

{{-- Summary Stats --}}
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon" style="background:#0a2212; color:#4ade80;"><i class="ti ti-circle-check"></i></div>
            <div class="stat-label">Completed Tasks</div>
            <div class="stat-value">{{ $completedTasks->count() }}</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon" style="background:#2a2000; color:#f59e0b;"><i class="ti ti-clock"></i></div>
            <div class="stat-label">Pending Tasks</div>
            <div class="stat-value">{{ $pendingTasks->count() }}</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon" style="background:#2a0a0a; color:#f87171;"><i class="ti ti-alert-circle"></i></div>
            <div class="stat-label">Overdue Tasks</div>
            <div class="stat-value">{{ $overdueTasks->count() }}</div>
        </div>
    </div>
</div>

{{-- Project Progress --}}
<div class="card mb-4">
    <div style="font-size:14px; font-weight:600; color:var(--text-primary); margin-bottom:16px; display:flex; align-items:center; gap:8px;">
        <i class="ti ti-chart-bar" style="color:var(--accent);"></i>
        Project Progress
    </div>
    @forelse($projects as $project)
    <div style="margin-bottom:16px;">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:6px;">
            <span style="font-size:13px; font-weight:500; color:var(--text-primary);">{{ $project->name }}</span>
            <span style="font-size:12px; color:var(--text-muted);">{{ $project->completed_tasks }}/{{ $project->total_tasks }} tasks &mdash; {{ $project->progress }}%</span>
        </div>
        <div class="progress-bar-wrap">
            <div class="progress-bar-fill" style="width:{{ $project->progress }}%;"></div>
        </div>
    </div>
    @empty
        <p style="color:var(--text-muted); font-size:13px;">No projects found.</p>
    @endforelse
</div>

{{-- Overdue Tasks --}}
@if($overdueTasks->count() > 0)
<div class="card mb-4">
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:16px;">
        <div style="font-size:14px; font-weight:600; color:#f87171; display:flex; align-items:center; gap:8px;">
            <i class="ti ti-alert-circle"></i> Overdue Tasks
        </div>
        <a href="{{ route('reports.export', ['type' => 'overdue']) }}" class="btn-ghost" style="font-size:12px;">
            <i class="ti ti-download"></i> Export CSV
        </a>
    </div>
    <table class="table table-dark">
        <thead>
            <tr>
                <th>Task</th>
                <th>Project</th>
                <th>Assigned To</th>
                <th>Due Date</th>
                <th>Priority</th>
            </tr>
        </thead>
        <tbody>
            @foreach($overdueTasks as $task)
            <tr>
                <td><a href="{{ route('tasks.show', $task->id) }}" style="color:var(--accent); text-decoration:none; font-weight:500;">{{ $task->title }}</a></td>
                <td style="color:var(--text-secondary);">{{ $task->project->name }}</td>
                <td style="color:var(--text-secondary);">{{ $task->assignedUser?->name ?? 'Unassigned' }}</td>
                <td style="color:#f87171; font-size:13px;">{{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}</td>
                <td>
                    @php $pcls = match(strtolower($task->priority)) { 'high'=>'priority-high','low'=>'priority-low',default=>'priority-medium' }; @endphp
                    <span class="{{ $pcls }}">{{ $task->priority }}</span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

{{-- Pending Tasks --}}
<div class="card mb-4">
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:16px;">
        <div style="font-size:14px; font-weight:600; color:var(--text-primary); display:flex; align-items:center; gap:8px;">
            <i class="ti ti-clock" style="color:#f59e0b;"></i> Pending Tasks
        </div>
        <a href="{{ route('reports.export', ['type' => 'pending']) }}" class="btn-ghost" style="font-size:12px;">
            <i class="ti ti-download"></i> Export CSV
        </a>
    </div>
    @forelse($pendingTasks as $task)
    <div style="display:flex; align-items:center; justify-content:space-between; padding:10px 0; border-bottom:1px solid var(--border-light);">
        <div>
            <a href="{{ route('tasks.show', $task->id) }}" style="color:var(--text-primary); text-decoration:none; font-size:13px; font-weight:500;">{{ $task->title }}</a>
            <div style="font-size:12px; color:var(--text-muted);">{{ $task->project->name }}</div>
        </div>
        <div style="text-align:right;">
            <div style="font-size:12px; color:var(--text-muted);">{{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}</div>
            <div style="font-size:12px; color:var(--text-secondary);">{{ $task->assignedUser?->name ?? 'Unassigned' }}</div>
        </div>
    </div>
    @empty
        <p style="color:var(--text-muted); font-size:13px;">No pending tasks.</p>
    @endforelse
</div>

{{-- Completed Tasks --}}
<div class="card">
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:16px;">
        <div style="font-size:14px; font-weight:600; color:var(--text-primary); display:flex; align-items:center; gap:8px;">
            <i class="ti ti-circle-check" style="color:#4ade80;"></i> Completed Tasks
        </div>
        <a href="{{ route('reports.export', ['type' => 'completed']) }}" class="btn-ghost" style="font-size:12px;">
            <i class="ti ti-download"></i> Export CSV
        </a>
    </div>
    @forelse($completedTasks as $task)
    <div style="display:flex; align-items:center; justify-content:space-between; padding:10px 0; border-bottom:1px solid var(--border-light);">
        <div>
            <a href="{{ route('tasks.show', $task->id) }}" style="color:var(--text-primary); text-decoration:none; font-size:13px; font-weight:500;">{{ $task->title }}</a>
            <div style="font-size:12px; color:var(--text-muted);">{{ $task->project->name }}</div>
        </div>
        <div style="font-size:12px; color:var(--text-secondary);">{{ $task->assignedUser?->name ?? 'Unassigned' }}</div>
    </div>
    @empty
        <p style="color:var(--text-muted); font-size:13px;">No completed tasks yet.</p>
    @endforelse
</div>

@endsection