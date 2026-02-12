<?php
namespace App\Helpers;

use App\Models\GuruModel;

class GuruHelper
{
    protected $guruModel;

    public function __construct()
    {
        $this->guruModel = new GuruModel();
    }

    public function getAll(array $filter, int $itemPerPage = 0, string $sort = '')
    {
        $data = $this->guruModel->getAll($filter, $itemPerPage, $sort);

        return $data;
    }

    public function create(array $payload): array
    {
        try {
            $data = $this->guruModel->store($payload);

            return [
                "status" => true,
                "message" => "guru berhasil dibuat",
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
            $data = $this->guruModel->getById($id);

            if (!$data) {
                return [
                    "status" => false,
                    "message" => "guru tidak ditemukan"
                ];
            }

            return [
                "status" => true,
                "message" => "Detail guru",
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
            $data = $this->guruModel->edit($payload, $id);
            if ($data) {
                $guru = $this->getById($id);

                return [
                    "status" => true,
                    "message" => "Data berhasil diubah",
                    "data" => $guru['data']
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
            $data = $this->guruModel->drop($id);
            
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