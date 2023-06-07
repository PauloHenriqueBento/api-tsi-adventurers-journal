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
        Schema::create('user_modalidade', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('Users_id')->unsigned();
            $table->unsignedBigInteger('modalidades_id')->unsigned();

            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('modalidades_id')->references('id')->on('modalidades')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_modalidade');
    }
};
