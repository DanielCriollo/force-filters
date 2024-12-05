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
        Schema::create('wpp_users', function (Blueprint $table) {
            $table->id();
            $table->string('whatsapp_id')->unique();  // ID de WhatsApp
            $table->string('name')->nullable();       // Nombre del usuario
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wpp_users');
    }
};
