<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Chama todos os seeders de dados necessários
$this->call([
    PlansTableSeeder::class,
]);

    }
}