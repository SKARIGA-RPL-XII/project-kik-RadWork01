<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class UserModel extends Authenticatable implements JWTSubject
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $table = 'm_user';

    public $timestamps = true;

    protected $fillable = [
        'm_role_id',
        'email',
        'password',
        'status'
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'status' => 'boolean',
        ];
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
    public function role()
    {
        return $this->belongsTo(RoleModel::class, 'm_role_id');
    }

    public function getAll(array $filter, int $itemPerPage = 0, string $sort = '')
    {
        $users = $this->query();

        if (!empty($filter['name'])) {
            $users->where('name', 'LIKE', '%'.$filter['name'].'%');
        }

        if (!empty($filter['email'])) {
            $users->where('email', 'LIKE', '%'.$filter['email'].'%');
        }
    
        $sort = $sort ? $sort : $this->table.'.id ASC';
        $users->orderByRaw($sort ?: $this->table.'.id ASC');

        $itemPerPage = ($itemPerPage > 0) ? $itemPerPage : false;
        return $users->paginate($itemPerPage)->appends('sort', $sort);

    }

    public function store(array $payload)
    {
        return $this->create($payload);
    }

    public function getById(string $id)
    {
        return $this->find($id);
    }

    public function edit(array $payload, string $id)
    {
        return $this->find($id)->update($payload);
    }

    public function drop(string $id)
    {
        return $this->find($id)->delete();
    }
}
