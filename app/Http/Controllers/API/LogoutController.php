<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;

class LogoutController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            Auth::logout();
            return response()->json(['message' => 'successfully logged out']);
        } catch (JWTException $exception) {
            return response()->json(['message' => 'Token not found!'], status:401);
        }
    }
}
