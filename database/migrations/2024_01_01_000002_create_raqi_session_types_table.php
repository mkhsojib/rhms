<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('raqi_session_types', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('practitioner_id');
            $table->string('type'); // diagnosis, short, long
            $table->integer('fee');
            $table->integer('min_duration'); // in minutes
            $table->integer('max_duration'); // in minutes
            $table->timestamps();

            $table->foreign('practitioner_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('raqi_session_types');
    }
}; 