<?php

namespace App\Http\Resources\Kelas;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KelasResource extends JsonResource
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
        $data['nama_kelas'] = $this->nama_kelas ?? null;

        return $data;
    }
}
