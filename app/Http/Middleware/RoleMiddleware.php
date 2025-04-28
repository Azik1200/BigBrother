<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role = 'view')
    {
        if (Auth::guest()) {
            return redirect()->route('login');
        }

        $user = $request->user();

        if (!$user || !$user->hasRole($role)) {
            abort(403, 'У вас нет прав для выполнения этого действия.');
        }

        return $next($request);
    }
}
