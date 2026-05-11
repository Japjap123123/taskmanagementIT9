<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Task;

class TaskComment extends Model
{
    protected $fillable = [
        'task_id',
        'user_id',
        'comment'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ✅ ADD THIS (important for relationship integrity)
    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}