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
        Schema::create('atividades', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('IdGuia');
            $table->decimal('preco', 8, 2);
            $table->unsignedBigInteger('idCidade');
            $table->string('Titulo');
            $table->text('Descricao');
            $table->dateTime('DataTime');
            $table->integer('IdadeMinima')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
