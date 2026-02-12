<?php

namespace App\Http\Controllers\api;

use App\Helpers\UserHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\User\UserCollection;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $userHelper;

    public function __construct()
    {
        $this->userHelper = new UserHelper();
    }

    public function index(Request $request)
    {
        $filter = [
            'name' => $request->name ?? '',
            'email' => $request->email ?? '',
        ];

        $users = $this->userHelper->getAll($filter, $request->itemPerPage ?? 10, $request->sort ?? "");

        return response()->json(new UserCollection($users), 200);
    }

    public function store(UserRequest $request)
    {
        $payload = $request->only([
            'email',
            'name',
            'password',
            'm_role_id',
            'status'
        ]);

        $user = $this->userHelper->create($payload);

        if (!$user['status']) {
            return response()->json([
                'message' => $user['message'],
                'status' => $user['status'],

            ], 400);
        }

        return response()->json([
            'data' => new UserResource($user['data']),
            'message' => $user['message'],
            'status' => $user['status'],
        ], 201);
    }

    public function show(string $id)
    {
        $user = $this->userHelper->getById($id);

        if (!$user['status']) {
            return response()->json([
                'message' => $user['message'],
                'status' => $user['status'],
            ], 404);
        }

        return response()->json([
            'data' => new UserResource($user['data']),
            'message' => $user['message'],
            'status' => $user['status'],
        ], 200);
    }

    public function update(UserRequest $request, string $id)
    {

        $user = $this->userHelper->getById($id);

        if (!$user['status']) {
            return response()->json([
                'message' => $user['message'],
                'status' => $user['status'],
            ], 404);
        }

        $payload = $request->only([
            'email',
            'name',
            'password',
            'm_role_id',
            'status'
        ]);

        $user = $this->userHelper->update($payload, $id);

        if (!$user['status']) {
            return response()->json([
                'message' => $user['message'],
                'status' => $user['status'],
            ], 400);
        }

        return response()->json([
            'data' => new UserResource($user['data']),
            'message' => $user['message'],
            'status' => $user['status'],
        ], 200);
    }

    public function destroy(string $id)
    {
        $user = $this->userHelper->getById($id);

        if (!$user['status']) {
            return response()->json([
                'message' => $user['message'],
                'status' => $user['status'],
            ], 404);
        }

        $user = $this->userHelper->delete($id);

        if (!$user['status']) {
            return response()->json([
                'message' => $user['message'],
                'status' => $user['status'],
            ], 400);
        }

        return response()->json([
            'message' => $user['message'],
            'status' => $user['status'],
        ], 200);
    }
}
