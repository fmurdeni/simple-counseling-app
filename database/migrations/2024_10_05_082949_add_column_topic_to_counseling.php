<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('counselings', function (Blueprint $table) {
            $table->text('topic');
            $table->enum('time_preference', ['morning', 'afternoon', 'evening'])->default('morning');
            $table->enum('level', ['high', 'medium', 'low'])->default('low');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('counselings', function (Blueprint $table) {
            $table->dropColumn('topic');
            $table->dropColumn('time_preference');
            $table->dropColumn('level');
        });
    }
};
