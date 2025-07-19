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
        Schema::create('treatments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appointment_id')->constrained()->onDelete('cascade');
            $table->foreignId('practitioner_id')->constrained('users')->onDelete('cascade');
            $table->enum('treatment_type', ['ruqyah', 'hijama', 'both'])->default('ruqyah');
            $table->date('treatment_date');
            $table->enum('status', ['scheduled', 'in_progress', 'completed'])->default('scheduled');
            $table->text('notes')->nullable();
            $table->text('prescription')->nullable(); // For ruqyah
            $table->text('aftercare')->nullable(); // For hijama
            $table->integer('duration')->nullable(); // Duration in minutes
            $table->decimal('cost', 8, 2)->nullable(); // Treatment cost
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('treatments');
    }
}; 