<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Collection;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function userType()
    {
        return $this->belongsTo(UserType::class, 'user_type_id');
    }

    public function employees()
    {
        return $this->hasMany(Employee::class, 'user_id');
    }

    public function hasPermission(string $permission)
    {
        return $this->userType->permissions()->where('slug', $permission)->exists();
    }
    public function projects()
    {
        $projects = collect();
        foreach ($this->employees as $employee) {
            $projects->push($employee->project);
        }
        return $projects;
    }

    public function tasksIfItsAffiliate(int $perPage = 20)
    {
        return Task::whereIn('project_id', $this->projects()->pluck('id')->toArray())->paginate($perPage);
    }
}
