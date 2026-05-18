<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SubdirectorMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            abort(403, 'No autorizado');
        }

        $role = auth()->user()->role;

        if (!in_array($role, ['subdirector', 'admin'])) {
            abort(403, 'No autorizado');
        }

        return $next($request);
    }
}