<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\Auth;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        return response()->json(['message' => 'Usuario registrado correctamente', 'user' => $user], 201);
    }

    public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|string|email',
        'password' => 'required|string',
    ]);

    $user = User::where('email', $credentials['email'])->first();

    // Si no existe o la contraseña es incorrecta
    if (!$user || !Hash::check($credentials['password'], $user->password)) {
        return response()->json(['message' => 'Credenciales incorrectas'], 401);
    }


    // Devolver solo la información necesaria
    return response()->json([
        'message' => 'Inicio de sesión correcto',
        'user' => [
            'id' => $user->id,
            'name' =>(string) $user->name,
            'email' =>(string) $user->email,
        ],
    ], 200);
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete(); // asumiendo que tienes la relación definida en Product
        user::destroy($id);              // elimina el producto

        return response()->json([
            'message' => 'Producto eliminado',
            'product' => $user,
        ]);
    }
}
