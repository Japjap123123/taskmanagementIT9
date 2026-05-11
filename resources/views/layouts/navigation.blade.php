<nav class="navbar navbar-expand-lg" style="background-color:#000; border-bottom:1px solid #222;">
    <div class="container-fluid">

        <a class="navbar-brand text-white" href="{{ route('dashboard') }}">Task Manager</a>

        <div class="collapse navbar-collapse">

            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link text-light" href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light" href="{{ route('projects.index') }}">Projects</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light" href="{{ route('tasks.index') }}">Tasks</a>
                </li>
            </ul>

            <span class="text-secondary me-3">
                {{ auth()->user()->name }}
            </span>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-dark-custom btn-sm">Logout</button>
            </form>

        </div>
    </div>
</nav>