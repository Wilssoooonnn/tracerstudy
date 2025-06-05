<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('data_alumni', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('programs_id')->index();
            $table->string('NIM')->unique();
            $table->string('nama');
            $table->string('nohp')->nullable();
            $table->string('email')->nullable();
            $table->date('tanggal_lulus');
            $table->string('token')->nullable();
            $table->timestamp('token_expires_at')->nullable();
            $table->timestamps();

            $table->foreign('programs_id')->references('id')->on('programs')->onDelete('restrict');
        });
    }

    public function down()
    {
        Schema::dropIfExists('data_alumni');
    }
};