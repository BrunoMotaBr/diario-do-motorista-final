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
        Schema::create('registro_trabalhos', function (Blueprint $table) {

            $table->id();

            // usuário logado
            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');

            $table->date('dia');

            // ganhos
            $table->decimal('valor_uber', 10, 2)->default(0);
            $table->decimal('valor_99', 10, 2)->default(0);
            $table->decimal('valor_indrive', 10, 2)->default(0);
            $table->decimal('valor_particular', 10, 2)->default(0);

            // km e combustível
            $table->integer('km');

            $table->decimal('litros', 10, 2);

            $table->decimal('valor_por_litro', 10, 2);

            $table->decimal('total_combustivel', 10, 2);

            // horas trabalhadas
            $table->integer('horas_trabalhadas');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registro_trabalhos');
    }
};
