<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('transaction_no')->nullable()->after('reference_number');
            $table->string('customer_name')->nullable()->after('transaction_no');
            $table->string('service_type')->nullable()->after('customer_name');
            $table->string('category')->nullable()->after('service_type');
            $table->string('paid_to')->nullable()->after('category');
            $table->string('handled_by')->nullable()->after('paid_to');
            $table->text('notes')->nullable()->after('handled_by');
        });
    }
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['transaction_no', 'customer_name', 'service_type', 'category', 'paid_to', 'handled_by', 'notes']);
        });
    }
}; 