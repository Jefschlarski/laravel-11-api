<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\EmployeeType;
use App\Models\Permission;
use App\Models\Project;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\UserType;
use App\Models\UserTypePermission;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        UserType::factory()->create([
            'name' => 'Admin',
            'description' => 'Admin User Type'
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'user_type_id' => 1
        ]);

        UserType::factory(15)->create();

        Permission::factory(30)->create();

        User::factory(15)->create();

        UserTypePermission::factory(30)->create();

        Project::factory(50)->create();

        TaskStatus::factory(50)->create();

        Task::factory(50)->create();

        EmployeeType::factory(50)->create();

        Employee::factory(50)->create();
    }
}
