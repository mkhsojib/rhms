<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cash_flows', function (Blueprint $table) {
            $table->id();
            $table->date('transaction_date');
            $table->string('transaction_no')->nullable();
            $table->enum('type', ['cash_in', 'cash_out']);
            $table->string('customer_name')->nullable();
            $table->string('service_type')->nullable();
            $table->string('category')->nullable();
            $table->decimal('amount', 12, 2);
            $table->string('payment_method');
            $table->string('bank_account_id');
            $table->string('paid_to')->nullable();
            $table->string('handled_by')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('transaction_id')->nullable()->constrained('transactions')->nullOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('cash_flows');
    }
}; 