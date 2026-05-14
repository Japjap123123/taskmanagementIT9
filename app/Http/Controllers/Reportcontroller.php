<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $completedTasks = Task::with(['project', 'assignedUser'])
            ->where('status', 'Completed')->get();

        $pendingTasks = Task::with(['project', 'assignedUser'])
            ->where('status', 'Pending')->get();

        $overdueTasks = Task::with(['project', 'assignedUser'])
            ->whereDate('due_date', '<', now())
            ->whereNotIn('status', ['Completed', 'Cancelled'])
            ->get();

        $projects = Project::with(['tasks'])->get()->map(function ($project) {
            $total     = $project->tasks->count();
            $completed = $project->tasks->where('status', 'Completed')->count();
            $project->progress        = $total > 0 ? round(($completed / $total) * 100) : 0;
            $project->total_tasks     = $total;
            $project->completed_tasks = $completed;
            return $project;
        });

        return view('reports.index', compact(
            'completedTasks', 'pendingTasks', 'overdueTasks', 'projects'
        ));
    }

    public function export(Request $request)
    {
        $type = $request->query('type', 'all');

        $filename = 'report-' . $type . '-' . now()->format('Y-m-d') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($type) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, ['Task', 'Project', 'Assigned To', 'Status', 'Priority', 'Due Date']);

            $query = Task::with(['project', 'assignedUser']);

            if ($type === 'completed') {
                $query->where('status', 'Completed');
            } elseif ($type === 'pending') {
                $query->where('status', 'Pending');
            } elseif ($type === 'overdue') {
                $query->whereDate('due_date', '<', now())
                      ->whereNotIn('status', ['Completed', 'Cancelled']);
            }

            foreach ($query->get() as $task) {
                fputcsv($handle, [
                    $task->title,
                    $task->project->name ?? '-',
                    $task->assignedUser->name ?? 'Unassigned',
                    $task->status,
                    $task->priority,
                    $task->due_date,
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}