<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trainer_id')->constrained()->cascadeOnDelete();
            $table->string('student_name');          // "Ana P., 34"
            $table->string('duration')->nullable();  // "6 meses"
            $table->string('before_photo')->nullable();
            $table->string('after_photo')->nullable();
            $table->json('tags')->nullable();        // ["−14 kg","−9% gordura"]
            $table->text('quote')->nullable();
            $table->unsignedSmallInteger('sort')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('results');
    }
};
