@extends('layouts.app')

@section('content')

<h2 class="mb-4 text-white">Dashboard</h2>

<div class="row g-4">

    <div class="col-md-3">
        <div class="card text-white">
            <h6 class="mb-2" style="color:#aaa;">Total Projects</h6>
            <h2 class="text-white">{{ $totalProjects }}</h2>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-white">
            <h6 class="mb-2" style="color:#aaa;">Total Tasks</h6>
            <h2 class="text-white">{{ $totalTasks }}</h2>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-white">
            <h6 class="mb-2" style="color:#aaa;">Completed</h6>
            <h2 class="text-white">{{ $completedTasks }}</h2>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-white">
            <h6 class="mb-2" style="color:#aaa;">Pending</h6>
            <h2 class="text-white">{{ $pendingTasks }}</h2>
        </div>
    </div>

</div>

@endsection