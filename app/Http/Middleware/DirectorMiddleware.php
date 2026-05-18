<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DirectorMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            abort(403, 'No autorizado');
        }

        $role = auth()->user()->role;

        // Director puede ver su panel, admin también puede previsualizarlo
        if (!in_array($role, ['director', 'admin'])) {
            abort(403, 'No autorizado');
        }

        return $next($request);
    }
}