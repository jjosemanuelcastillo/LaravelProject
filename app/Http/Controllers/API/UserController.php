<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function countUsers(Request $request)
    {
        $user = auth('api')->user();
        if (!$user) {
            return response()->json(['error' => 'No autenticado'], 401);
        }

        if ($user->role !== 'admin') {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $count = User::where('role', '!=', 'admin')->count();
        return response()->json(['count' => $count]);
    }
}
