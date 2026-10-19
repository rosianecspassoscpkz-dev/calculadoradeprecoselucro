<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): \Symfony\Component\HttpFoundation\Response  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        // 1. Usuário precisa estar autenticado
        if (!$user) {
            return redirect()->route('login');
        }

        // 2. Assinatura inexistente ou expirada
        // A coluna 'subscription_expires_at' deve ser datetime (nullable)
        if (
            $user->subscription_expires_at === null ||
            $user->subscription_expires_at->isPast()
        ) {
            // Evita loop de redirecionamento
            if ($request->routeIs('renew.show')) {
                return $next($request);
            }

            // Redireciona para a tela de renovação
            return redirect()->route('renew.show');
        }

        // 3. Assinatura válida
        return $next($request);
    }
}
