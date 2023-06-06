<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ModalidadeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {

        $modalidades = [
            [
                'nome' => 'Paraquedismo',
                'descricao' => 'Experimente a emoção da queda livre e a sensação de liberdade enquanto desce suavemente com um paraquedas.',
                'photo_path' => 'paraquedismo.png'
            ],
            [
                'nome' => 'Surf',
                'descricao' => 'Domine as ondas e sinta a energia do mar ao praticar esse esporte emocionante.',
                'photo_path' => 'surf.png'
            ],
            [
                'nome' => 'Rapel',
                'descricao' => 'Desça paredões e encare desafios verticais com segurança e adrenalina.',
                'photo_path' => 'rapel.png'
            ],
            [
                'nome' => 'Asa-Delta',
                'descricao' => 'Voe pelos céus e desfrute da incrível sensação de liberdade enquanto plana no ar.',
                'photo_path' => 'asaDelta.png'
            ],
            [
                'nome' => 'Rafting',
                'descricao' => 'Aventure-se em emocionantes descidas de rios em um bote inflável, enfrentando corredeiras e desfrutando da natureza.',
                'photo_path' => 'rafting.png'
            ],
            [
                'nome' => 'Base jump',
                'descricao' => 'Salte de estruturas altas e experimente a descarga de adrenalina em uma modalidade radical.',
                'photo_path' => 'baseJump.png'
            ],
            [
                'nome' => 'Trekking',
                'descricao' => 'Explore trilhas incríveis e descubra paisagens deslumbrantes em caminhadas pela natureza.',
                'photo_path' => 'trekking.png'
            ],
            [
                'nome' => 'Escalada',
                'descricao' => 'Desafie-se a subir montanhas e rochas, superando obstáculos e testando suas habilidades.',
                'photo_path' => 'escalada.png'
            ],
            [
                'nome' => 'Bungee Jump',
                'descricao' => 'Pule de uma plataforma com uma corda elástica presa ao corpo e experimente uma sensação única de queda livre.',
                'photo_path' => 'bungeeJump.png'
            ],
            [
                'nome' => 'Canoagem',
                'descricao' => 'Navegue em rios e lagos, explorando paisagens deslumbrantes e enfrentando desafios na água.',
                'photo_path' => 'canoagem.png'
            ],
            [
                'nome' => 'Mergulho',
                'descricao' => 'Descubra o fascinante mundo subaquático, explorando recifes de corais e encontrando uma diversidade incrível de vida marinha.',
                'photo_path' => 'mergulho.png'
            ],
            [
                'nome' => 'Snowboard',
                'descricao' => 'Deslize pelas montanhas cobertas de neve em uma prancha, desafiando as pistas e sentindo a adrenalina do esporte.',
                'photo_path' => 'snowboard.png'
            ],
            [
                'nome' => 'Esqui',
                'descricao' => 'Desça montanhas cobertas de neve com esquis nos pés, aproveitando a velocidade e a emoção dessa modalidade.',
                'photo_path' => 'esqui.png'
            ],
            [
                'nome' => 'Kitesurf',
                'descricao' => 'Combine o poder do vento com a habilidade de manobrar uma prancha na água, criando uma experiência única de esporte aquático.',
                'photo_path' => 'kitesurf.png'
            ],
            [
                'nome' => 'Skateboarding',
                'descricao' => 'Execute manobras radicais em uma prancha com rodas, desafiando a gravidade e mostrando estilo.',
                'photo_path' => 'skateboarding.png'
            ],
            [
                'nome' => 'Parkour',
                'descricao' => 'Supere obstáculos urbanos de forma ágil e criativa, combinando saltos, escaladas e movimentos acrobáticos.',
                'photo_path' => 'parkour.png'
            ],
        ];

        // $modalidades = [
        //     [
        //         'nome' => 'Paraquedismo',
        //         'descricao' => 'Experimente a emoção da queda livre e a sensação de liberdade enquanto desce suavemente com um paraquedas.',
        //         'photo_path' => 'paraquedismo.png'
        //     ],
        //     [
        //         'nome' => 'surf',
        //         'descricao' => 'Domine as ondas e sinta a energia do mar ao praticar esse esporte emocionante.',
        //         'photo_path' => 'surf.png'
        //     ],
        //     [
        //         'nome' => 'rapel',
        //         'descricao' => 'Desça paredões e encare desafios verticais com segurança e adrenalina.',
        //         'photo_path' => 'rapel.png'
        //     ],
        //     [
        //         'nome' => 'Asa-Delta',
        //         'descricao' => 'Voe pelos céus e desfrute da incrível sensação de liberdade enquanto plana no ar.',
        //         'photo_path' => 'asaDelta.png'
        //     ],

        //     [
        //         'nome' => 'Rafting',
        //         'descricao' => 'Aventure-se em emocionantes descidas de rios em um bote inflável, enfrentando corredeiras e desfrutando da natureza.',
        //         'photo_path' => 'rafting.png'
        //     ],
        //     [
        //         'nome' => 'Base jump',
        //         'descricao' => 'Salte de estruturas altas e experimente a descarga de adrenalina em uma modalidade radical.',
        //         'photo_path' => 'baseJump.png'
        //     ],
        //     [
        //         'nome' => 'Trekking',
        //         'descricao' => 'Explore trilhas incríveis e descubra paisagens deslumbrantes em caminhadas pela natureza.',
        //         'photo_path' => 'trekking.png'
        //     ],
        //     [
        //         'nome' => 'Escalada',
        //         'descricao' => 'Desafie-se a subir montanhas e rochas, superando obstáculos e testando suas habilidades.',
        //         'photo_path' => 'escalada.png'
        //     ],

        //     [
        //         'nome' => 'Bungee Jump',
        //         'descricao' => 'Pule de uma plataforma com uma corda elástica presa ao corpo e experimente uma sensação única de queda livre.',
        //         'photo_path' => 'bungeeJump.png'
        //     ],
        //     [
        //         'nome' => 'Canoagem',
        //         'descricao' => 'Navegue em rios e lagos, explorando paisagens deslumbrantes e enfrentando desafios na água.',
        //         'photo_path' => 'canoagem.png'
        //     ],
        //     [
        //         'nome' => 'Mergulho',
        //         'descricao' => 'Descubra o fascinante mundo subaquático, explorando recifes de corais e encontrando uma diversidade incrível de vida marinha.',
        //         'photo_path' => 'mergulho.png'
        //     ],
        //     [
        //         'nome' => 'Snowboard',
        //         'descricao' => 'Deslize pelas montanhas cobertas de neve em uma prancha, desafiando as pistas e sentindo a adrenalina do esporte.',
        //         'photo_path' => 'snowboard.png'
        //     ],

        //     [
        //         'nome' => 'Esqui',
        //         'descricao' => 'Desça montanhas cobertas de neve com esquis nos pés, aproveitando a velocidade e a emoção dessa modalidade.',
        //         'photo_path' => 'esqui.png'
        //     ],
        //     [
        //         'nome' => 'Kitesurf',
        //         'descricao' => 'Combine o poder do vento com a habilidade de manobrar uma prancha na água, criando uma experiência única de esporte aquático.',
        //         'photo_path' => 'kitesurf.png'
        //     ],
        //     [
        //         'nome' => 'Skateboarding',
        //         'descricao' => 'Execute manobras radicais em uma prancha com rodas, desafiando a gravidade e mostrando estilo.',
        //         'photo_path' => 'skateboarding.png'
        //     ],
        //     [
        //         'nome' => 'Parkour',
        //         'descricao' => 'Supere obstáculos urbanos de forma ágil e criativa, combinando saltos, escaladas e movimentos acrobáticos.',
        //         'photo_path' => 'parkour.png'
        //     ],
        // ];

        foreach ($modalidades as $modalidade) {
            // Copiar a imagem para a pasta de armazenamento
            $photoPath = $this->copyImage($modalidade['photo_path']);

            // Inserir os dados no banco de dados
            DB::table('modalidades')->insert([
                'nome' => $modalidade['nome'],
                'descricao' => $modalidade['descricao'],
                'photo_path' => $photoPath,
            ]);
        }
    }

    /**
     * Copiar a imagem para a pasta de armazenamento.
     *
     * @param string $fileName
     * @return string
     */
    private function copyImage($fileName)
    {
        $sourcePath = public_path('modalidades_images/' . $fileName);
        $destinationPath = storage_path('app/public/modalidades_images/' . $fileName);

        // Criar diretório de destino, se não existir
        File::ensureDirectoryExists(dirname($destinationPath));

        // Copiar a imagem para o diretório de destino
        File::copy($sourcePath, $destinationPath);

        return 'modalidades_images/' . $fileName;
    }
}
