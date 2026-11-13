<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('trainers', function (Blueprint $table) {
            $table->json('specialties')->nullable()->after('tagline');     // ["Emagrecimento", ...]
            $table->json('formats')->nullable()->after('specialties');     // ["Presencial","Online",...]
            $table->json('faqs')->nullable()->after('about_features');     // [{q,a}, ...]
            $table->boolean('show_calculator')->default(true)->after('show_stats');
        });
    }

    public function down(): void
    {
        Schema::table('trainers', function (Blueprint $table) {
            $table->dropColumn(['specialties', 'formats', 'faqs', 'show_calculator']);
        });
    }
};
