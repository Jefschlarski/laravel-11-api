<?php

namespace Database\Factories;

use App\Models\Permission;
use App\Models\User;
use App\Models\UserType;
use Arr;
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
        $userTypes = UserType::inRandomOrder()->pluck('id')->toArray();
        $permissions = Permission::inRandomOrder()->pluck('id')->toArray();

        foreach ($permissions as $permission) {
            foreach ($userTypes as $userType) {
                $exists = DB::table('user_type_permission')
                    ->where('user_type_id', $userType)
                    ->where('permission_id', $permission)
                    ->exists();

                if (!$exists) {
                    return [
                        'user_type_id' => $userType,
                        'permission_id' => $permission,
                        'created_by' => Arr::random(User::all()->pluck('id')->toArray()),
                    ];
                }
            }
        }
    }
}
