<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){
        return response()->json([
            'message' => 'Bienvenido al panel de control administrador'
        ]);
    }
}
