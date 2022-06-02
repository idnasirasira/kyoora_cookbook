<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|string|max:200',
            'password' => 'required|string|min:8',
        ]);

        if(!User::checkEmailExists($request->email)){
            return response()->json([
                'msg' => __('Email is not registered.'),
                'authenticated' => false,
            ], 200);
        }

        if(!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'msg' => __('Unauthenticated'),
                'authenticated' => false,
            ], 401);
        }

        // $user = Auth::user();
        $user = User::where('email', $request->email)->firstOrFail();

        $token = $user->createToken('auth-sanctum')->plainTextToken;

        return response()->json([
            'data' => $user,
            'access_token' => $token,
            'authenticated' => true,
        ], 200);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:200',
            'email' => 'required|email|string|max:200|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('auth-sanctum')->plainTextToken;

        return response()->json([
            'msg' => __('Register success'),
            'data' => $user,
            'access_token' => $token,
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'msg' => __("Logout success"),
        ], 200);
    }
}
