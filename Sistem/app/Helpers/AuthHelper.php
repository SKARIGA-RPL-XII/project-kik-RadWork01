<?php
namespace App\Helpers;

use Exception;
use Illuminate\Support\Facades\Auth;

class AuthHelper
{
    public function login($credentials = [])
    {
        if (!$token = Auth::attempt($credentials)) {
            throw new Exception('Email atau password salah', 401);
        }

        $user = Auth::user();

        if (!$user->status) {
            Auth::logout();
            throw new Exception('Akun tidak aktif', 403);
        }

        return $token;
    }
}