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
        Schema::create('exoneracoes_municipio', function (Blueprint $table) {
            $table->id();
            $table->string("nome");
            $table->date("data_exoneracao");
            $table->foreignId('diario_id')->constrained('diarios_municipio');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exoneracoes_municipio');
    }
};
