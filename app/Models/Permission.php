<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    /** @use HasFactory<\Database\Factories\EmployeeFactory> */
    use HasFactory;

    protected $table = 'permission';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'created_by',
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function userTypes()
    {
        return $this->belongsToMany(UserType::class, 'user_type_permission', 'permission_id', 'user_type_id');
    }
}
