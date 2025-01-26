<?php

use App\Models\Permission;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $permissions = [
            ['name' => 'Acess Projects', 'slug' => 'access-projects', 'created_by' => 1],
            ['name' => 'Acess Tasks', 'slug' => 'access-tasks', 'created_by' => 1],
            ['name' => 'Acess Employee', 'slug' => 'access-employee', 'created_by' => 1],
            ['name' => 'View', 'slug' => 'view', 'created_by' => 1],
            ['name' => 'List', 'slug' => 'list', 'created_by' => 1],
            ['name' => 'Create', 'slug' => 'create', 'created_by' => 1],
            ['name' => 'Update', 'slug' => 'update', 'created_by' => 1],
            ['name' => 'Delete', 'slug' => 'delete', 'created_by' => 1],
            ['name' => 'View Any Employee', 'slug' => 'view-any-employee', 'created_by' => 1],
            ['name' => 'View Employee', 'slug' => 'view-employee', 'created_by' => 1],
            ['name' => 'View Your Employee', 'slug' => 'view-your-employee', 'created_by' => 1],
            ['name' => 'Create Employee', 'slug' => 'create-employee', 'created_by' => 1],
            ['name' => 'Update Employee', 'slug' => 'update-employee', 'created_by' => 1],
            ['name' => 'Delete Employee', 'slug' => 'delete-employee', 'created_by' => 1],
            ['name' => 'View Any Employee Type', 'slug' => 'view-any-employee-type', 'created_by' => 1],
            ['name' => 'View Employee Type', 'slug' => 'view-employee-type', 'created_by' => 1],
            ['name' => 'Create Employee Type', 'slug' => 'create-employee-type', 'created_by' => 1],
            ['name' => 'Update Employee Type', 'slug' => 'update-employee-type', 'created_by' => 1],
            ['name' => 'Delete Employee Type', 'slug' => 'delete-employee-type', 'created_by' => 1],
            ['name' => 'View Any Project', 'slug' => 'view-any-project', 'created_by' => 1],
            ['name' => 'View Your Project', 'slug' => 'view-your-project', 'created_by' => 1],
            ['name' => 'View Project', 'slug' => 'view-project', 'created_by' => 1],
            ['name' => 'Create Project', 'slug' => 'create-project', 'created_by' => 1],
            ['name' => 'Update Project', 'slug' => 'update-project', 'created_by' => 1],
            ['name' => 'Delete Project', 'slug' => 'delete-project', 'created_by' => 1],
            ['name' => 'View Any Task', 'slug' => 'view-any-task', 'created_by' => 1],
            ['name' => 'View Tasks If Its Affiliated With It', 'slug' => 'view-tasks-if-its-affiliate', 'created_by' => 1],
            ['name' => 'View Task', 'slug' => 'view-task', 'created_by' => 1],
            ['name' => 'View Your Task', 'slug' => 'view-your-task', 'created_by' => 1],
            ['name' => 'Create Task', 'slug' => 'create-task', 'created_by' => 1],
            ['name' => 'Update Task', 'slug' => 'update-task', 'created_by' => 1],
            ['name' => 'Delete Task', 'slug' => 'delete-task', 'created_by' => 1],
            ['name' => 'View Any Task Status', 'slug' => 'view-any-task-status', 'created_by' => 1],
            ['name' => 'View Task Status', 'slug' => 'view-task-status', 'created_by' => 1],
            ['name' => 'Create Task Status', 'slug' => 'create-task-status', 'created_by' => 1],
            ['name' => 'Update Task Status', 'slug' => 'update-task-status', 'created_by' => 1],
            ['name' => 'Delete Task Status', 'slug' => 'delete-task-status', 'created_by' => 1],
        ];

        Schema::create('permission', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('slug', 50)->unique();
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->timestamps();
        });

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permission');
    }
};
