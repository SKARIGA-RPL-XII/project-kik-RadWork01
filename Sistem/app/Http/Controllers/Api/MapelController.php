<?php

namespace App\Http\Controllers\Api;

use App\Helpers\MapelHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\MapelRequest;
use App\Http\Resources\Mapel\MapelCollection;
use App\Http\Resources\Mapel\MapelResource;
use Illuminate\Http\Request;

class MapelController extends Controller
{
    protected $mapelHelper;

    public function __construct()
    {
        $this->mapelHelper = new MapelHelper();
    }

    public function index(Request $request)
    {
        $filter = [
            'nama_mapel' => $request->nama_mapel ?? '',
        ];

        $mapels = $this->mapelHelper->getAll($filter, $request->itemPerPage ?? 10, $request->sort ?? "");

        return response()->json(new MapelCollection($mapels), 200);
    }

    public function store(MapelRequest $request)
    {
        $payload = $request->only([
            'nama_mapel',
        ]);

        $mapel = $this->mapelHelper->create($payload);

        if (!$mapel['status']) {
            return response()->json([
                'message' => $mapel['message'],
                'status' => $mapel['status'],
            ], 400);
        }

        return response()->json([
            'data' => new MapelResource($mapel['data']),
            'message' => $mapel['message'],
            'status' => $mapel['status'],
        ], 201);
    }

    public function show(string $id)
    {
        $mapel = $this->mapelHelper->getById($id);
        

        if (!$mapel['status']) {
            return response()->json([
                'message' => $mapel['message'],
                'status' => $mapel['status'],
            ], 404);
        }

        return response()->json([
            'data' => new MapelResource($mapel['data']),
            'message' => $mapel['message'],
            'status' => $mapel['status'],
        ], 200);
    }

    public function update(MapelRequest $request, string $id)
    {
        $mapel = $this->mapelHelper->getById($id);

        if (!$mapel['status']) {
            return response()->json([
                'message' => $mapel['message'],
                'status' => $mapel['status'],
            ], 404);
        }

        $payload = $request->only([
            'nama_mapel',
        ]);

        $mapel = $this->mapelHelper->update($payload, $id);

        if (!$mapel['status']) {
            return response()->json([
                'message' => $mapel['message'],
                'status' => $mapel['status'],
            ], 400);
        }

        return response()->json([
            'data' => new MapelResource($mapel['data']),
            'message' => $mapel['message'],
            'status' => $mapel['status'],
        ], 200);
    }

    public function destroy(string $id)
    {
        $mapel = $this->mapelHelper->getById($id);

        if (!$mapel['status']) {
            return response()->json([
                'message' => $mapel['message'],
                'status' => $mapel['status'],
            ], 404);
        }

        $mapel = $this->mapelHelper->delete($id);

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
