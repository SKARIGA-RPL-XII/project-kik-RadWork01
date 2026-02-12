<?php
namespace App\Helpers;

use App\Models\MapelModel;

class MapelHelper
{
    protected $mapelModel;

    public function __construct()
    {
        $this->mapelModel = new MapelModel();
    }

    public function getAll(array $filter, int $itemPerPage = 0, string $sort = '')
    {
        $data = $this->mapelModel->getAll($filter, $itemPerPage, $sort);

        return $data;
    }

    public function create(array $payload): array
    {
        try {
            $data = $this->mapelModel->store($payload);

            return [
                "status" => true,
                "message" => "mapel berhasil dibuat",
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
            $data = $this->mapelModel->getById($id);

            if (!$data) {
                return [
                    "status" => false,
                    "message" => "mapel tidak ditemukan"
                ];
            }

            return [
                "status" => true,
                "message" => "Detail mapel",
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
            $data = $this->mapelModel->edit($payload, $id);
            if ($data) {
                $mapel = $this->getById($id);

                return [
                    "status" => true,
                    "message" => "Data berhasil diubah",
                    "data" => $mapel['data']
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
            $data = $this->mapelModel->drop($id);
            
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