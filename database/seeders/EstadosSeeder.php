<?php

namespace Database\Seeders;

use App\Models\Estado;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EstadosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {        
        $estados = [
            // Brasil
            ['nome' => 'São Paulo', 'uf' => 'SP', 'pais_id' => 1],
            ['nome' => 'Rio de Janeiro', 'uf' => 'RJ', 'pais_id' => 1],
            ['nome' => 'Minas Gerais', 'uf' => 'MG', 'pais_id' => 1],
            ['nome' => 'Bahia', 'uf' => 'BA', 'pais_id' => 1],
            ['nome' => 'Paraná', 'uf' => 'PR', 'pais_id' => 1],

            // Estados unidos
            ['nome' => 'California', 'uf' => 'CA', 'pais_id' => 2],
            ['nome' => 'Texas', 'uf' => 'TX', 'pais_id' => 2],
            ['nome' => 'Nova York', 'uf' => 'NY', 'pais_id' => 2],
            ['nome' => 'Flórida', 'uf' => 'FL', 'pais_id' => 2],
            ['nome' => 'Illinois', 'uf' => 'IL', 'pais_id' => 2],

            // Canada
            ['nome' => 'Ontario', 'uf' => 'ON', 'pais_id' => 3],
            ['nome' => 'Quebec', 'uf' => 'QC', 'pais_id' => 3],
            ['nome' => 'Alberta', 'uf' => 'AB', 'pais_id' => 3],
            ['nome' => 'Colúmbia Britânica', 'uf' => 'BC', 'pais_id' => 3],
            ['nome' => 'Manitoba', 'uf' => 'MB', 'pais_id' => 3],

            // Austrália
            ['nome' => 'Queensland', 'uf' => 'QLD', 'pais_id' => 4],
            ['nome' => 'Nova Gales do Sul', 'uf' => 'NSW', 'pais_id' => 4],
            ['nome' => 'Victoria', 'uf' => 'VIC', 'pais_id' => 4],
            ['nome' => 'Austrália Ocidental', 'uf' => 'WA', 'pais_id' => 4],
            ['nome' => 'Austrália do Sul', 'uf' => 'SA', 'pais_id' => 4],

            // França
            ['nome' => 'Île-de-France', 'uf' => 'IDF', 'pais_id' => 5],
            ['nome' => 'Provence-Alpes-Côte d\'Azur', 'uf' => 'PACA', 'pais_id' => 5],
            ['nome' => 'Auvergne-Rhône-Alpes', 'uf' => 'ARA', 'pais_id' => 5],
            ['nome' => 'Occitanie', 'uf' => 'OCC', 'pais_id' => 5],
            ['nome' => 'Hauts-de-France', 'uf' => 'HDF', 'pais_id' => 5],
        ];

        Estado::insert($estados);
    }
}
