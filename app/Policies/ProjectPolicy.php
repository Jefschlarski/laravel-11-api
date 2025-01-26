<?php

namespace App\Policies;

use App\Http\Utils\Error;
use App\Models\Permission;
use App\Models\Project;
use App\Models\User;

class ProjectPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if ($user->hasPermission(Permission::VIEW_ANY_PROJECT)) {
            return true;
        }

        abort(Error::makeResponse(__('errors.unauthorized'), Error::UNAUTHORIZED));
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, $project): bool
    {
        if ($user->hasPermission(Permission::VIEW_PROJECT)) {
            return true;
        }

        if ($user->hasPermission(Permission::VIEW_YOUR_PROJECT)) {
            if ($user->id == $project->created_by || $project->employees()->where('user_id', $user->id)->exists()) {
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
        if ($user->hasPermission(Permission::CREATE_PROJECT)) {
            return true;
        }

        abort(Error::makeResponse(__('errors.unauthorized'), Error::UNAUTHORIZED));
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Project $project): bool
    {
        if ($user->hasPermission(Permission::UPDATE_PROJECT) || $user->id == $project->created_by) {
            return true;
        }

        abort(Error::makeResponse(__('errors.unauthorized'), Error::UNAUTHORIZED));
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Project $project): bool
    {
        if ($user->hasPermission(Permission::DELETE_PROJECT) || $user->id == $project->created_by) {
            return true;
        }

        abort(Error::makeResponse(__('errors.unauthorized'), Error::UNAUTHORIZED));
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Project $project): bool
    {
        abort(Error::makeResponse(__('errors.unauthorized'), Error::UNAUTHORIZED));
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Project $project): bool
    {
        abort(Error::makeResponse(__('errors.unauthorized'), Error::UNAUTHORIZED));
    }
}
