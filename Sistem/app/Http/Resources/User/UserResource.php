<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data['id'] = $this->id ?? null;
        $data['email'] = $this->email ?? null;
        $data['m_role_id'] = $this->m_role_id ?? null;
        $data['role'] = $this->role->name_role ?? null;
        $data['access'] = isset($this->role->permissions) ? ($this->role->permissions) : [];
        $data['status'] = $this->status ?? null;

        return $data;
    }
}
