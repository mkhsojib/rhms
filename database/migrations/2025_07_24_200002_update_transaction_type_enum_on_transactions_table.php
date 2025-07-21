<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        DB::statement("ALTER TABLE transactions MODIFY transaction_type ENUM('deposit', 'withdrawal', 'transfer', 'cash_in', 'cash_out', 'payment')");
    }

    public function down()
    {
        DB::statement("ALTER TABLE transactions MODIFY transaction_type ENUM('deposit', 'withdrawal', 'transfer', 'cash_in', 'cash_out')");
    }
}; 