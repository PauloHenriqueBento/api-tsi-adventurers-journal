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
        Schema::table('itensDoPedido', function (Blueprint $table) {
            $table->text('comentario')->nullable();
            $table->decimal('nota', 4, 1)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('itensDoPedido', function (Blueprint $table) {
            $table->dropColumn('comentario');
            $table->dropColumn('nota');
        });
    }
};
