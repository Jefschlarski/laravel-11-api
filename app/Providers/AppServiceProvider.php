<?php

namespace App\Providers;

use App\Http\Utils\Error;
use App\Models\Employee;
use App\Models\EmployeeType;
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

        /**
         * @todo check if the user is root from the moment I have already implemented the user permissions and the user type
        */
        Gate::define('view-point-of-failure', function ()
        {
            return true;
        });

        Gate::define('access-projects', function ()
        {
            return true;
        });

        Gate::define('access-tasks', function ()
        {
            return true;
        });

        Gate::define('access-employees', function ()
        {
            return true;
        });

        Gate::define('update', function ()
        {
            return true;
        });

        Gate::define('delete', function ()
        {
            return true;
        });

        Gate::define('create', function ()
        {
            return true;
        });

        Gate::define('view', function ()
        {
            return true;
        });

        Gate::define('list', function ()
        {
            return true;
        });
    }
}
