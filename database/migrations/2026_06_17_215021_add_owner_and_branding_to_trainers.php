<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('trainers', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('id')->constrained()->nullOnDelete();
            $table->string('brand_name')->nullable()->after('name');   // marca exibida no cabeçalho do perfil
            $table->string('logo_path')->nullable()->after('about_photo');
        });
    }

    public function down(): void
    {
        Schema::table('trainers', function (Blueprint $table) {
            $table->dropConstrainedForeignId('user_id');
            $table->dropColumn(['brand_name', 'logo_path']);
        });
    }
};
