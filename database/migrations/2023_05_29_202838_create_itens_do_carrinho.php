<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('itens_do_carrinho', function (Blueprint $table) {
            $table->id();
            //$table->qtdPessoa();
            $table->unsignedBigInteger('idViajante');
            $table->foreign('idViajante')
                            ->references('id')
                            ->on('users');
            $table->unsignedBigInteger('idAtividade');
            $table->foreign('idAtividade')
                            ->references('id')
                            ->on('atividades');
            $table->integer('qtdPessoa');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('itens_do_carrinho');
    }
};
