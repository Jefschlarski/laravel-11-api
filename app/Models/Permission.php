<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    /** @use HasFactory<\Database\Factories\EmployeeFactory> */
    use HasFactory;

    public const VIEW = 'view';
    public const LIST = 'list';
    public const CREATE = 'create';
    public const UPDATE = 'update';
    public const DELETE = 'delete';
    public const ACCESS_PROJECTS = 'access-projects';
    public const ACCESS_TASKS = 'access-tasks';
    public const ACCESS_EMPLOYEE = 'access-employee';
    public const VIEW_ANY_EMPLOYEE = 'view-any-employee';
    public const VIEW_EMPLOYEE = 'view-employee';
    public const CREATE_EMPLOYEE = 'create-employee';
    public const UPDATE_EMPLOYEE = 'update-employee';
    public const DELETE_EMPLOYEE = 'delete-employee';
    public const VIEW_ANY_EMPLOYEE_TYPE = 'view-any-employee-type';
    public const VIEW_YOUR_EMPLOYEE_TYPE = 'view-your-employee-type';
    public const VIEW_EMPLOYEE_TYPE = 'view-employee-type';
    public const CREATE_EMPLOYEE_TYPE = 'create-employee-type';
    public const UPDATE_EMPLOYEE_TYPE = 'update-employee-type';
    public const DELETE_EMPLOYEE_TYPE = 'delete-employee-type';
    public const VIEW_ANY_PROJECT = 'view-any-project';
    public const VIEW_YOUR_PROJECT = 'view-your-project';
    public const VIEW_PROJECT = 'view-project';
    public const CREATE_PROJECT = 'create-project';
    public const UPDATE_PROJECT = 'update-project';
    public const DELETE_PROJECT = 'delete-project';
    public const VIEW_ANY_TASK = 'view-any-task';
    public const VIEW_YOUR_TASK = 'view-your-task';
    public const VIEW_TASKS_IF_ITS_AFFILIATE = 'view-tasks-if-its-affiliate';
    public const VIEW_TASK = 'view-task';
    public const CREATE_TASK = 'create-task';
    public const UPDATE_TASK = 'update-task';
    public const DELETE_TASK = 'delete-task';
    public const VIEW_ANY_TASK_STATUS = 'view-any-task-status';
    public const VIEW_TASK_STATUS = 'view-task-status';
    public const CREATE_TASK_STATUS = 'create-task-status';
    public const UPDATE_TASK_STATUS = 'update-task-status';
    public const DELETE_TASK_STATUS = 'delete-task-status';

    protected $table = 'permission';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'created_by',
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function userTypes()
    {
        return $this->belongsToMany(UserType::class, 'user_type_permission', 'permission_id', 'user_type_id');
    }
}
