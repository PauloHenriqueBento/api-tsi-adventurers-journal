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
            $table->unsignedBigInteger('idViajante');
            $table->unsignedBigInteger('idGuia');
            $table->unsignedBigInteger('idModalidade');
            $table->integer('nota')->nullable();
            $table->text('comentario')->nullable();
            $table->date('data');
            $table->timestamps();

            $table->foreign('idViajante')->references('id')->on('users');
            $table->foreign('idGuia')->references('id')->on('users');
            $table->foreign('idModalidade')->references('id')->on('modalidades');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('atividades');
    }
};
