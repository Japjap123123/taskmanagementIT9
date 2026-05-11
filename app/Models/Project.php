<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Task;

class Project extends Model
{
    protected $fillable = [
        'name',
        'description',
        'start_date',
        'due_date',
        'status',
        'priority',
        'manager_id'
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}