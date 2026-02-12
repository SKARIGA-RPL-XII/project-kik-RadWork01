<?php

namespace App\Http\Controllers\Api;

use App\Helpers\SiswaHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    protected $siswaHelper;

    public function __construct()
    {
        $this->siswaHelper = new SiswaHelper();
    }

    public function index(Request $request)
    {
        $filter = [
            'nip' => $request->nama ?? '',
            'nama' => $request->nama ?? '',
        ];

        $siswas = $this->siswaHelper->getAll($filter, $request->itemPerPage ?? 10, $request->sort ?? "");

        return response()->json(new siswaCollection($siswas), 200);
    }

    public function store(siswaRequest $request)
    {
        $payload = $request->only([
            'nama_siswa',
        ]);

        $siswa = $this->siswaHelper->create($payload);

        if (!$siswa['status']) {
            return response()->json([
                'message' => $siswa['message'],
                'status' => $siswa['status'],
            ], 400);
        }

        return response()->json([
            'data' => new siswaResource($siswa['data']),
            'message' => $siswa['message'],
            'status' => $siswa['status'],
        ], 201);
    }

    public function show(string $id)
    {
        $siswa = $this->siswaHelper->getById($id);

        if (!$siswa['status']) {
            return response()->json([
                'message' => $siswa['message'],
                'status' => $siswa['status'],
            ], 404);
        }

        return response()->json([
            'data' => new siswaResource($siswa['data']),
            'message' => $siswa['message'],
            'status' => $siswa['status'],
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        $siswa = $this->siswaHelper->getById($id);

        if (!$siswa['status']) {
            return response()->json([
                'message' => $siswa['message'],
                'status' => $siswa['status'],
            ], 404);
        }

        $payload = $request->only([
            'nama_siswa',
        ]);

        $siswa = $this->siswaHelper->update($payload, $id);

        if (!$siswa['status']) {
            return response()->json([
                'message' => $siswa['message'],
                'status' => $siswa['status'],
            ], 400);
        }

        return response()->json([
            'data' => new siswaResource($siswa['data']),
            'message' => $siswa['message'],
            'status' => $siswa['status'],
        ], 200);
    }

    public function destroy(string $id)
    {
        $siswa = $this->siswaHelper->getById($id);

        if (!$siswa['status']) {
            return response()->json([
                'message' => $siswa['message'],
                'status' => $siswa['status'],
            ], 404);
        }

        $siswa = $this->siswaHelper->delete($id);

        if (!$siswa['status']) {
            return response()->json([
                'message' => $siswa['message'],
                'status' => $siswa['status'],
            ], 400);
        }

        return response()->json([
            'message' => $siswa['message'],
            'status' => $siswa['status'],
        ], 200);
    }
}
