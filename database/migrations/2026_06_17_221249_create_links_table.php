<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trainer_id')->constrained()->cascadeOnDelete();
            $table->string('label');
            $table->string('url');
            $table->string('icon')->nullable();   // chave do componente x-icon
            $table->unsignedSmallInteger('sort')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('links');
    }
};
