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
        Schema::create('data_alumni', function (Blueprint $table) {
            $table->id();  // program_id INT AUTO_INCREMENT PRIMARY KEY
            $table->unsignedBigInteger('programs_id')->index();
            $table->string('NIM')->unique();
            $table->string('nama');
            $table->string('nohp')->nullable();
            $table->string('email')->nullable();
            $table->date('tanggal_lulus');
            $table->timestamps();  // created_at and updated_at

            // mendefinisikan foreign key pada kolom programs_id  mengacu pada kolom id di programs
            $table->foreign('programs_id')->references('id')->on('programs');
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
