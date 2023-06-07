<?php

namespace Database\Seeders;

use App\Models\Assinatura;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AssinaturaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $assinaturas = [
            [
                'nome' => 'Gratuita',
                'preco' => 0.00,
            ],
            [
                'nome' => 'Adventurer',
                'preco' => 150.00,
            ],
            [
                'nome' => 'Adventurer plus',
                'preco' => 280.00,
            ],
        ];

        foreach ($assinaturas as $assinatura) {
            Assinatura::create($assinatura);
        }
    }
}
