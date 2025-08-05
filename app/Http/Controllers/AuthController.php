<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;




class AuthController extends Controller
{
    public function login(Request $request)
    {
        $email = $request->input('email');
        $passwordBase64 = $request->input('password');
        $password = base64_decode($passwordBase64);


        if (!Auth::attempt(['email' => $email, 'password' => $password])) {
            return response()->json(['message' => 'Credenciales inválidas'], 401);
        }

        $user = $request->user();
        $token = $user->createToken('vital-token')->plainTextToken;

        return response()->json([
        'token' => $token,
        'user' => [
            'name' => $user->name,
            'email' => $user->email,
            'rol' => $user->rol
        ]
    ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Sesión cerrada']);
    }
}
