<?php

namespace App\Http\Controllers\Api;

use App\Helpers\SiswaHelper;
use App\Helpers\UserHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\SiswaRequest;
use App\Http\Resources\Siswa\SiswaCollection;
use App\Http\Resources\Siswa\SiswaResource;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    protected $userHelper;
    protected $siswaHelper;

    public function __construct()
    {
        $this->userHelper = new UserHelper();
        $this->siswaHelper = new siswaHelper();
    }

    public function index(Request $request)
    {
        $filter = [
            'nis' => $request->nis ?? '',
            'nama' => $request->nama ?? '',
            'status' => $request->status ?? '',
        ];

        $siswas = $this->siswaHelper->getAll($filter, $request->itemPerPage ?? 10, $request->sort ?? "");

        return response()->json(new SiswaCollection($siswas), 200);
    }

    public function store(siswaRequest $request)
    {
        $payload_user = $request->only([
            'email',
            'name',
            'password',
            'm_role_id',
            'status',
        ]);
        $user = $this->userHelper->create($payload_user);

        $payload_siswa = $request->only([
            'm_kelas_id',
            'nis',
            'nama',
            'jenis_kelamin',
            'tanggal_lahir',
            'alamat',
            'telepon',
            'photo_url',
        ]);

        $payload_siswa['m_user_id'] = $user['data']->id;
        $siswa = $this->siswaHelper->create($payload_siswa);

        if (!$siswa['status']) {
            return response()->json([
                'message' => $siswa['message'],
                'status' => $siswa['status'],
            ], 400);
        }

        return response()->json([
            'data' => new SiswaResource($siswa['data']),
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
            'data' => new SiswaResource($siswa['data']),
            'message' => $siswa['message'],
            'status' => $siswa['status'],
        ], 200);
    }

    public function update(siswaRequest $request, string $id)
    {
        $siswa = $this->siswaHelper->getById($id);

        if (!$siswa['status']) {
            return response()->json([
                'message' => $siswa['message'],
                'status' => $siswa['status'],
            ], 404);
        }

        $payload_user = $request->only([
            'email',
            'name',
            'password',
            'm_role_id',
            'status',
            'm_user_id',
        ]);
        $this->userHelper->update($payload_user, $payload_user['m_user_id']);

        $payload_siswa = $request->only([
            'm_kelas_id',
            'nis',
            'nama',
            'jenis_kelamin',
            'tanggal_lahir',
            'alamat',
            'telepon',
            'photo_url',
        ]);

        $siswa = $this->siswaHelper->update($payload_siswa, $id);

        if (!$siswa['status']) {
            return response()->json([
                'message' => $siswa['message'],
                'status' => $siswa['status'],
            ], 400);
        }

        return response()->json([
            'data' => new SiswaResource($siswa['data']),
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
