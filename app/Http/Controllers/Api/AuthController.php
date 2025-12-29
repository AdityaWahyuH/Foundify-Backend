<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Admin;
use App\Models\Poin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    // =============================================
    // USER AUTHENTICATION
    // =============================================

    // Register User
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:50|unique:user,username',
            'email' => 'required|email|max:100|unique:user,email',
            'password' => 'required|string|min:6|confirmed',
            'nama' => 'required|string|max:100',
            'no_telp' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 400);
        }

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'nama' => $request->nama,
            'no_telp' => $request->no_telp,
            'role' => 'user',
        ]);

        // Buat record poin untuk user baru
        Poin::create([
            'user_id' => $user->user_id,
            'total_poin' => 0,
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'status' => true,
            'message' => 'Registrasi berhasil',
            'data' => [
                'user' => $user,
                'token' => $token,
            ]
        ], 201);
    }

    // Login User
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 400);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Email atau password salah',
            ], 401);
        }

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'status' => true,
            'message' => 'Login berhasil',
            'data' => [
                'user' => $user,
                'token' => $token,
            ]
        ], 200);
    }

    // Get Current User
    public function me()
    {
        try {
            $user = auth('api')->user();

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User tidak ditemukan',
                ], 404);
            }

            return response()->json([
                'status' => true,
                'message' => 'Data user berhasil diambil',
                'data' => $user
            ], 200);
        } catch (JWTException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Token tidak valid',
            ], 401);
        }
    }

    // Logout User
    public function logout()
    {
        try {
            auth('api')->logout();

            return response()->json([
                'status' => true,
                'message' => 'Logout berhasil',
            ], 200);
        } catch (JWTException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal logout',
            ], 500);
        }
    }

// Refresh Token User
public function refresh()
{
    try {
        /** @var \Tymon\JWTAuth\JWTGuard $auth */
        $auth = auth('api');
        $token = $auth->refresh();

        return response()->json([
            'status' => true,
            'message' => 'Token berhasil diperbarui',
            'data' => [
                'token' => $token,
            ]
        ], 200);
    } catch (JWTException $e) {
        return response()->json([
            'status' => false,
            'message' => 'Gagal refresh token',
        ], 500);
    }
}

    // =============================================
    // ADMIN AUTHENTICATION
    // =============================================

    // Login Admin
    public function loginAdmin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 400);
        }

        // Attempt login dengan guard admin-api
        $credentials = $request->only('email', 'password');

        if (!$token = auth('admin-api')->attempt($credentials)) {
            return response()->json([
                'status' => false,
                'message' => 'Email atau password admin salah',
            ], 401);
        }

        $admin = auth('admin-api')->user();

        return response()->json([
            'status' => true,
            'message' => 'Login admin berhasil',
            'data' => [
                'admin' => $admin,
                'token' => $token,
            ]
        ], 200);
    }

    // Get Current Admin
    public function meAdmin()
    {
        try {
            $admin = auth('admin-api')->user();

            if (!$admin) {
                return response()->json([
                    'status' => false,
                    'message' => 'Admin tidak ditemukan',
                ], 404);
            }

            return response()->json([
                'status' => true,
                'message' => 'Data admin berhasil diambil',
                'data' => $admin
            ], 200);
        } catch (JWTException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Token tidak valid',
            ], 401);
        }
    }

    // Logout Admin
    public function logoutAdmin()
    {
        try {
            auth('admin-api')->logout();

            return response()->json([
                'status' => true,
                'message' => 'Logout admin berhasil',
            ], 200);
        } catch (JWTException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal logout admin',
            ], 500);
        }
    }

// Refresh Token Admin
public function refreshAdmin()
{
    try {
        /** @var \Tymon\JWTAuth\JWTGuard $auth */
        $auth = auth('admin-api');
        $token = $auth->refresh();

        return response()->json([
            'status' => true,
            'message' => 'Token admin berhasil diperbarui',
            'data' => [
                'token' => $token,
            ]
        ], 200);
    } catch (JWTException $e) {
        return response()->json([
            'status' => false,
            'message' => 'Gagal refresh token admin',
        ], 500);
    }
}
}
