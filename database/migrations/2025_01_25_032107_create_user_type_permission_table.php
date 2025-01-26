<?php

use App\Models\Permission;
use App\Models\UserType;
use App\Models\UserTypePermission;
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
        $employeePermissions = [
            Permission::ACCESS_PROJECTS,
            Permission::ACCESS_TASKS,
            Permission::VIEW_TASK,
            Permission::VIEW_PROJECT,
        ];

        $adminPermissions = [
            Permission::ACCESS_PROJECTS,
            Permission::ACCESS_TASKS,
            Permission::ACCESS_EMPLOYEE,
            Permission::VIEW,
            Permission::LIST,
            Permission::CREATE,
            Permission::UPDATE,
            Permission::DELETE,
            Permission::VIEW_ANY_PROJECT,
            Permission::VIEW_PROJECT,
            Permission::CREATE_PROJECT,
            Permission::UPDATE_PROJECT,
            Permission::DELETE_PROJECT,
            Permission::VIEW_ANY_TASK,
            Permission::VIEW_TASK,
            Permission::CREATE_TASK,
            Permission::UPDATE_TASK,
            Permission::DELETE_TASK,
            Permission::VIEW_ANY_EMPLOYEE,
            Permission::VIEW_EMPLOYEE,
            Permission::CREATE_EMPLOYEE,
            Permission::UPDATE_EMPLOYEE,
            Permission::DELETE_EMPLOYEE,
            Permission::VIEW_ANY_EMPLOYEE_TYPE,
            Permission::VIEW_EMPLOYEE_TYPE,
            Permission::CREATE_EMPLOYEE_TYPE,
            Permission::UPDATE_EMPLOYEE_TYPE,
            Permission::DELETE_EMPLOYEE_TYPE,
        ];

        Schema::create('user_type_permission', function (Blueprint $table) {
            $table->foreignId('permission_id')->constrained('permission');
            $table->foreignId('user_type_id')->constrained('user_type');
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->timestamps();
            $table->primary(['permission_id', 'user_type_id']);
        });

        foreach ($employeePermissions as $permission) {
            UserTypePermission::create([
                'permission_id' => Permission::where(['slug' => $permission])->first()->id,
                'user_type_id' => UserType::EMPLOYEE,
                'created_by' => 1
            ]);
        }

        foreach ($adminPermissions as $permission) {
            UserTypePermission::create([
                'permission_id' => Permission::where(['slug' => $permission])->first()->id,
                'user_type_id' => UserType::ADMIN,
                'created_by' => 1
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_type_permission');
    }
};
