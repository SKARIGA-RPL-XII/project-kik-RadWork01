<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleModel extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $table = 'm_role';

    public $timestamps = true;

    protected $fillable = [
        'name_role',
        'permissions'
    ];

    protected $casts = [
        'permissions' => 'array'
    ];

    public function users()
    {
        return $this->hasMany(UserModel::class, 'm_role_id');
    }
}
