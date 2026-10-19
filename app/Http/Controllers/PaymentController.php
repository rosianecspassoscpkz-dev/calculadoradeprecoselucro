<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Exception;

use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Payment\PaymentClient;

class PaymentController extends Controller
{
    public function __construct()
    {
        MercadoPagoConfig::setAccessToken(
            config('services.mercadopago.access_token')
        );
    }

    /* ===============================
     * FORMULÁRIO DE PAGAMENTO
     * =============================== */
    public function showPaymentForm(Plan $plan)
    {
        session(['selected_plan_id' => $plan->id]);

        return view('payment.show', compact('plan'));
    }

    /* ===============================
     * PROCESSAR PAGAMENTO
     * =============================== */
    public function processPayment(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:pix,bolbradesco',
        ]);

        $plan = Plan::findOrFail(session('selected_plan_id'));

        try {
            $client = new PaymentClient();

            $payment = $client->create([
                'transaction_amount' => (float) $plan->price,
                'description'        => "Plano {$plan->name}",
                'payment_method_id'  => $request->payment_method,
                'payer' => [
                    'email' => Auth::user()->email,
                ],
                'external_reference' => 'plan_' . $plan->id,
            ]);

            Payment::create([
                'user_id'        => Auth::id(),
                'plan_id'        => $plan->id,
                'mp_payment_id'  => $payment->id,
                'external_reference' => $payment->external_reference,
                'transaction_id'=> $payment->id,
                'payment_method'=> $request->payment_method,
                'amount'         => $plan->price,
                'status'         => $payment->status,
            ]);

            return redirect()
                ->route('register.show')
                ->with('success', 'Pagamento iniciado com sucesso.');

        } catch (Exception $e) {
            Log::error('Erro Mercado Pago: ' . $e->getMessage());

            return back()->withErrors([
                'payment_error' => 'Erro ao processar o pagamento.',
            ]);
        }
    }

    /* ===============================
     * CANCELAR
     * =============================== */
    public function cancelPayment()
    {
        return redirect('/')
            ->with('info', 'Pagamento cancelado.');
    }
}
