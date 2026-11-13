<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('certifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trainer_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('issuer')->nullable();
            $table->string('year')->nullable();   // "2016" ou "Ativo"
            $table->unsignedSmallInteger('sort')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certifications');
    }
};
