<?php

namespace Database\Factories;

use App\Models\EmployeeType;
use App\Models\User;
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
        $employee_type_ids = EmployeeType::all()->pluck('id');
        $user_ids = User::all()->pluck('id');
        return [
            'employee_type_id' => fake()->randomElement($employee_type_ids),
            'user_id' => fake()->randomElement($user_ids),
            'created_by' => fake()->randomElement($user_ids),
        ];
    }
}
