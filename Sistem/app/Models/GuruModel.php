<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GuruModel extends Model
{
    use HasFactory, SoftDeletes, HasUuids;
    
    protected $table = 'm_guru';

    public $timestamps = true;

    protected $fillable = [
        'm_user_id',
        'nip',
        'nama',
        'jenis_kelamin',
        'telepon',
        'photo_url',
    ];

    public function user()
    {
        return $this->belongsTo(UserModel::class, 'm_user_id');
    }

    public function mapels()
    {
        return $this->hasMany(MapelGuruModel::class, 'm_guru_id');
    }

    public function kelas()
    {
        return $this->hasMany(KelasModel::class, 'm_guru_id');
    }

    public function getAll(array $filter, int $itemPerPage = 0, string $sort = '')
    {
        $gurus = $this->query();

        if (!empty($filter['nip'])) {
            $gurus->where('nip', 'LIKE', '%'.$filter['nip'].'%');
        }

        if (!empty($filter['nama'])) {
            $gurus->where('nama', 'LIKE', '%'.$filter['nama'].'%');
        }
    
        $sort = $sort ? $sort : $this->table.'.nama ASC';
        $gurus->orderByRaw($sort ?: $this->table.'.nama ASC');

        $itemPerPage = ($itemPerPage > 0) ? $itemPerPage : false;
        return $gurus->paginate($itemPerPage)->appends('sort', $sort);
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
