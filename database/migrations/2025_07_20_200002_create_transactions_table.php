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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->date('transaction_date');
            $table->decimal('amount', 12, 2);
            $table->enum('transaction_type', ['deposit', 'withdrawal', 'transfer', 'cash_in', 'cash_out']);
            $table->enum('payment_method', ['cash', 'check', 'bank_transfer', 'credit_card', 'debit_card', 'online_payment', 'mobile_banking', 'other']);
            $table->string('reference_number')->nullable();
            $table->text('description')->nullable();
            $table->string('transaction_no')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('service_type')->nullable();
            $table->string('category')->nullable();
            $table->string('paid_to')->nullable();
            $table->string('handled_by')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('bank_account_id')->constrained('bank_accounts')->cascadeOnDelete();
            $table->string('related_to')->nullable();
            $table->unsignedBigInteger('related_id')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
}; 