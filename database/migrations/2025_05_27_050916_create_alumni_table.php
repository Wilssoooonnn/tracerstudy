<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlumniTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alumni', function (Blueprint $table) {
            $table->id();
            // Make foreign key nullable
            $table->foreignId('program_studi_id')->nullable()->constrained('program_studi')->onDelete('set null');
            $table->year('tahun_lulus');
            $table->string('nama');
            $table->string('nim');
            $table->string('jenis_kelamin');
            $table->string('no_hp');
            $table->string('email');
            $table->date('tanggal_pertama_kerja');
            $table->date('tanggal_mulai_kerja_instansi');
            $table->foreignId('instansi_id')->nullable()->constrained('instansi')->onDelete('set null');
            $table->string('skala');
            $table->string('lokasi_instansi');
            $table->foreignId('kategori_profesi_id')->nullable()->constrained('kategori_profesi')->onDelete('set null');
            $table->string('profesi');
            $table->string('nama_atasan_langsung');
            $table->string('jabatan_atasan_langsung');
            $table->string('no_hp_atasan_langsung');
            $table->string('email_atasan_langsung');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alumni');
    }
}
