<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends Controller
{
    public function __invoke(Request $request)
{
    $credentials = $request->only('email', 'password');

    // Intentar generar token
    if (! $token = JWTAuth::attempt($credentials)) {
        return response()->json(['error' => 'Credenciales incorrectas'], 401);
    }

    // Recuperar el usuario explícitamente
    $user = \App\Models\User::where('email', $credentials['email'])->first();

    if (!$user) {
        return response()->json(['error' => 'Usuario no encontrado'], 404);
    }

    return response()->json([
        'message' => 'Inicio de sesión correcto',
        'user' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role ?? 'user', // fallback
        ],
        'token' => $token
    ]);
}

            public function me()
    {
                return response()->json(Auth::user());
            }
        }
