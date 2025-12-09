<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Redirige a login si el usuario no está autenticado.
     */
    protected function redirectTo($request): ?string
    {
        if (! $request->expectsJson()) {
            return route('login'); // 👈 redirige a la ruta de login de Laravel
        }
        return null;
    }
}
