<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role): mixed
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        $user = auth()->user();

        $hierarchy = ['author' => 1, 'editor' => 2, 'admin' => 3];
        $userLevel = $hierarchy[$user->role] ?? 0;
        $requiredLevel = $hierarchy[$role] ?? 0;

        if ($userLevel < $requiredLevel) {
            abort(403, 'No tienes permisos para acceder aquí.');
        }

        return $next($request);
    }
}