<?php

namespace App\Http\Resources\Guru;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GuruResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data['id'] = $this->id ?? null;
        $data['m_user_id'] = $this->m_user_id ?? null;
        $data['nip'] = $this->nip ?? null;
        $data['nama'] = $this->nama ?? null;
        $data['jenis_kelamin'] = $this->jenis_kelamin ?? null;
        $data['telepon'] = $this->telepon ?? null;
        $data['photo_url'] = $this->photo_url ?? null;

        return $data;
    }
}
