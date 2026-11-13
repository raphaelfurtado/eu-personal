<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('trainers', function (Blueprint $table) {
            $table->string('bio_bg_image')->nullable()->after('logo_path'); // foto de fundo da /bio
            $table->string('tiktok')->nullable()->after('instagram');
            $table->string('youtube')->nullable()->after('tiktok');
            $table->string('twitter')->nullable()->after('youtube');        // X
        });
    }

    public function down(): void
    {
        Schema::table('trainers', function (Blueprint $table) {
            $table->dropColumn(['bio_bg_image', 'tiktok', 'youtube', 'twitter']);
        });
    }
};
