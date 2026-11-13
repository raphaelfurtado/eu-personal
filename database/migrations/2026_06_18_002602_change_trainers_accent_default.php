<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('trainers', function (Blueprint $table) {
            // accent_color agora é a COR PRINCIPAL/da marca (antes era o dourado de acento)
            $table->string('accent_color')->default('#1f4733')->change();
        });
    }

    public function down(): void
    {
        Schema::table('trainers', function (Blueprint $table) {
            $table->string('accent_color')->default('#d8a32e')->change();
        });
    }
};
