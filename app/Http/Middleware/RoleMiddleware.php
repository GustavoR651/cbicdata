<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role): Response
    {
        // 1. Se não estiver logado, manda pro login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // 2. Se o cargo do usuário for diferente do exigido na rota
        if (Auth::user()->role !== $role) {
            // Se tentar acessar admin sem ser admin, joga pro dashboard comum
            return redirect()->route('dashboard')->with('error', 'Acesso restrito.');
        }

        return $next($request);
    }
}