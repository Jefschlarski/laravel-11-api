<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EmployeeType>
 */
class EmployeeTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user_ids = User::all()->pluck('id');
        return [
            'name' => fake()->name(),
            'description' => fake()->text(50),
            'created_by' => fake()->randomElement($user_ids),
        ];
    }
}
