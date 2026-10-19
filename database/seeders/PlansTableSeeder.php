<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlansTableSeeder extends Seeder
{
    public function run()
    {
        // Desabilita checagem de FK
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Limpa a tabela
        DB::table('plans')->truncate();

        // Reativa checagem
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Insere planos
        DB::table('plans')->insert([
            [
                'name' => 'Básico',
                'description' => 'Plano básico, acesso por 30 dias',
                'price' => 29.90,
                'duration_days' => 30,
            ],
            [
                'name' => 'Pro',
                'description' => 'Plano Pro, acesso por 90 dias',
                'price' => 59.90,
                'duration_days' => 90,
            ],
            [
                'name' => 'Premium',
                'description' => 'Plano Premium, acesso por 365 dias',
                'price' => 99.90,
                'duration_days' => 365,
            ],
        ]);
    }
}
