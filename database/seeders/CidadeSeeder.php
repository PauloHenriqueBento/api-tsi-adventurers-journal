<?php

namespace Database\Seeders;

use App\Models\Cidade;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CidadeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cidades = [
            // Brasil
            // São Paulo
            ['nome' => 'São Paulo', 'estado_id' => 1],
            ['nome' => 'Campos do Jordão', 'estado_id' => 1],
            ['nome' => 'Santos', 'estado_id' => 1],
            ['nome' => 'Ilhabela', 'estado_id' => 1],
            ['nome' => 'Águas de Lindoia', 'estado_id' => 1],

            // Rio de Janeiro
            ['nome' => 'Rio de Janeiro', 'estado_id' => 2],
            ['nome' => 'Búzios', 'estado_id' => 2],
            ['nome' => 'Paraty', 'estado_id' => 2],
            ['nome' => 'Angra dos Reis', 'estado_id' => 2],
            ['nome' => 'Petrópolis', 'estado_id' => 2],

            // Minas Gerais
            ['nome' => 'Belo Horizonte', 'estado_id' => 3],
            ['nome' => 'Ouro Preto', 'estado_id' => 3],
            ['nome' => 'Tiradentes', 'estado_id' => 3],
            ['nome' => 'Diamantina', 'estado_id' => 3],
            ['nome' => 'Mariana', 'estado_id' => 3],

            // Bahia
            ['nome' => 'Salvador', 'estado_id' => 4],
            ['nome' => 'Porto Seguro', 'estado_id' => 4],
            ['nome' => 'Morro de São Paulo', 'estado_id' => 4],
            ['nome' => 'Lençóis', 'estado_id' => 4],
            ['nome' => 'Trancoso', 'estado_id' => 4],

            // Parana
            ['nome' => 'Curitiba', 'estado_id' => 5],
            ['nome' => 'Foz do Iguaçu', 'estado_id' => 5],
            ['nome' => 'Morretes', 'estado_id' => 5],
            ['nome' => 'Ilha do Mel', 'estado_id' => 5],
            ['nome' => 'Londrina', 'estado_id' => 5],

            // EUA
            // California
            ['nome' => 'Los Angeles', 'estado_id' => 6],
            ['nome' => 'San Francisco', 'estado_id' => 6],
            ['nome' => 'San Diego', 'estado_id' => 6],
            ['nome' => 'Santa Monica', 'estado_id' => 6],
            ['nome' => 'Monterey', 'estado_id' => 6],

            // Texas
            ['nome' => 'Austin', 'estado_id' => 7],
            ['nome' => 'Houston', 'estado_id' => 7],
            ['nome' => 'San Antonio', 'estado_id' => 7],
            ['nome' => 'Dallas', 'estado_id' => 7],
            ['nome' => 'Galveston', 'estado_id' => 7],

            // Nova York
            ['nome' => 'Nova York', 'estado_id' => 8],
            ['nome' => 'Brooklyn', 'estado_id' => 8],
            ['nome' => 'Albany', 'estado_id' => 8],
            ['nome' => 'Buffalo', 'estado_id' => 8],
            ['nome' => 'Niagara Falls', 'estado_id' => 8],

            // Flórida
            ['nome' => 'Miami', 'estado_id' => 9],
            ['nome' => 'Orlando', 'estado_id' => 9],
            ['nome' => 'Key West', 'estado_id' => 9],
            ['nome' => 'Fort Lauderdale', 'estado_id' => 9],
            ['nome' => 'Tampa', 'estado_id' => 9],

            // Illionis
            ['nome' => 'Chicago', 'estado_id' => 10],
            ['nome' => 'Springfield', 'estado_id' => 10],
            ['nome' => 'Galena', 'estado_id' => 10],
            ['nome' => 'Peoria', 'estado_id' => 10],
            ['nome' => 'Rockford', 'estado_id' => 10],

            // Canada
            // Ontario
            ['nome' => 'Toronto', 'estado_id' => 11],
            ['nome' => 'Ottawa', 'estado_id' => 11],
            ['nome' => 'Niagara Falls', 'estado_id' => 11],
            ['nome' => 'Kingston', 'estado_id' => 11],
            ['nome' => 'Hamilton', 'estado_id' => 11],

            // Quebec
            ['nome' => 'Quebec City', 'estado_id' => 12],
            ['nome' => 'Montreal', 'estado_id' => 12],
            ['nome' => 'Charlevoix', 'estado_id' => 12],
            ['nome' => 'Gaspé Peninsula', 'estado_id' => 12],
            ['nome' => 'Tadoussac', 'estado_id' => 12],

            // Alberta
            ['nome' => 'Calgary', 'estado_id' => 13],
            ['nome' => 'Edmonton', 'estado_id' => 13],
            ['nome' => 'Banff', 'estado_id' => 13],
            ['nome' => 'Jasper', 'estado_id' => 13],
            ['nome' => 'Canmore', 'estado_id' => 13],

            // Colúmbia Britânica
            ['nome' => 'Vancouver', 'estado_id' => 14],
            ['nome' => 'Victoria', 'estado_id' => 14],
            ['nome' => 'Whistler', 'estado_id' => 14],
            ['nome' => 'Kelowna', 'estado_id' => 14],
            ['nome' => 'Tofino', 'estado_id' => 14],

            // Manitoba
            ['nome' => 'Winnipeg', 'estado_id' => 15],
            ['nome' => 'Churchill', 'estado_id' => 15],
            ['nome' => 'Brandon', 'estado_id' => 15],
            ['nome' => 'The Pas', 'estado_id' => 15],
            ['nome' => 'Flin Flon', 'estado_id' => 15],

            // Australia
            // Queensland
            ['nome' => 'Brisbane', 'estado_id' => 16],
            ['nome' => 'Gold Coast', 'estado_id' => 16],
            ['nome' => 'Cairns', 'estado_id' => 16],
            ['nome' => 'Whitsundays', 'estado_id' => 16],
            ['nome' => 'Sunshine Coast', 'estado_id' => 16],

            // Nova Gales do Sul
            ['nome' => 'Sydney', 'estado_id' => 17],
            ['nome' => 'Byron Bay', 'estado_id' => 17],
            ['nome' => 'Blue Mountains', 'estado_id' => 17],
            ['nome' => 'Newcastle', 'estado_id' => 17],
            ['nome' => 'Port Stephens', 'estado_id' => 17],

            // Victoria
            ['nome' => 'Melbourne', 'estado_id' => 18],
            ['nome' => 'Great Ocean Road', 'estado_id' => 18],
            ['nome' => 'Phillip Island', 'estado_id' => 18],
            ['nome' => 'Mornington Peninsula', 'estado_id' => 18],
            ['nome' => 'Yarra Valley', 'estado_id' => 18],

            // Austrália Ocidental
            ['nome' => 'Perth', 'estado_id' => 19],
            ['nome' => 'Margaret River', 'estado_id' => 19],
            ['nome' => 'Broome', 'estado_id' => 19],
            ['nome' => 'Fremantle', 'estado_id' => 19],
            ['nome' => 'Rottnest Island', 'estado_id' => 19],

            // Austrália do Sul
            ['nome' => 'Adelaide', 'estado_id' => 20],
            ['nome' => 'Barossa Valley', 'estado_id' => 20],
            ['nome' => 'Kangaroo Island', 'estado_id' => 20],
            ['nome' => 'Flinders Ranges', 'estado_id' => 20],
            ['nome' => 'Victor Harbor', 'estado_id' => 20],

            // França
            // Île-de-France
            ['nome' => 'Paris', 'estado_id' => 21],
            ['nome' => 'Versalhes', 'estado_id' => 21],
            ['nome' => 'Disneyland Paris', 'estado_id' => 21],
            ['nome' => 'Fontainebleau', 'estado_id' => 21],
            ['nome' => 'Saint-Germain-en-Laye', 'estado_id' => 21],

            // Provence-Alpes-Côte d'Azur
            ['nome' => 'Marselha', 'estado_id' => 22],
            ['nome' => 'Nice', 'estado_id' => 22],
            ['nome' => 'Cannes', 'estado_id' => 22],
            ['nome' => 'Aix-en-Provence', 'estado_id' => 22],
            ['nome' => 'Saint-Tropez', 'estado_id' => 22],

            // Auvergne-Rhône-Alpes
            ['nome' => 'Lyon', 'estado_id' => 23],
            ['nome' => 'Annecy', 'estado_id' => 23],
            ['nome' => 'Grenoble', 'estado_id' => 23],
            ['nome' => 'Chamonix-Mont-Blanc', 'estado_id' => 23],
            ['nome' => 'Clermont-Ferrand', 'estado_id' => 23],

            // Occitanie
            ['nome' => 'Toulouse', 'estado_id' => 24],
            ['nome' => 'Carcassonne', 'estado_id' => 24],
            ['nome' => 'Montpellier', 'estado_id' => 24],
            ['nome' => 'Nîmes', 'estado_id' => 24],
            ['nome' => 'Albi', 'estado_id' => 24],

            // Hauts-de-France
            ['nome' => 'Lille', 'estado_id' => 25],
            ['nome' => 'Amiens', 'estado_id' => 25],
            ['nome' => 'Arras', 'estado_id' => 25],
            ['nome' => 'Dunkirk', 'estado_id' => 25],
            ['nome' => 'Chantilly', 'estado_id' => 25],
        ];

        Cidade::insert($cidades);
    }
}
