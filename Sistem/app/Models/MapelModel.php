<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MapelModel extends Model
{
    use HasFactory, SoftDeletes, HasUuids;
    
    protected $table = 'm_mapel';

    public $timestamps = true;

    protected $fillable = [
        'nama_mapel'
    ];

    public function mapel_gurus()
    {
        return $this->hasMany(MapelGuruModel::class, 'm_mapel_id');
    }

    public function getAll(array $filter, int $itemPerPage = 0, string $sort = '')
    {
        $mapels = $this->query();

        if (!empty($filter['nama_mapel'])) {
            $mapels->where('nama_mapel', 'LIKE', '%'.$filter['nama_mapel'].'%');
        }
    
        $sort = $sort ? $sort : $this->table.'.nama_mapel ASC';
        $mapels->orderByRaw($sort ?: $this->table.'.nama_mapel ASC');

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
