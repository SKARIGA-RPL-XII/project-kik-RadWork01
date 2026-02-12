<?php
namespace App\Helpers;

use App\Models\KelasModel;


class KelasHelper
{
    protected $kelasModel;

    public function __construct()
    {
        $this->kelasModel = new KelasModel();
    }

    public function getAll(array $filter, int $itemPerPage = 0, string $sort = '')
    {
        $data = $this->kelasModel->getAll($filter, $itemPerPage, $sort);

        return $data;
    }

    public function create(array $payload): array
    {
        try {
            $data = $this->kelasModel->store($payload);

            return [
                "status" => true,
                "message" => "kelas berhasil dibuat",
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
            $data = $this->kelasModel->getById($id);

            if (!$data) {
                return [
                    "status" => false,
                    "message" => "kelas tidak ditemukan"
                ];
            }

            return [
                "status" => true,
                "message" => "Detail kelas",
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
            $data = $this->kelasModel->edit($payload, $id);
            if ($data) {
                $kelas = $this->getById($id);

                return [
                    "status" => true,
                    "message" => "Data berhasil diubah",
                    "data" => $kelas['data']
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
            $data = $this->kelasModel->drop($id);
            
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