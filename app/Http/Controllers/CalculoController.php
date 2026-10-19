<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CalculoController extends Controller
{
    public function create(Request $request)
    {
        $nome_produto = $request->input('nome_produto', '');

        // Garante quantidade mínima = 1
        $qtdeProd = (int) $request->input('qtdeProd', 1);
        if ($qtdeProd <= 0) {
            $qtdeProd = 1;
        }

        // Arrays de custos e taxas
        $custos = is_array($request->input('custo'))
            ? array_filter($request->input('custo'), fn($v) => $v !== null && $v !== '')
            : [];

        $taxas = is_array($request->input('taxa'))
            ? array_filter($request->input('taxa'), fn($v) => $v !== null && $v !== '')
            : [];

        $lucro = (float) $request->input('lucro', 0);

        $custo_total = 0;
        $taxa_total = 0;
        $valor_produto = 0;
        $custo_unitario = 0;

        if (!empty($custos)) {

            $custo_total = array_sum($custos);
            $taxa_total = array_sum($taxas);

            $taxa_decimal = $taxa_total / 100;
            $lucro_decimal = $lucro / 100;

            $denominador = 1 - $taxa_decimal - $lucro_decimal;

            if ($denominador > 0) {
                // Valor total de venda
                $valor_produto = $custo_total / $denominador;

                // Preço unitário correto
                $custo_unitario = $valor_produto / $qtdeProd;
            }
        }

        return redirect()->route('dashboard')->with([
            'nome_produto'   => $nome_produto,
            'custos'         => !empty($custos) ? $custos : [''],
            'taxas'          => !empty($taxas) ? $taxas : [''],
            'custo'          => $custo_total,
            'taxa'           => $taxa_total,
            'lucro'          => $lucro,
            'qtdeProd'       => $qtdeProd,
            'valor_produto'  => round($valor_produto, 2),
            'custo_unitario' => round($custo_unitario, 2),
        ]);
    }
}
