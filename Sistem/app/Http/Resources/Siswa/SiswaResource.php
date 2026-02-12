<?php

namespace App\Http\Resources\Siswa;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SiswaResource extends JsonResource
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
        $data['m_kelas_id'] = $this->m_kelas_id ?? null;
        $data['kelas'] = $this->kelas->nama_kelas ?? null;
        $data['nis'] = $this->nis ?? null;
        $data['nama'] = $this->nama ?? null;
        $data['jenis_kelamin'] = $this->jenis_kelamin ?? null;
        $data['tanggal_lahir'] = $this->tanggal_lahir ?? null;
        $data['alamat'] = $this->alamat ?? null;
        $data['telepon'] = $this->telepon ?? null;
        $data['photo_url'] = $this->photo_url ?? null;

        return $data;
    }
}
