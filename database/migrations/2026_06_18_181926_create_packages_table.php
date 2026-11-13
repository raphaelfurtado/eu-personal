<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trainer_id')->constrained()->cascadeOnDelete();
            $table->string('name');                 // ex.: "Online / Consultoria"
            $table->string('price')->nullable();    // ex.: "R$ 39" ou "Sob consulta" (texto livre)
            $table->string('period')->nullable();   // ex.: "/mês"
            $table->json('items')->nullable();      // o que inclui (lista)
            $table->boolean('featured')->default(false);
            $table->unsignedSmallInteger('sort')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
