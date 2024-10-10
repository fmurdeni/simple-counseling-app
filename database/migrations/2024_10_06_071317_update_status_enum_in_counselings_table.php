<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('counselings', function (Blueprint $table) {
            $table->enum('status', ['pending', 'approved', 'rejected', 'ongoing', 'completed'])->default('pending')->change();
            $table->text('sentiment')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('counselings', function (Blueprint $table) {
            $table->dropColumn('sentiment');
        });
    }
    
};
