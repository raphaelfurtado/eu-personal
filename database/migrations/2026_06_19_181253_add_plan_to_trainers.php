<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('trainers', function (Blueprint $table) {
            $table->string('plan', 20)->default('free')->after('show_calculator');  // free | pro | studio
            $table->timestamp('plan_until')->nullable()->after('plan');
        });
    }

    public function down(): void
    {
        Schema::table('trainers', function (Blueprint $table) {
            $table->dropColumn(['plan', 'plan_until']);
        });
    }
};
