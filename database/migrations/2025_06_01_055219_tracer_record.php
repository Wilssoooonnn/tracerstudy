<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('tracer_record', function (Blueprint $table) {
            $table->id(); // record_id

            // Alumni
            $table->unsignedBigInteger('alumni_id')->index(); // indexing untuk ForeignKey

            // Tanggal kerja
            $table->date('first_job_date');
            $table->date('current_instansi_start_date');

            // Instansi
            $table->unsignedBigInteger('instansi_type')->index(); // indexing untuk ForeignKey
            $table->string('instansi_name');
            $table->unsignedBigInteger('instansi_scale')->index(); // indexing untuk ForeignKey
            $table->string('instansi_location');

            // Profesi
            $table->unsignedBigInteger('category_profession')->index(); // indexing untuk ForeignKey
            $table->unsignedBigInteger('profession_id')->index(); // indexing untuk ForeignKey

            // Data atasan 
            $table->string('nama_atasan');
            $table->string('jabatan');
            $table->string('no_hp');
            $table->string('email');

            $table->timestamps();

            // Mendefinisikan Foreign Key 
            $table->foreign('alumni_id')->references('id')->on('data_alumni');
            $table->foreign('instansi_type')->references('id')->on('instansi');
            $table->foreign('instansi_scale')->references('id')->on('skala');
            $table->foreign('category_profession')->references('id')->on('category');
            $table->foreign('profession_id')->references('id')->on('profesi');
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
