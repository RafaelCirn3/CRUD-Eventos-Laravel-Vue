<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            // return route('login'); // Pode ser comentado ou removido
        }
    
        // Retornar um erro JSON se a autenticação não for fornecida
        return response()->json(['message' => 'Authentication required.'], 401);
    }
}    