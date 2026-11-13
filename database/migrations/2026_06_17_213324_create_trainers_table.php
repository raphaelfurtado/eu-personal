<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trainers', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('role')->default('Personal Trainer');
            $table->string('city')->nullable();
            $table->string('state', 2)->nullable();
            $table->string('cref')->nullable();
            $table->boolean('verified')->default(true);

            // Hero
            $table->text('tagline')->nullable();              // parágrafo abaixo do nome
            $table->decimal('rating', 2, 1)->nullable();      // 4.9
            $table->unsignedInteger('rating_count')->default(0);
            $table->unsignedSmallInteger('years')->default(0);
            $table->string('students')->nullable();           // "300+"
            $table->string('goal_rate')->nullable();          // "94%"
            $table->string('sessions')->nullable();           // "12k+"

            // Sobre
            $table->string('about_title')->nullable();
            $table->text('about_p1')->nullable();
            $table->text('about_p2')->nullable();
            $table->json('about_features')->nullable();       // [{icon,title,body}]
            $table->json('stats')->nullable();                // [{num,label}]

            // Contato
            $table->string('whatsapp')->nullable();           // só dígitos, ex 5511999990000
            $table->string('whatsapp_label')->nullable();     // "(11) 9 9999-0000"
            $table->string('instagram')->nullable();          // "@marina.lacerda.treina"
            $table->string('studio_name')->nullable();
            $table->string('studio_location')->nullable();
            $table->string('hours')->nullable();
            $table->string('response_time')->nullable();

            // Aparência / imagens
            $table->string('accent_color')->default('#d8a32e');
            $table->boolean('show_stats')->default(true);
            $table->string('hero_photo')->nullable();
            $table->string('about_photo')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trainers');
    }
};
