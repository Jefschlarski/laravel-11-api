<?php

namespace App\Policies;

use App\Http\Utils\Error;
use App\Models\Permission;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TaskStatusPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if ($user->hasPermission(Permission::VIEW_ANY_TASK_STATUS)) {
            return true;
        }

        abort(Error::makeResponse(__('errors.unauthorized'), Error::UNAUTHORIZED));
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, TaskStatus $taskStatus): bool
    {
        if ($user->hasPermission(Permission::VIEW_TASK_STATUS)) {
            return true;
        }

        abort(Error::makeResponse(__('errors.unauthorized'), Error::UNAUTHORIZED));
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if ($user->hasPermission(Permission::CREATE_TASK_STATUS)) {
            return true;
        }

        abort(Error::makeResponse(__('errors.unauthorized'), Error::UNAUTHORIZED));
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, TaskStatus $taskStatus): bool
    {
        if ($user->hasPermission(Permission::UPDATE_TASK_STATUS)) {
            return true;
        }

        abort(Error::makeResponse(__('errors.unauthorized'), Error::UNAUTHORIZED));
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TaskStatus $taskStatus): bool
    {
        if ($user->hasPermission(Permission::DELETE_TASK_STATUS)) {
            return true;
        }

        abort(Error::makeResponse(__('errors.unauthorized'), Error::UNAUTHORIZED));
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, TaskStatus $taskStatus): bool
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, TaskStatus $taskStatus): bool
    {
        return true;
    }
}
