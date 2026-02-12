<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MapelGuruResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data['id'] = $this->id ?? null;
        $data['m_guru_id'] = $this->m_guru_id ?? null;
        $data['guru'] = $this->guru->nama ?? null;
        $data['m_mapel_id'] = $this->m_mapel_id ?? null;
        $data['mapel'] = $this->mapel->nama_mapel ?? null;

        return $data;
    }
}
