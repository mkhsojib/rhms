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
        // First, we need to modify the column to allow NULL temporarily
        \DB::statement("ALTER TABLE appointments MODIFY status ENUM('pending', 'approved', 'rejected', 'completed') NULL");
        
        // Then update all existing 'cancelled' statuses to NULL to avoid data loss
        \DB::table('appointments')->where('status', 'cancelled')->update(['status' => null]);
        
        // Now modify the column to include 'cancelled' in the ENUM
        \DB::statement("ALTER TABLE appointments MODIFY status ENUM('pending', 'approved', 'rejected', 'completed', 'cancelled') NOT NULL DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // First, update any 'cancelled' statuses to 'rejected' before removing from ENUM
        \DB::table('appointments')->where('status', 'cancelled')->update(['status' => 'rejected']);
        
        // Then modify the column to remove 'cancelled' from the ENUM
        \DB::statement("ALTER TABLE appointments MODIFY status ENUM('pending', 'approved', 'rejected', 'completed') NOT NULL DEFAULT 'pending'");
    }
};
