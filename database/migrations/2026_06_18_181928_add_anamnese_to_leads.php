<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->string('nivel')->nullable()->after('objetivo');        // iniciante/intermediário/avançado
            $table->string('frequencia')->nullable()->after('nivel');      // 2x, 3x, 4x+ por semana
            $table->string('local')->nullable()->after('frequencia');      // academia/casa/ar livre/online
            $table->text('restricoes')->nullable()->after('local');        // lesões/restrições
        });
    }

    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropColumn(['nivel', 'frequencia', 'local', 'restricoes']);
        });
    }
};
