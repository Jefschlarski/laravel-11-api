<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;

    public const ROOT = 1;
    public const ADMIN = 2;
    public const EMPLOYEE = 3;

    protected $table = 'user_type';

    protected $fillable = [
        'name',
        'description',
        'created_by',
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'user_type_permission', 'user_type_id', 'permission_id');
    }

    public function isAdmin()
    {
        return $this->id === UserType::ADMIN;
    }

    public function isEmployee()
    {
        return $this->id === UserType::EMPLOYEE;
    }

    public function isRoot()
    {
        return $this->id === UserType::ROOT;
    }
}
