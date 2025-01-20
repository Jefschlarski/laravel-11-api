<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $validated = $validator->validated();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        if (!$user) {
            return response()->json([
                'message' => 'User registration failed'
            ], 500);
        }

        $token = $user->createToken('auth_token')->plainTextToken;
        if (!$token) {
            return response()->json([
                'message' => 'User auth token generation failed'
            ], 500);
        }

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => new UserResource($user)
        ], 200);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $validated = $validator->validated();

        if (!auth()->attempt($validated)) {
            return response()->json([
                'message' => 'Invalid login details'
            ], 401);
        }

        $token = auth()->user()->createToken('auth_token')->plainTextToken;
        if (!$token) {
            return response()->json([
                'message' => 'User auth token generation failed'
            ], 500);
        }

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => new UserResource(auth()->user())
        ], 200);
    }

    public function logout(Request $request)
    {
        if ($request->user()->currentAccessToken()->delete()) {
            return response()->noContent();
        }
        return response()->json([
            'message' => 'Logout failed'
        ], 500);
    }
}
