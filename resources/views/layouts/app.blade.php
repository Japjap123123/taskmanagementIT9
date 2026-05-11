<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Task Manager</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #0b0b0b;
            color: #ffffff;
            font-family: 'Segoe UI', sans-serif;
        }

        /* Sidebar */
        .sidebar {
            width: 220px;
            height: 100vh;
            position: fixed;
            background: #000;
            border-right: 1px solid #222;
            padding: 20px;
        }

        .sidebar a {
            display: block;
            color: #aaa;
            padding: 10px;
            text-decoration: none;
            border-radius: 6px;
            margin-bottom: 5px;
        }

        .sidebar a:hover {
            background: #1a1a1a;
            color: #fff;
        }

        /* Main */
        .main {
            margin-left: 240px;
            padding: 30px;
        }

        /* Top bar */
        .topbar {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #222;
        }

        .nav-user {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-name {
            color: #fff;
            font-weight: 500;
        }

        /* Cards */
        .card {
            background: #121212;
            border: 1px solid #222;
            border-radius: 12px;
            padding: 20px;

            /* ✅ FIX: force readable text */
            color: #ffffff !important;
        }

        .card * {
            color: #ffffff !important;
        }

        /* Allow subtle gray for secondary text */
        .card small,
        .card .text-muted {
            color: #888 !important;
        }

        /* Tables */
        table {
            background: #121212 !important;
            color: #ffffff !important;
        }

        table th {
            background: #111 !important;
            color: #ffffff !important;
            border-color: #222 !important;
        }

        table td {
            background: #121212 !important;
            color: #ffffff !important;
            border-color: #222 !important;
        }

        table tr:hover {
            background: #1a1a1a !important;
        }

        .table,
        .table-bordered,
        .table-striped,
        .table-hover {
            background: #121212 !important;
            color: #ffffff !important;
        }

        /* Forms */
        .form-control, .form-select {
            background: #111 !important;
            border: 1px solid #333;
            color: #fff !important;
        }

        .form-control:focus {
            background: #111 !important;
            color: #fff !important;
            border-color: #666;
            box-shadow: none;
        }

        input, textarea, select {
            background: #111 !important;
            color: #ffffff !important;
            border: 1px solid #333 !important;
        }

        input::placeholder,
        textarea::placeholder {
            color: #888 !important;
        }

        input:focus,
        textarea:focus,
        select:focus {
            border-color: #666 !important;
            box-shadow: none !important;
        }

        /* Buttons */
        .btn-main {
            background: #1f1f1f;
            color: #fff;
            border: 1px solid #333;
            border-radius: 8px;
        }

        .btn-main:hover {
            background: #333;
        }

        .btn-danger {
            background: #2a2a2a;
            border: none;
        }

        /* Links */
        a {
            color: #ddd;
        }

        a:hover {
            color: #fff;
        }

        /* Status badges */
        .badge {
            padding: 6px 10px;
            border-radius: 6px;
        }

        .status-pending { background: #444; }
        .status-progress { background: #555; }
        .status-done { background: #2d6a4f; }

        /* Role badges */
        .role-leader {
            background: #4f46e5;
            color: white;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 12px;
        }

        .role-member {
            background: #444;
            color: #ccc;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 12px;
        }

        /* Dropdown */
        .form-select-dark {
            background: #1a1a1a;
            color: white;
            border: 1px solid #333;
            padding: 5px;
            border-radius: 6px;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <h4 class="text-white mb-4">Task Manager</h4>

        <a href="{{ route('dashboard') }}">Dashboard</a>
        <a href="{{ route('projects.index') }}">Projects</a>
        <a href="{{ route('tasks.index') }}">Tasks</a>

        <hr style="border-color:#222;">

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-main w-100">Logout</button>
        </form>
    </div>

    <div class="main">

        <!-- TOP BAR -->
        <div class="topbar">
            <div class="nav-user">
                <span class="user-name">{{ auth()->user()->name }}</span>

                @if(auth()->user()->isLeader())
                    <span class="badge role-leader">Leader</span>
                @else
                    <span class="badge role-member">Member</span>
                @endif
            </div>
        </div>

        @yield('content')

    </div>

</body>
</html>