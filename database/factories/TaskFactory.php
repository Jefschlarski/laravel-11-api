<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user_ids = User::all()->pluck('id');
        $project_ids = Project::all()->pluck('id');
        $task_status_ids = TaskStatus::all()->pluck('id');
        return [
            'title' => fake()->title(),
            'description' => fake()->text(50),
            'due_date' => fake()->date(),
            'closed_at' => fake()->date(),
            'project_id' => fake()->randomElement($project_ids),
            'task_status_id' => fake()->randomElement($task_status_ids),
            'created_by' => fake()->randomElement($user_ids),
        ];
    }
}
