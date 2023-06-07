<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use ModalidadeSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call(PaisesSeeder::class);
        $this->call(EstadosSeeder::class);
        $this->call(CidadeSeeder::class);
        $this->call(ModalidadeSeeder::class);
        $this->call(AssinaturaSeeder::class);
        $this->call(UsersTableSeeder::class);
    }
}
