<?php
namespace App\Helpers;

use App\Models\UserModel;
use Hash;


class UserHelper
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function getAll(array $filter, int $itemPerPage = 0, string $sort = '')
    {
        $data = $this->userModel->getAll($filter, $itemPerPage, $sort);

        return $data;
    }

    public function create(array $payload): array
    {
        try {
            $payload['password'] = Hash::make($payload['password']);

            $data = $this->userModel->store($payload);

            return [
                "status" => true,
                "message" => "User berhasil dibuat",
                "data" => $data
            ];
        } catch (\Throwable $th) {
            return [
                "status" => false,
                "message" => $th->getMessage()
            ];
        }
    }

    public function getById(string $id)
    {
        try {
            $data = $this->userModel->getById($id);

            if (!$data) {
                return [
                    "status" => false,
                    "message" => "User tidak ditemukan"
                ];
            }

            return [
                "status" => true,
                "message" => "Detail user",
                "data" => $data
            ];
        } catch (\Throwable $th) {
            return [
                "status" => false,
                "message" => $th->getMessage()
            ];
        }
    }

    public function update(array $payload, string $id)
    {
        try {
            if (isset($payload['password']) && !empty($payload['password'])) {
                $payload['password'] = Hash::make($payload['password']) ?: '';
            } else {
                unset($payload['password']);
            }

            $data = $this->userModel->edit($payload, $id);
            if ($data) {
                $user = $this->getById($id);

                return [
                    "status" => true,
                    "message" => "Data berhasil diubah",
                    "data" => $user['data']
                ];
            }
        } catch (\Throwable $th) {
            return [
                "status" => false,
                "message" => $th->getMessage()
            ];
        }
    }

    public function delete(string $id)
    {
        try {
            $data = $this->userModel->drop($id);

            if ($data) {
                return [
                    "status" => true,
                    "message" => "Data berhasil dihapus",
                ];
            }
        } catch (\Throwable $th) {
            return [
                "status" => false,
                "message" => $th->getMessage()
            ];
        }
    }
}