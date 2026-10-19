<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Routing\Controller;
use App\Http\Middleware\Authenticate;

class PlanAcquisitionController extends Controller
{
    /**
     * Garante que apenas o método "start" seja acessível
     * sem autenticação (usuários convidados).
     */
    public function __construct()
    {
        $this->middleware(Authenticate::class)->except(['start']);
    }

    /**
     * Inicia o processo de aquisição do plano.
     * Acessível para usuários não autenticados.
     *
     * @param \App\Models\Plan $plan
     */
    public function start(Plan $plan)
    {
        // Salva o plano selecionado na sessão
        session([
            'selected_plan_id' => $plan->id,
        ]);

        // Redireciona para o formulário de pagamento
        return redirect()->route('payment.show', $plan);
    }
}
