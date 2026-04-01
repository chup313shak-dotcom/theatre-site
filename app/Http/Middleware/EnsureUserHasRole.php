<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserHasRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        // Если роли не указаны, просто проверяем что пользователь авторизован
        if (empty($roles)) {
            return $next($request);
        }
        
        // Проверяем, есть ли у пользователя одна из требуемых ролей
        // Метод hasAnyRole доступен после добавления трейта HasRoles
        if ($user->hasAnyRole($roles)) {
            return $next($request);
        }
        
        abort(403, 'У вас нет доступа к этой странице.');
    }
}