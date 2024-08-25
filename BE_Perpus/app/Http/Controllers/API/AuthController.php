<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\RolesModels;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $roleUser = RolesModels::where('name', 'user')->first();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $roleUser->id
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'message' => 'User created successfully!',
            'token' => $token,
            'user' => $user
        ], 201);
    }

    public function getUser()
    {
        $currentUser = auth()->user()->load('Profile');

        return response()->json([
            'message' => 'User retrieved successfully!',
            'user' => $currentUser
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json([
                'message' => 'Login failed!'
            ], 401);
        }

        $userData = User::with('Role','Profile')->where('email', $request['email'])->first();

        return response()->json([
            'user' => $userData,
            'token' => $token
        ], 200);
    }

    public function logout()
    {
        auth()->logout();
        return response()->json([
            'message' => 'Logout Berhasil'
        ]);
    }
}
