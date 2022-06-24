<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    // Función para realizar el proceso de login
    public function login(LoginRequest $request)
    {
        // Ejecuta el método de la clase LoginRequest
        $request->authenticate();

        // Toma el usuario del request
        $user = $request->user();

        // Se procede a crear un token
        // https://laravel.com/docs/8.x/sanctum#issuing-api-tokens
        $token = $user->createToken('token-name')->plainTextToken;

        // Se procede a establecer la respuesta
        return response([
            'token' => $token,
            'user' => $user,
        ], 201);
    }

    public function logout(Request $request)
    {
        // https://laravel.com/docs/8.x/queries#delete-statements
        $request->user()->tokens()->delete();
        return [
            'message' => 'Logged out'
        ];
    }
}