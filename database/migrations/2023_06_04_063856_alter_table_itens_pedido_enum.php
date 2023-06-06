<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE itensdopedido MODIFY FormaPag ENUM('Boleto', 'PIX', 'Cartão') NOT NULL");
        DB::statement("ALTER TABLE itensdopedido MODIFY status ENUM('pendente', 'aprovado', 'cancelado', 'entregue') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE itensdopedido MODIFY FormaPag VARCHAR(255) NOT NULL");
        DB::statement("ALTER TABLE itensdopedido MODIFY status VARCHAR(255) NOT NULL");
    }
};
