<?php

namespace App\Http\Controllers\Api;

use App\Helpers\GuruHelper;
use App\Helpers\UserHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\GuruRequest;
use App\Http\Resources\Guru\GuruCollection;
use App\Http\Resources\Guru\GuruResource;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    protected $userHelper;
    protected $guruHelper;

    public function __construct()
    {
        $this->userHelper = new UserHelper();
        $this->guruHelper = new GuruHelper();
    }

    public function index(Request $request)
    {
        $filter = [
            'nip' => $request->nip ?? '',
            'nama' => $request->nama ?? '',
            'status' => $request->status ?? '',
        ];

        $gurus = $this->guruHelper->getAll($filter, $request->itemPerPage ?? 10, $request->sort ?? "");

        return response()->json(new GuruCollection($gurus), 200);
    }

    public function store(GuruRequest $request)
    {
        $payload_user = $request->only([
            'email',
            'name',
            'password',
            'm_role_id',
            'status',
        ]);
        $user = $this->userHelper->create($payload_user);

        $payload_guru = $request->only([
            'nip',
            'nama',
            'jenis_kelamin',
            'telepon',
            'photo_url',
        ]);

        $payload_guru['m_user_id'] = $user['data']->id;
        $guru = $this->guruHelper->create($payload_guru);

        if (!$guru['status']) {
            return response()->json([
                'message' => $guru['message'],
                'status' => $guru['status'],
            ], 400);
        }

        return response()->json([
            'data' => new GuruResource($guru['data']),
            'message' => $guru['message'],
            'status' => $guru['status'],
        ], 201);
    }

    public function show(string $id)
    {
        $guru = $this->guruHelper->getById($id);

        if (!$guru['status']) {
            return response()->json([
                'message' => $guru['message'],
                'status' => $guru['status'],
            ], 404);
        }

        return response()->json([
            'data' => new GuruResource($guru['data']),
            'message' => $guru['message'],
            'status' => $guru['status'],
        ], 200);
    }

    public function update(GuruRequest $request, string $id)
    {
        $guru = $this->guruHelper->getById($id);

        if (!$guru['status']) {
            return response()->json([
                'message' => $guru['message'],
                'status' => $guru['status'],
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

        $payload_guru = $request->only([
            'nip',
            'nama',
            'jenis_kelamin',
            'telepon',
            'photo_url',
        ]);

        $guru = $this->guruHelper->update($payload_guru, $id);

        if (!$guru['status']) {
            return response()->json([
                'message' => $guru['message'],
                'status' => $guru['status'],
            ], 400);
        }

        return response()->json([
            'data' => new guruResource($guru['data']),
            'message' => $guru['message'],
            'status' => $guru['status'],
        ], 200);
    }

    public function destroy(string $id)
    {
        $guru = $this->guruHelper->getById($id);

        if (!$guru['status']) {
            return response()->json([
                'message' => $guru['message'],
                'status' => $guru['status'],
            ], 404);
        }

        $guru = $this->guruHelper->delete($id);

        if (!$guru['status']) {
            return response()->json([
                'message' => $guru['message'],
                'status' => $guru['status'],
            ], 400);
        }

        return response()->json([
            'message' => $guru['message'],
            'status' => $guru['status'],
        ], 200);
    }
}
