<?php

// app/Http/Middleware/RoleMiddleware.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role = 'intern')
    {
        if (!$request->user() || !$request->user()->hasRole($role)) {
            abort(403, 'У вас нет прав для выполнения этого действия.');
        }

        return $next($request);
    }
}
