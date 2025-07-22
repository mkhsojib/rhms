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
            // Add specific fields for Hijama Head Cupping pricing
            $table->decimal('head_cupping_fee', 8, 2)->nullable()->after('session_type_max_duration');
            $table->integer('head_cupping_min_duration')->nullable()->after('head_cupping_fee');
            $table->integer('head_cupping_max_duration')->nullable()->after('head_cupping_min_duration');
            
            // Add specific fields for Hijama Body Cupping pricing
            $table->decimal('body_cupping_fee', 8, 2)->nullable()->after('head_cupping_max_duration');
            $table->integer('body_cupping_min_duration')->nullable()->after('body_cupping_fee');
            $table->integer('body_cupping_max_duration')->nullable()->after('body_cupping_min_duration');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn([
                'head_cupping_fee',
                'head_cupping_min_duration',
                'head_cupping_max_duration',
                'body_cupping_fee',
                'body_cupping_min_duration',
                'body_cupping_max_duration',
            ]);
        });
    }
};
