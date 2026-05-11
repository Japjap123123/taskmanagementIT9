<?php

namespace App\Http\Controllers;

use App\Models\TaskComment;
use Illuminate\Http\Request;

class TaskCommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'comment' => 'required|string'
        ]);

        TaskComment::create([
            'task_id' => $request->task_id,
            'user_id' => auth()->id(),
            'comment' => $request->comment
        ]);

        return back();
    }
}