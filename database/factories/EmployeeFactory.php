<?php

namespace Database\Factories;

use App\Models\EmployeeType;
use App\Models\Project;
use App\Models\User;
use Arr;
use DB;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user_ids = User::all()->pluck('id')->toArray();
        $project_ids = Project::all()->pluck('id')->toArray();
        $user_id_not_exists = null;
        $project_id_not_exists = null;
        do {
            $on = true;
            $user_id = Arr::random($user_ids);
            $project_id = Arr::random($project_ids);

            $exists = DB::table('employee')
                ->where('user_id', $user_id)
                ->where('project_id', $project_id)
                ->exists();

            if (!$exists) {
                $on = false;
                $user_id_not_exists = $user_id;
                $project_id_not_exists = $project_id;
            }
        } while ($on);

        return [
            'user_id' => $user_id_not_exists,
            'project_id' => $project_id_not_exists,
            'employee_type_id' => EmployeeType::inRandomOrder()->first()->id,
            'created_by' => User::inRandomOrder()->first()->id,
        ];
    }
}
