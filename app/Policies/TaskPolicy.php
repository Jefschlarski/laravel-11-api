<?php

namespace App\Policies;

use App\Http\Utils\Error;
use App\Models\Permission;
use App\Models\Task;
use App\Models\User;

class TaskPolicy
{

    /**
     * Determine whether the user can view models they are part of.
     */
    public function viewIfItsAffiliate(User $user) {
        return $user->hasPermission(Permission::VIEW_TASKS_IF_ITS_AFFILIATE);
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission(Permission::VIEW_ANY_TASK);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Task $task): bool
    {
        if ($user->hasPermission(Permission::VIEW_TASK)) {
            return true;
        }

        if ($task->project->employees()->where('user_id', $user->id)->exists()) {
            return true;
        }

        if ($user->hasPermission(Permission::VIEW_YOUR_TASK)) {
            if ($user->id == $task->created_by) {
                return true;
            }
        }

        abort(Error::makeResponse(__('errors.unauthorized'), Error::UNAUTHORIZED));
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if ($user->hasPermission(Permission::CREATE_TASK)) {
            return true;
        }

        abort(Error::makeResponse(__('errors.unauthorized'), Error::UNAUTHORIZED));
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Task $task): bool
    {
        if ($user->hasPermission(Permission::UPDATE_TASK)) {
            return true;
        }

        abort(Error::makeResponse(__('errors.unauthorized'), Error::UNAUTHORIZED));
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Task $task): bool
    {
        if ($user->hasPermission(Permission::DELETE_TASK)) {
            return true;
        }

        abort(Error::makeResponse(__('errors.unauthorized'), Error::UNAUTHORIZED));
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Task $task): bool
    {
        abort(Error::makeResponse(__('errors.unauthorized'), Error::UNAUTHORIZED));
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Task $task): bool
    {
        abort(Error::makeResponse(__('errors.unauthorized'), Error::UNAUTHORIZED));
    }
}
