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
        Schema::create('contact_form_submissions', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('email');
            $table->string('phone');
            $table->text('message');
            $table->enum('status', ['new', 'read', 'replied', 'archived'])->default('new');
            $table->text('admin_notes')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamp('replied_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_form_submissions');
    }
};
