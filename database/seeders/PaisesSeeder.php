<?php

namespace Database\Seeders;

use App\Models\Pais;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaisesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $paises = [
            ['nome' => 'Brasil'],
            ['nome' => 'Estados Unidos'],
            ['nome' => 'Canadá'],
            ['nome' => 'Austrália'],
            ['nome' => 'França']
        ];

        Pais::insert($paises);
    }
}
