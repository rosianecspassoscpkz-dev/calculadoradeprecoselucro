<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Routing\Controller;

class HomeController extends Controller
{
    /**
     * Exibe a página inicial com a lista de planos disponíveis.
     */
    public function index()
    {
        $plans = Plan::all();

        return view('conteudo.index', compact('plans'));
    }
}
