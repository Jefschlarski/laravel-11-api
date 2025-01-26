<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    /** @use HasFactory<\Database\Factories\ProjectFactory> */
    use HasFactory;
    protected $table = 'project';

    protected $fillable = [
        'name',
        'description',
        'is_active',
        'created_by',
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function tasksQuantity(): int
    {
        return $this->tasks()->count();
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
