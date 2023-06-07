<?php

namespace Database\Seeders;

use App\Models\Atividade;
use App\Models\Cidade;
use App\Models\Modalidade;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class AtividadeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Obter todos os IDs de guias, cidades e modalidades existentes
        $guias = User::where('isGuia', true)->pluck('id')->all();
        $cidades = Cidade::pluck('id')->all();
        $modalidades = Modalidade::pluck('id')->all();

        // Criar atividades aleatórias
        foreach (range(1, 100) as $index) {
            $atividade = Atividade::create([
                'IdGuia' => $faker->randomElement($guias),
                'preco' => $faker->randomFloat(2, 10, 5000),
                'idCidade' => $faker->randomElement($cidades),
                'Titulo' => $faker->sentence(),
                'Descricao' => $faker->paragraph(),
                'DataTime' => $faker->dateTimeBetween('now', '+6 months'),
                'IdadeMinima' => $faker->numberBetween(10, 50),
                'photo_path' => $faker->imageUrl()
            ]);

            // Adicionar 1, 2, 3 ou mais modalidades aleatoriamente
            $modalidadesCount = $faker->numberBetween(1, 3);
            $atividade->modalidades()->attach($faker->randomElements($modalidades, $modalidadesCount));
        }
    }
}
