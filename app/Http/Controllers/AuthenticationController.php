<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'birth_date' => $request->birth_date,
            'password'   => Hash::make($request->password),
        ]);

        $token = $user->createToken('authToken')->accessToken;

        return response()->json([
            'success' => true,
            'message' => 'User registered successfully!',
            'user'    => $user,
            'token'   => $token
        ], Response::HTTP_CREATED);
    }


    public function login(LoginRequest $request)
    {
        if (!auth()->attempt($request->validated())) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials!'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $token = auth()->user()->createToken('authToken')->accessToken;

        return response()->json([
            'success' => true,
            'message' => 'User logged in successfully.',
            'user'    => auth()->user(),
            'token'   => $token
        ], Response::HTTP_OK);
    }

    public function refreshToken(Request $request)
    {
        $request->user()->token()->refresh();
        $token = $request->user()->token();

        return response()->json([
            'success' => true,
            'message' => 'Token refreshed successfully.',
            'token'   => $token
        ], Response::HTTP_OK);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'success' => true,
            'message' => 'User logged out successfully.'
        ], Response::HTTP_OK);
    }
}
