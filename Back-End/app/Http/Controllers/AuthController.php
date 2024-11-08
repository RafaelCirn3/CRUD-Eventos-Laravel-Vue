<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['message' => 'User registered successfully!'], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken('token_name')->plainTextToken;

        return response()->json(['token' => $token]);
    }
    public function logout(Request $request)
    {
        Auth::user()->tokens->each(function ($token) {
            $token->delete(); // Remove todos os tokens do usuário
        });

        return response()->json(['message' => 'Logged out successfully']);
    }
    public function get_user_id(Request $request)
    {
        // Verificando se o usuário está autenticado
        if (Auth::check()) {
            return response()->json(['user_id' => Auth::user()->id]);
        } else {
            return response()->json(['error' => 'Usuário não autenticado'], 401);
        }
    }
}
