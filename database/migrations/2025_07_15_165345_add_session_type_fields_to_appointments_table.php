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
        Schema::table('appointments', function (Blueprint $table) {
            $table->string('session_type_name')->nullable();
            $table->decimal('session_type_fee', 8, 2)->nullable();
            $table->integer('session_type_min_duration')->nullable();
            $table->integer('session_type_max_duration')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn([
                'session_type_name',
                'session_type_fee',
                'session_type_min_duration',
                'session_type_max_duration',
            ]);
        });
    }
};
