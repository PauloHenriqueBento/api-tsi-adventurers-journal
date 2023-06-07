<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class AtividadeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            $preco = $faker->numberBetween(100, 1000);
            $idCidade = $faker->numberBetween(1, 25);
            $titulo = $faker->sentence;
            $descricao = $faker->paragraph;
            $idadeMinima = $faker->numberBetween(13, 18);
            $modalidades = $faker->randomElements(range(1, 16), $faker->numberBetween(1, 5));
            $dataTime = $faker->dateTimeBetween('2023-08-01', '2023-08-31')->format('Y-m-d\TH:i:s');
            $photoPath = $this->getRandomImage();
            $idGuia = $faker->numberBetween(10, 20);

            $atividadeId = DB::table('atividades')->insertGetId([
                'preco' => $preco,
                'idCidade' => $idCidade,
                'titulo' => $titulo,
                'descricao' => $descricao,
                'idadeMinima' => $idadeMinima,
                'dataTime' => $dataTime,
                'photo_path' => $photoPath,
                'idGuia' => $idGuia
            ]);

            foreach ($modalidades as $modalidade) {
                DB::table('atividade_modalidade')->insert([
                    'atividade_id' => $atividadeId,
                    'modalidade_id' => $modalidade
                ]);
            }
        }
    }

    private function getRandomImage()
    {
        $images = [
            'paraquedismo.png',
            'surf.png',
            'rapel.png',
            'asaDelta.png',
            'rafting.png',
            'baseJump.png',
            'trekking.png',
            'escalada.png',
            'bungeeJump.png',
            'canoagem.png',
            'mergulho.png',
            'snowboard.png',
            'esqui.png',
            'kitesurf.png',
            'skateboarding.png',
            'parkour.png',
        ];

        $randomIndex = array_rand($images);
        $imageName = $images[$randomIndex];

        $sourcePath = public_path('modalidades_images/' . $imageName);
        $destinationPath = storage_path('app/public/modalidades_images/' . $imageName);

        File::copy($sourcePath, $destinationPath);

        return 'modalidades_images/' . $imageName;
    }
}
