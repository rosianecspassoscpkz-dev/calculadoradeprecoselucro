<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class RegistrationController extends Controller
{
    /* =====================================================
     * FORMULÁRIO DE REGISTRO
     * ===================================================== */
    public function showRegistrationForm()
    {
        if (!session()->has('selected_plan_id')) {
            return redirect()->route('home');
        }

        $plan = Plan::findOrFail(session('selected_plan_id'));

        return view('auth.register', compact('plan'));
    }

    /* =====================================================
     * FINALIZAR CADASTRO APÓS PAGAMENTO
     * ===================================================== */
    public function registerAndFinalize(Request $request)
    {
        if (!session()->has('selected_plan_id')) {
            return redirect()->route('home');
        }

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $plan = Plan::findOrFail(session('selected_plan_id'));

        $user = User::create([
            'name'  => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'subscription_expires_at' => Carbon::now()->addDays(
                $plan->duration_days ?? 30
            ),
        ]);

        Auth::login($user);

        // Remove o plano da sessão após finalizar o cadastro
        session()->forget('selected_plan_id');

        return redirect()
            ->route('dashboard')
            ->with('success', 'Cadastro finalizado com sucesso.');
    }
}
