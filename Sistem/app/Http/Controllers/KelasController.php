<?php

namespace App\Http\Controllers;

use App\Helpers\KelasHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\KelasRequest;
use App\Http\Resources\KelasCollection;
use App\Http\Resources\KelasResource;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    protected $kelasHelper;

    public function __construct()
    {
        $this->kelasHelper = new KelasHelper();
    }

    public function index(Request $request)
    {
        $filter = [
            'nama_kelas' => $request->nama_kelas ?? '',
        ];

        $kelas = $this->kelasHelper->getAll($filter, $request->itemPerPage ?? 10, $request->sort ?? "");

        return response()->json(new KelasCollection($kelas), 200);
    }

    public function store(KelasRequest $request)
    {
        $payload = $request->only([
            'm_guru_id',
            'nama_kelas',
        ]);

        $kelas = $this->kelasHelper->create($payload);

        if (!$kelas['status']) {
            return response()->json([
                'message' => $kelas['message'],
                'status' => $kelas['status'],
            ], 400);
        }

        return response()->json([
            'data' => new KelasResource($kelas['data']),
            'message' => $kelas['message'],
            'status' => $kelas['status'],
        ], 201);
    }

    public function show(string $id)
    {
        $kelas = $this->kelasHelper->getById($id);

        if (!$kelas['status']) {
            return response()->json([
                'message' => $kelas['message'],
                'status' => $kelas['status'],
            ], 404);
        }

        return response()->json([
            'data' => new KelasResource($kelas['data']),
            'message' => $kelas['message'],
            'status' => $kelas['status'],
        ], 200);
    }

    public function update(KelasRequest $request, string $id)
    {
        $kelas = $this->kelasHelper->getById($id);

        if (!$kelas['status']) {
            return response()->json([
                'message' => $kelas['message'],
                'status' => $kelas['status'],
            ], 404);
        }

        $payload = $request->only([
            'm_guru_id',
            'nama_kelas',
        ]);

        $kelas = $this->kelasHelper->update($payload, $id);

        if (!$kelas['status']) {
            return response()->json([
                'message' => $kelas['message'],
                'status' => $kelas['status'],
            ], 400);
        }

        return response()->json([
            'data' => new KelasResource($kelas['data']),
            'message' => $kelas['message'],
            'status' => $kelas['status'],
        ], 200);
    }

    public function destroy(string $id)
    {
        $kelas = $this->kelasHelper->getById($id);

        if (!$kelas['status']) {
            return response()->json([
                'message' => $kelas['message'],
                'status' => $kelas['status'],
            ], 404);
        }

        $kelas = $this->kelasHelper->delete($id);

        if (!$kelas['status']) {
            return response()->json([
                'message' => $kelas['message'],
                'status' => $kelas['status'],
            ], 400);
        }

        return response()->json([
            'message' => $kelas['message'],
            'status' => $kelas['status'],
        ], 200);
    }
}
