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
        Schema::create('raqi_monthly_availabilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('practitioner_id')->constrained('users')->onDelete('cascade');
            $table->date('availability_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('slot_duration')->default(30)->comment('Duration in minutes');
            $table->boolean('is_available')->default(true);
            $table->text('notes')->nullable();
            $table->timestamps();
            
            // Add unique constraint to prevent duplicate entries for the same date and practitioner
            $table->unique(['practitioner_id', 'availability_date'], 'raqi_avail_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('raqi_monthly_availabilities');
    }
};
