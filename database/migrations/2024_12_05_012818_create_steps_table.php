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
        Schema::create('steps', function (Blueprint $table) {
            $table->id();
            $table->string('step_name');  // Nombre del paso
            $table->enum('step_type', ['input', 'menu', 'action']);  // Tipo de paso
            $table->text('prompt')->nullable();  // Pregunta o mensaje del bot
            $table->foreignId('next_step')->nullable()->constrained('steps')->onDelete('set null');  // Paso siguiente
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('steps');
    }
};
