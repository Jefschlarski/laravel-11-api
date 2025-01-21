<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\EmployeeType;
use App\Models\Project;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        User::factory(15)->create();

        Project::factory(50)->create();

        TaskStatus::factory(50)->create();

        Task::factory(50)->create();

        EmployeeType::factory(50)->create();

        Employee::factory(50)->create();
    }
}
