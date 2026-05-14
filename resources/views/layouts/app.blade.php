<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <style>
        :root {
            --bg-base: #0a0a0a;
            --bg-surface: #111111;
            --bg-card: #161616;
            --bg-hover: #1e1e1e;
            --border: #2a2a2a;
            --border-light: #222222;
            --text-primary: #f0f0f0;
            --text-secondary: #888888;
            --text-muted: #555555;
            --accent: #7c6af7;
            --accent-dim: #2d2650;
            --success: #22c55e;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #3b82f6;
        }

        * { box-sizing: border-box; }

        body {
            background: var(--bg-base);
            color: var(--text-primary);
            font-family: 'Segoe UI', system-ui, sans-serif;
            font-size: 14px;
            margin: 0;
            min-height: 100vh;
        }

        /* SIDEBAR */
        .sidebar {
            position: fixed;
            top: 0; left: 0;
            width: 220px;
            height: 100vh;
            background: var(--bg-surface);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            z-index: 100;
            padding: 0;
        }

        .sidebar-brand {
            padding: 20px 20px 16px;
            border-bottom: 1px solid var(--border);
        }

        .sidebar-brand span {
            font-size: 15px;
            font-weight: 600;
            color: var(--text-primary);
            letter-spacing: -0.3px;
        }

        .sidebar-brand small {
            display: block;
            font-size: 11px;
            color: var(--text-muted);
            margin-top: 2px;
        }

        .sidebar-nav {
            flex: 1;
            padding: 12px 10px;
            overflow-y: auto;
        }

        .nav-label {
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-muted);
            padding: 8px 10px 4px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 10px;
            border-radius: 8px;
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 500;
            transition: all 0.15s;
            margin-bottom: 2px;
        }

        .nav-link i { font-size: 17px; }

        .nav-link:hover {
            background: var(--bg-hover);
            color: var(--text-primary);
        }

        .nav-link.active {
            background: var(--accent-dim);
            color: var(--accent);
        }

        .sidebar-footer {
            padding: 14px;
            border-top: 1px solid var(--border);
        }

        .user-pill {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 10px;
            border-radius: 8px;
            background: var(--bg-card);
            border: 1px solid var(--border);
        }

        .user-avatar {
            width: 30px; height: 30px;
            border-radius: 50%;
            background: var(--accent-dim);
            color: var(--accent);
            display: flex; align-items: center; justify-content: center;
            font-size: 12px; font-weight: 600;
        }

        .user-name { font-size: 13px; font-weight: 500; color: var(--text-primary); }
        .user-role { font-size: 11px; color: var(--text-muted); }

        /* MAIN */
        .main-content {
            margin-left: 220px;
            min-height: 100vh;
            background: var(--bg-base);
        }

        .topbar {
            height: 56px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            padding: 0 28px;
            gap: 12px;
            background: var(--bg-surface);
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .topbar-title {
            font-size: 15px;
            font-weight: 600;
            color: var(--text-primary);
            flex: 1;
        }

        .page-body {
            padding: 28px;
        }

        /* CARDS */
        .card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
        }

        /* STAT CARDS */
        .stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 20px;
        }

        .stat-label {
            font-size: 12px;
            font-weight: 500;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.6px;
            margin-bottom: 10px;
        }

        .stat-value {
            font-size: 28px;
            font-weight: 600;
            color: var(--text-primary);
            line-height: 1;
        }

        .stat-icon {
            width: 36px; height: 36px;
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px;
            margin-bottom: 14px;
        }

        /* TABLES */
        .table {
            color: var(--text-primary);
            font-size: 13.5px;
            border-color: var(--border);
            margin: 0;
        }

        .table thead th {
            background: var(--bg-surface);
            color: var(--text-muted);
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.7px;
            border-bottom: 1px solid var(--border);
            padding: 12px 16px;
        }

        .table tbody td {
            padding: 14px 16px;
            border-color: var(--border-light);
            vertical-align: middle;
        }

        .table tbody tr:hover {
            background: var(--bg-hover);
        }

        /* BADGES */
        .badge-status {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 500;
        }

        .badge-status::before {
            content: '';
            width: 6px; height: 6px;
            border-radius: 50%;
            background: currentColor;
            opacity: 0.8;
        }

        .status-pending    { background: #2a2000; color: #f59e0b; }
        .status-progress   { background: #0c1e3a; color: #60a5fa; }
        .status-completed  { background: #0a2212; color: #4ade80; }
        .status-hold       { background: #2a1500; color: #fb923c; }
        .status-cancelled  { background: #1a0a0a; color: #f87171; }

        .priority-high   { background: #2a0a0a; color: #f87171; padding: 3px 9px; border-radius: 5px; font-size: 12px; font-weight: 500; }
        .priority-medium { background: #1e1800; color: #fbbf24; padding: 3px 9px; border-radius: 5px; font-size: 12px; font-weight: 500; }
        .priority-low    { background: #0a1a0a; color: #4ade80; padding: 3px 9px; border-radius: 5px; font-size: 12px; font-weight: 500; }

        /* BUTTONS */
        .btn-main {
            background: var(--accent);
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            transition: opacity 0.15s;
        }

        .btn-main:hover { opacity: 0.85; color: #fff; }

        .btn-ghost {
            background: transparent;
            color: var(--text-secondary);
            border: 1px solid var(--border);
            padding: 6px 12px;
            border-radius: 7px;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            text-decoration: none;
            transition: all 0.15s;
        }

        .btn-ghost:hover {
            background: var(--bg-hover);
            color: var(--text-primary);
            border-color: #444;
        }

        .btn-danger-ghost {
            background: transparent;
            color: #f87171;
            border: 1px solid #3a1515;
            padding: 6px 12px;
            border-radius: 7px;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: all 0.15s;
        }

        .btn-danger-ghost:hover { background: #2a0a0a; }

        /* FORMS */
        .form-control, .form-select {
            background: var(--bg-surface);
            border: 1px solid var(--border);
            color: var(--text-primary);
            border-radius: 8px;
            font-size: 13.5px;
            padding: 9px 12px;
        }

        .form-control:focus, .form-select:focus {
            background: var(--bg-surface);
            border-color: var(--accent);
            color: var(--text-primary);
            box-shadow: 0 0 0 3px rgba(124,106,247,0.15);
        }

        .form-label {
            font-size: 12.5px;
            font-weight: 500;
            color: var(--text-secondary);
            margin-bottom: 6px;
        }

        .form-select-dark {
            background: var(--bg-surface);
            border: 1px solid var(--border);
            color: var(--text-primary);
            border-radius: 6px;
            font-size: 12px;
            padding: 5px 8px;
            cursor: pointer;
        }

        /* SELECT */
        select option { background: #1a1a1a; color: var(--text-primary); }

        /* PROGRESS BAR */
        .progress-bar-wrap {
            background: var(--bg-surface);
            border-radius: 100px;
            height: 6px;
            overflow: hidden;
        }

        .progress-bar-fill {
            height: 100%;
            background: var(--accent);
            border-radius: 100px;
            transition: width 0.4s ease;
        }

        /* ACTIVITY */
        .activity-item {
            display: flex;
            gap: 12px;
            padding: 12px 0;
            border-bottom: 1px solid var(--border-light);
        }

        .activity-item:last-child { border-bottom: none; }

        .activity-dot {
            width: 28px; height: 28px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 13px;
            flex-shrink: 0;
            margin-top: 2px;
        }

        /* PAGE HEADER */
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .page-header h2 {
            font-size: 20px;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0;
        }

        /* OVERDUE */
        .overdue-tag {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 11px;
            color: #f87171;
            background: #2a0a0a;
            padding: 2px 7px;
            border-radius: 4px;
            margin-left: 6px;
        }

        /* LOGOUT FORM */
        .logout-form { margin: 0; }
        .logout-btn {
            background: none;
            border: none;
            color: var(--text-secondary);
            font-size: 13.5px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 10px;
            border-radius: 8px;
            width: 100%;
            transition: all 0.15s;
            font-weight: 500;
        }
        .logout-btn:hover { background: var(--bg-hover); color: #f87171; }
        .logout-btn i { font-size: 17px; }
    </style>
</head>
<body>

{{-- SIDEBAR --}}
<aside class="sidebar">
    <div class="sidebar-brand">
        <span>TaskManager</span>
        <small>Team workspace</small>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-label">Main</div>
        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="ti ti-layout-dashboard"></i> Dashboard
        </a>
        <a href="{{ route('projects.index') }}" class="nav-link {{ request()->routeIs('projects.*') ? 'active' : '' }}">
            <i class="ti ti-folder"></i> Projects
        </a>
        <a href="{{ route('tasks.index') }}" class="nav-link {{ request()->routeIs('tasks.*') ? 'active' : '' }}">
            <i class="ti ti-checkbox"></i> Tasks
        </a>

        <div class="nav-label" style="margin-top:8px;">Insights</div>
        <a href="{{ route('reports.index') }}" class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
            <i class="ti ti-chart-bar"></i> Reports
        </a>
    </nav>

    <div class="sidebar-footer">
        <div class="user-pill mb-2">
            <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            <div>
                <div class="user-name">{{ auth()->user()->name }}</div>
                <div class="user-role">{{ ucfirst(auth()->user()->role) }}</div>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}" class="logout-form">
            @csrf
            <button class="logout-btn">
                <i class="ti ti-logout"></i> Sign out
            </button>
        </form>
    </div>
</aside>

{{-- MAIN --}}
<div class="main-content">
    <div class="topbar">
        <span class="topbar-title">
            @yield('page-title', 'Dashboard')
        </span>
        @yield('topbar-actions')
    </div>

    <div class="page-body">
        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>