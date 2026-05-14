@extends('layouts.app')
@section('page-title', 'Projects')

@section('topbar-actions')
    @if(auth()->user()->isLeader())
        <a href="{{ route('projects.create') }}" class="btn-main">
            <i class="ti ti-plus"></i> New Project
        </a>
    @endif
@endsection

@section('content')

<div class="card" style="padding:0; overflow:hidden;">
    <table class="table table-dark">
        <thead>
            <tr>
                <th>Project</th>
                <th>Status</th>
                <th>Priority</th>
                <th>Due Date</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($projects as $project)
            <tr>
                <td>
                    <div style="font-weight:500; color:var(--text-primary);">{{ $project->name }}</div>
                    @if($project->description)
                        <div style="font-size:12px; color:var(--text-muted); margin-top:2px;">{{ Str::limit($project->description, 50) }}</div>
                    @endif
                </td>
                <td>
                    <span style="background:var(--bg-surface); border:1px solid var(--border); color:var(--text-secondary); padding:4px 10px; border-radius:6px; font-size:12px;">
                        {{ $project->status }}
                    </span>
                </td>
                <td>
                    @php $pcls = match(strtolower($project->priority)) { 'high'=>'priority-high','low'=>'priority-low',default=>'priority-medium' }; @endphp
                    <span class="{{ $pcls }}">{{ $project->priority }}</span>
                </td>
                <td style="color:var(--text-secondary); font-size:13px;">{{ $project->due_date }}</td>
                <td>
                    @if(auth()->user()->isLeader())
                        <div style="display:flex; gap:6px;">
                            <a href="{{ route('projects.edit', $project->id) }}" class="btn-ghost">
                                <i class="ti ti-edit"></i> Edit
                            </a>
                            <form method="POST" action="{{ route('projects.destroy', $project->id) }}">
                                @csrf @method('DELETE')
                                <button class="btn-danger-ghost"><i class="ti ti-trash"></i></button>
                            </form>
                        </div>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align:center; padding:40px; color:var(--text-muted);">
                    <i class="ti ti-folder-off" style="font-size:32px; display:block; margin-bottom:8px;"></i>
                    No projects yet.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection