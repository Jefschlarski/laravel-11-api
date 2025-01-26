<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTypePermission extends Model
{
    /** @use HasFactory<\Database\Factories\UserTypePermissionFactory> */
    use HasFactory;

    protected $table = 'user_type_permission';

    /**
     * The primary key for the model.
     *
     * @var array
     */
    protected $primaryKey = ['user_type_id', 'permission_id'];

    /**
     * @inheritDoc
     */
    protected $keyType = 'string';

    /**
     * @inheritDoc
     */
    public $incrementing = false;


    protected $fillable = [
        'user_type_id',
        'permission_id',
        'created_by',
    ];

    public function permission()
    {
        return $this->belongsTo(Permission::class, 'permission_id');
    }

    public function userType()
    {
        return $this->belongsTo(UserType::class, 'user_type_id');
    }
}
