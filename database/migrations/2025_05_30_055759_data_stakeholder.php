<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_stakeholder', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('instansi');
            $table->string('jabatan');
            $table->string('email');
            $table->unsignedBigInteger('alumni_id');
            $table->string('token')->unique();
            $table->boolean('is_used')->default(false);
            $table->timestamp('token_expires_at')->nullable();
            $table->timestamps();

            $table->foreign('alumni_id')->references('id')->on('data_alumni')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
