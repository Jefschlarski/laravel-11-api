<?php

namespace App\Providers;

use App\Http\Utils\Error;
use App\Models\Employee;
use App\Models\EmployeeType;
use App\Models\Permission;
use App\Models\Project;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Policies\EmployeePolicy;
use App\Policies\EmployeeTypePolicy;
use App\Policies\ProjectPolicy;
use App\Policies\TaskPolicy;
use App\Policies\TaskStatusPolicy;
use Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Project::class, policy: ProjectPolicy::class);

        Gate::policy(Task::class, policy: TaskPolicy::class);

        Gate::policy(TaskStatus::class, policy: TaskStatusPolicy::class);

        Gate::policy(Employee::class, policy: EmployeePolicy::class);

        Gate::policy(EmployeeType::class, policy: EmployeeTypePolicy::class);

        Gate::define('view-point-of-failure', function ()
        {
            return auth()->user()->userType->isRoot() ? true : false;
        });

        Gate::define('access-projects', function ()
        {
            if (auth()->user()->hasPermission(Permission::ACCESS_PROJECTS)) {
                return true;
            };

            abort(Error::makeResponse(__('errors.unauthorized'), Error::FORBIDDEN));
        });

        Gate::define('access-tasks', function ()
        {
            return true;
            if (auth()->user()->hasPermission(Permission::ACCESS_TASKS)) {
                return true;
            };

            abort(Error::makeResponse(__('errors.unauthorized'), Error::FORBIDDEN));
        });

        Gate::define('access-employees', function ()
        {
            if (auth()->user()->hasPermission(Permission::ACCESS_EMPLOYEE)) {
                return true;
            };

            abort(Error::makeResponse(__('errors.unauthorized'), Error::FORBIDDEN));
        });

        Gate::define('update', function ()
        {
            if (auth()->user()->hasPermission(Permission::UPDATE)) {
                return true;
            };

            abort(Error::makeResponse(__('errors.unauthorized'), Error::FORBIDDEN));
        });

        Gate::define('delete', function ()
        {
            if (auth()->user()->hasPermission(Permission::DELETE)) {
                return true;
            };

            abort(Error::makeResponse(__('errors.unauthorized'), Error::FORBIDDEN));
        });

        Gate::define('create', function ()
        {
            if (auth()->user()->hasPermission(Permission::CREATE)) {
                return true;
            };

            abort(Error::makeResponse(__('errors.unauthorized'), Error::FORBIDDEN));
        });

        Gate::define('view', function ()
        {
            if (auth()->user()->hasPermission(Permission::VIEW)) {
                return true;
            }

            abort(Error::makeResponse(__('errors.unauthorized'), Error::FORBIDDEN));
        });

        Gate::define('list', function ()
        {
            if (auth()->user()->hasPermission(Permission::LIST)) {
                return true;
            }

            abort(Error::makeResponse(__('errors.unauthorized'), Error::FORBIDDEN));
        });
    }
}
