<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /** @use HasFactory<\Database\Factories\TaskFactory> */
    use HasFactory;

    protected $table = 'task';

    protected $fillable = [
        'title',
        'description',
        'project_id',
        'task_status_id',
        'created_by'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function task_status()
    {
        return $this->belongsTo(TaskStatus::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
