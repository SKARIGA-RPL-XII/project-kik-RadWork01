<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use Auth;

class AuthController extends Controller
{
    public function login(AuthRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return response()->failed($request->validator->errors(), 422);
        }

        $credentials = $request->only('email', 'password');

        if (!$token = Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Email atau password salah'
            ], 401);
        }

        $user = Auth::user();

        if (!$user->status) {
            return response()->json([
                'message' => 'Akun tidak aktif'
            ], 403);
        }

        return response()->json([
            'token' => $token,
            'type' => 'Bearer',
            'user' => $user->load('role')
        ]);
    }

    public function me()
    {
        return response()->json(
            Auth::user()->load('role')
        );
    }

    public function logout()
    {
        Auth::logout();

        return response()->json([
            'message' => 'Logout berhasil'
        ]);
    }
}
