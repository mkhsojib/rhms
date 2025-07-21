<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->decimal('head_cup_price', 10, 2)->nullable();
            $table->integer('head_cup_qty')->nullable();
            $table->decimal('body_cup_price', 10, 2)->nullable();
            $table->integer('body_cup_qty')->nullable();
        });
    }

    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['head_cup_price', 'head_cup_qty', 'body_cup_price', 'body_cup_qty']);
        });
    }
}; 