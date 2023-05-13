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
        Schema::create('estado', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('uf')->unique();

            //Parte da chave estrangeira da tabela Pais p/ Estado
            //Depois preciso alterar para que não seja possivel pais_id ser Null
            $table->unsignedBigInteger('pais_id');//->nullable();
            $table->foreign('pais_id')
                            ->references('id')
                            ->on('pais');
            //$table->foreignId('pais_id')->constrained();
            //$table->foreign('pais_id')->references('id')->on('pais');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estado');
    }
};
