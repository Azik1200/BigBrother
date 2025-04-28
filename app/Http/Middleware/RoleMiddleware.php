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
            return $next($request); // Просто пропускаем гостей без проверки роли
        }

        if (!$request->user() || !$request->user()->hasRole($role)) {
            abort(403, 'У вас нет прав для выполнения этого действия.');
        }

        return $next($request);
    }
}
