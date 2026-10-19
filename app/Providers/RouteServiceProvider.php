<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/dashboard';

    /**
     * If the user is redirected after login, we can inspect session to redirect to a plan payment.
     *
     * @return string
     */
    public static function redirectTo(): string
    {
        // Se houver 'plan_to_acquire' na sessão, redireciona para a rota de pagamento do plano.
        if (session()->has('plan_to_acquire')) {
            $planId = session('plan_to_acquire');
            session()->forget('plan_to_acquire');

            // Redireciona para a rota que mostra o formulário de pagamento.
            // Ajuste caso sua rota aceite slug — aqui usamos o ID.
            return route('payment.show', ['plan' => $planId]);
        }

        return self::HOME;
    }
}