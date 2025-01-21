<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeType extends Model
{
    /** @use HasFactory<\Database\Factories\EmployeeTypeFactory> */
    use HasFactory;

    protected $table = 'employee_type';

    protected $fillable = [
        'name',
        'description',
        'created_by',
    ];
}