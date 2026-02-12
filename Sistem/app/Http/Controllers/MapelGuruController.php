<?php

namespace App\Http\Controllers;

use App\Helpers\MapelGuruHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\MapelGuruRequest;
use App\Http\Resources\MapelGuruCollection;
use App\Http\Resources\MapelGuruResource;
use Illuminate\Http\Request;

class MapelGuruController extends Controller
{
    protected $mapelGuruHelper;

    public function __construct()
    {
        $this->mapelGuruHelper = new MapelGuruHelper();
    }

    public function index(Request $request)
    {
        $filter = [
        ];

        $mapels = $this->mapelGuruHelper->getAll($filter, $request->itemPerPage ?? 10, $request->sort ?? "");

        return response()->json(new MapelGuruCollection($mapels), 200);
    }

    public function store(MapelGuruRequest $request)
    {
        $payload = $request->only([
            'm_guru_id',
            'm_mapel_id',
        ]);

        $mapel = $this->mapelGuruHelper->create($payload);

        if (!$mapel['status']) {
            return response()->json([
                'message' => $mapel['message'],
                'status' => $mapel['status'],
            ], 400);
        }

        return response()->json([
            'data' => new MapelGuruResource($mapel['data']),
            'message' => $mapel['message'],
            'status' => $mapel['status'],
        ], 201);
    }

    public function show(string $id)
    {
        $mapel = $this->mapelGuruHelper->getById($id);


        if (!$mapel['status']) {
            return response()->json([
                'message' => $mapel['message'],
                'status' => $mapel['status'],
            ], 404);
        }

        return response()->json([
            'data' => new MapelGuruResource($mapel['data']),
            'message' => $mapel['message'],
            'status' => $mapel['status'],
        ], 200);
    }

    public function update(MapelGuruRequest $request, string $id)
    {
        $mapel = $this->mapelGuruHelper->getById($id);

        if (!$mapel['status']) {
            return response()->json([
                'message' => $mapel['message'],
                'status' => $mapel['status'],
            ], 404);
        }

        $payload = $request->only([
            'm_guru_id',
            'm_mapel_id',
        ]);

        $mapel = $this->mapelGuruHelper->update($payload, $id);

        if (!$mapel['status']) {
            return response()->json([
                'message' => $mapel['message'],
                'status' => $mapel['status'],
            ], 400);
        }

        return response()->json([
            'data' => new MapelGuruResource($mapel['data']),
            'message' => $mapel['message'],
            'status' => $mapel['status'],
        ], 200);
    }

    public function destroy(string $id)
    {
        $mapel = $this->mapelGuruHelper->getById($id);

        if (!$mapel['status']) {
            return response()->json([
                'message' => $mapel['message'],
                'status' => $mapel['status'],
            ], 404);
        }

        $mapel = $this->mapelGuruHelper->delete($id);

        if (!$mapel['status']) {
            return response()->json([
                'message' => $mapel['message'],
                'status' => $mapel['status'],
            ], 400);
        }

        return response()->json([
            'message' => $mapel['message'],
            'status' => $mapel['status'],
        ], 200);
    }
}
