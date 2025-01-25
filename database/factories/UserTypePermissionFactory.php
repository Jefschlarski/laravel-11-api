<?php

namespace Database\Factories;

use App\Models\Permission;
use App\Models\UserType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserTypePermission>
 */
class UserTypePermissionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        do {
            $userTypeId = fake()->randomElement(UserType::all()->pluck('id')->toArray());
            $permissionId = fake()->randomElement(Permission::all()->pluck('id')->toArray());

            $exists = DB::table('user_type_permission')
                ->where('user_type_id', $userTypeId)
                ->where('permission_id', $permissionId)
                ->exists();
        } while ($exists);

        return [
            'user_type_id' => $userTypeId,
            'permission_id' => $permissionId,
            'created_by' => fake()->randomElement(UserType::all()->pluck('id')->toArray()),
        ];
    }
}
