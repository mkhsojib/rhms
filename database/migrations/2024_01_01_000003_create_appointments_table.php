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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('appointment_no', 20)->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Patient
            $table->foreignId('practitioner_id')->constrained('users')->onDelete('cascade'); // Admin/Raqi
            $table->enum('type', ['ruqyah', 'hijama']);
            $table->unsignedBigInteger('session_type_id')->nullable();
            $table->date('appointment_date');
            $table->time('appointment_time');
            $table->text('symptoms')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected', 'completed'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('session_type_id')->references('id')->on('raqi_session_types')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
}; 