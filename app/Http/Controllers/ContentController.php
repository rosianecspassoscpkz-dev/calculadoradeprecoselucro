<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContentController extends Controller
{
    /**
     * Exibe o conteúdo premium (protegido pelo CheckSubscription Middleware).
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        // O Middleware já garantiu que a assinatura está ativa.
      //  return view('content.dashboard');
      return view('dashboard');
    }

    /**
     * Exibe a página de renovação de assinatura.
     * Usada quando a assinatura do usuário expirou.
     *
     * @return \Illuminate\View\View
     */
    public function showRenewForm()
    {
        $user = Auth::user();
        return view('conteudo.renew', compact('user'));
    }
}
