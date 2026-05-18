<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('registro_de_gastos', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // ================= GASTO =================
            $table->string('tipo_gasto'); // manutencao, alimentacao, limpeza, etc
            $table->string('qual_gasto')->nullable(); // descrição

            $table->decimal('valor', 10, 2);

            // ================= PAGAMENTO =================
            $table->string('forma_pagamento'); // avista | parcelado
            $table->string('pagamento_tipo')->nullable(); // debito | credito

            // ================= PARCELAMENTO =================
            $table->integer('parcelas')->nullable(); // total (ex: 3)
            $table->integer('parcela_atual')->default(1); // 1/3, 2/3...
            $table->date('inicio_parcela')->nullable(); // quando começou

            // ================= DATA =================
            $table->date('dia');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registro_de_gastos');
    }
};
