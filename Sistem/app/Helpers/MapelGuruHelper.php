<?php
namespace App\Helpers;

use App\Models\MapelGuruModel;

class MapelGuruHelper
{
protected $mapelGuruModel;

    public function __construct()
    {
        $this->mapelGuruModel = new MapelGuruModel();
    }

    public function getAll(array $filter, int $itemPerPage = 0, string $sort = '')
    {
        $data = $this->mapelGuruModel->getAll($filter, $itemPerPage, $sort);

        return $data;
    }

    public function create(array $payload): array
    {
        try {
            $data = $this->mapelGuruModel->store($payload);

            return [
                "status" => true,
                "message" => "mapel guru berhasil ditugaskan",
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
            $data = $this->mapelGuruModel->getById($id);

            if (!$data) {
                return [
                    "status" => false,
                    "message" => "mapel guru tidak ditemukan"
                ];
            }

            return [
                "status" => true,
                "message" => "Detail mapel guru",
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
            $data = $this->mapelGuruModel->edit($payload, $id);
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
            $data = $this->mapelGuruModel->drop($id);
            
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