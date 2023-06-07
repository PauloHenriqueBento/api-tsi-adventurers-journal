<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            $user = DB::table('users')->insertGetId([
                'name' => $faker->name,
                'data_nascimento' => $faker->date('Y-m-d', '-18 years'),
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('12345678'),
                'id_cidade' => $faker->numberBetween(1, 25),
                'telefone' => $faker->numerify('###########'),
                'bio' => $faker->paragraph
            ]);

            $modalidades = $faker->randomElements(range(1, 16), $faker->numberBetween(1, 5));

            foreach ($modalidades as $modalidade) {
                DB::table('user_modalidade')->insert([
                    'Users_id' => $user,
                    'modalidades_id' => $modalidade
                ]);
            }

            $imagePath = 'profile_photos/' . ($i + 1) . '.jpg';
            $destinationPath = $this->copyImage($imagePath);
            DB::table('users')->where('id', $user)->update(['profile_photo_path' => $destinationPath]);
        }
    }
    private function copyImage($fileName)
    {
        $sourcePath = public_path($fileName);
        $destinationPath = storage_path('app/public/' . $fileName);

        // Criar diretório de destino, se não existir
        File::ensureDirectoryExists(dirname($destinationPath));

        // Copiar a imagem para o diretório de destino
        File::copy($sourcePath, $destinationPath);

        return $fileName;
    }
}
