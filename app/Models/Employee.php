<?php

namespace App\Models;

use App\Http\Utils\Error;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    /** @use HasFactory<\Database\Factories\EmployeeFactory> */
    use HasFactory;

    protected $table = 'employee';

    protected $fillable = [
        'employee_type_id',
        'user_id',
        'project_id',
        'created_by',
    ];

    public function changeEmployeeType(int $employee_type_id): Error | null
    {
        if ($this->employee_type_id == $employee_type_id) {
            return new Error(__('errors.different_value_required', ['attribute' => 'employee_type_id']), Error::INVALID_DATA);
        }

        $this->employee_type_id = $employee_type_id;

        if (!$this->save()) {
            return new Error(__('errors.update_error', ['attribute' => 'employee_type_id']), Error::INTERNAL_SERVER_ERROR);
        }

        return null;
    }

    public function employeeType()
    {
        return $this->belongsTo(EmployeeType::class, 'employee_type_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
