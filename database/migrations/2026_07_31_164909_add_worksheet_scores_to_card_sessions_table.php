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
        Schema::table('card_sessions', function (Blueprint $table) {
            $table->integer('profesi_1_score')->nullable();
            $table->integer('profesi_2_score')->nullable();
            $table->integer('profesi_3_score')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('card_sessions', function (Blueprint $table) {
            $table->dropColumn(['profesi_1_score', 'profesi_2_score', 'profesi_3_score']);
        });
    }
};
