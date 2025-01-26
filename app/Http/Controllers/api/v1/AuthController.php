<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Utils\Error;
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
            return Error::makeResponse($validator->errors(), Error::INVALID_DATA);
        }

        $user = New User();
        $user->fill($validator->validated());
        $user->password = Hash::make($request->password);

        if (!$user->save()) {
            return Error::makeResponse(__('errors.creation_error', ['attribute' => 'User']), Error::INTERNAL_SERVER_ERROR);
        }

        if (!$token = $user->createToken('auth_token')->plainTextToken) {
            return Error::makeResponse(__('errors.create_token_error'), Error::INTERNAL_SERVER_ERROR);
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

        if (!auth()->attempt($validator->validated())) {
            return Error::makeResponse(__('auth.failed'), Error::UNAUTHORIZED);
        }

        if (!$token = auth()->user()->createToken('auth_token')->plainTextToken) {
            return Error::makeResponse(__('errors.create_token_error'), Error::INTERNAL_SERVER_ERROR);
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
        return Error::makeResponse(__('errors.logout_error'), Error::INTERNAL_SERVER_ERROR, Error::getTraceAndMakePointOfFailure());
    }
}
