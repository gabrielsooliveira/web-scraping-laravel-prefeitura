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
        Schema::create('processos_diarios_tcm', function (Blueprint $table) {
            $table->foreignId('diario_tcm_id')->constrained('diarios_tcm');
            $table->foreignId('processo_id')->constrained('processos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diarios_tcm_processo');
    }
};
