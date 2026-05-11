<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProjects = Project::count();
        $totalTasks = Task::count();
        $completedTasks = Task::where('status', 'Completed')->count();
        $pendingTasks = Task::where('status', 'Pending')->count();
        $inProgressTasks = Task::where('status', 'In Progress')->count();

        return view('dashboard', compact(
            'totalProjects',
            'totalTasks',
            'completedTasks',
            'pendingTasks',
            'inProgressTasks'
        ));
    }
}