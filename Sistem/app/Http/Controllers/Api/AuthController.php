<?php

namespace App\Http\Controllers\Api;

use App\Helpers\AuthHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $authHelper;

    public function __construct()
    {
        $this->authHelper = new AuthHelper();
    }

    public function login(AuthRequest $request)
    {
        try {
            $credentials = $request->only('email', 'password');

            $token = $this->authHelper->login($credentials);

            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'expires_in' => config('jwt.ttl') * 60,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], $e->getCode() ?: 400);
        }
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
