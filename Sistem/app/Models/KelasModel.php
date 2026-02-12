<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KelasModel extends Model
{
    use HasFactory, SoftDeletes, HasUuids;
    
    protected $table = 'm_kelas';

    public $timestamps = true;

    protected $fillable = [
        'm_guru_id',
        'nama_kelas'
    ];

    public function guru()
    {
        return $this->belongsTo(GuruModel::class, 'm_guru_id');
    }

    public function getAll(array $filter, int $itemPerPage = 0, string $sort = '')
    {
        $mapels = $this->query();

        if (!empty($filter['nama_kelas'])) {
            $mapels->where('nama_kelas', 'LIKE', '%'.$filter['nama_kelas'].'%');
        }
    
        $sort = $sort ? $sort : $this->table.'.nama_kelas ASC';
        $mapels->orderByRaw($sort ?: $this->table.'.nama_kelas ASC');

        $itemPerPage = ($itemPerPage > 0) ? $itemPerPage : false;
        return $mapels->paginate($itemPerPage)->appends('sort', $sort);
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
