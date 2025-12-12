<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{


    public function update($id, Request $request)
    {
// Buscar producto
        $user = User::findOrFail($id);

        // Actualizar solo el precio
        $user->name = $request->input('name');
        $user->password = Hash::make($request->input('password'));
        $user->save();

        return response()->json([
            'message' => 'Usuario   actualizado correctamente',
            'user' => $user,
        ]);
    }
}
