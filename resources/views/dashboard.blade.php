@extends('layouts.app')
@section('page-title', 'Dashboard')

@section('content')

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#1e1a40; color:#7c6af7;">
                <i class="ti ti-folder"></i>
            </div>
            <div class="stat-label">Total Projects</div>
            <div class="stat-value">{{ $totalProjects }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#0c1e3a; color:#60a5fa;">
                <i class="ti ti-checkbox"></i>
            </div>
            <div class="stat-label">Total Tasks</div>
            <div class="stat-value">{{ $totalTasks }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#0a2212; color:#4ade80;">
                <i class="ti ti-circle-check"></i>
            </div>
            <div class="stat-label">Completed</div>
            <div class="stat-value">{{ $completedTasks }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#2a2000; color:#f59e0b;">
                <i class="ti ti-clock"></i>
            </div>
            <div class="stat-label">Pending</div>
            <div class="stat-value">{{ $pendingTasks }}</div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <div class="card">
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:16px;">
                <span style="font-size:14px; font-weight:600; color:var(--text-primary);">Task Breakdown</span>
            </div>
            <div style="display:flex; flex-direction:column; gap:12px;">
                @php
                    $statuses = [
                        ['label'=>'Completed',   'count'=>$completedTasks,  'class'=>'status-completed'],
                        ['label'=>'In Progress', 'count'=>$inProgressTasks, 'class'=>'status-progress'],
                        ['label'=>'Pending',     'count'=>$pendingTasks,    'class'=>'status-pending'],
                    ];
                @endphp
                @foreach($statuses as $s)
                <div style="display:flex; align-items:center; gap:12px;">
                    <span style="width:90px; font-size:12px; color:var(--text-secondary);">{{ $s['label'] }}</span>
                    <div class="progress-bar-wrap" style="flex:1;">
                        <div class="progress-bar-fill" style="width:{{ $totalTasks > 0 ? round(($s['count']/$totalTasks)*100) : 0 }}%;
                            background: {{ $s['class'] === 'status-completed' ? '#4ade80' : ($s['class'] === 'status-progress' ? '#60a5fa' : '#f59e0b') }};"></div>
                    </div>
                    <span style="font-size:13px; font-weight:600; color:var(--text-primary); width:24px; text-align:right;">{{ $s['count'] }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div style="font-size:14px; font-weight:600; color:var(--text-primary); margin-bottom:16px;">Quick Links</div>
            <div style="display:flex; flex-direction:column; gap:8px;">
                <a href="{{ route('tasks.index') }}" style="display:flex; align-items:center; gap:12px; padding:12px; border-radius:8px; border:1px solid var(--border); text-decoration:none; color:var(--text-primary); transition:background 0.15s;" onmouseover="this.style.background='var(--bg-hover)'" onmouseout="this.style.background='transparent'">
                    <i class="ti ti-checkbox" style="font-size:18px; color:#7c6af7;"></i>
                    <span style="font-size:13px; font-weight:500;">View all tasks</span>
                    <i class="ti ti-arrow-right" style="margin-left:auto; color:var(--text-muted);"></i>
                </a>
                <a href="{{ route('projects.index') }}" style="display:flex; align-items:center; gap:12px; padding:12px; border-radius:8px; border:1px solid var(--border); text-decoration:none; color:var(--text-primary); transition:background 0.15s;" onmouseover="this.style.background='var(--bg-hover)'" onmouseout="this.style.background='transparent'">
                    <i class="ti ti-folder" style="font-size:18px; color:#60a5fa;"></i>
                    <span style="font-size:13px; font-weight:500;">View all projects</span>
                    <i class="ti ti-arrow-right" style="margin-left:auto; color:var(--text-muted);"></i>
                </a>
                <a href="{{ route('reports.index') }}" style="display:flex; align-items:center; gap:12px; padding:12px; border-radius:8px; border:1px solid var(--border); text-decoration:none; color:var(--text-primary); transition:background 0.15s;" onmouseover="this.style.background='var(--bg-hover)'" onmouseout="this.style.background='transparent'">
                    <i class="ti ti-chart-bar" style="font-size:18px; color:#4ade80;"></i>
                    <span style="font-size:13px; font-weight:500;">View reports</span>
                    <i class="ti ti-arrow-right" style="margin-left:auto; color:var(--text-muted);"></i>
                </a>
            </div>
        </div>
    </div>
</div>

@endsection