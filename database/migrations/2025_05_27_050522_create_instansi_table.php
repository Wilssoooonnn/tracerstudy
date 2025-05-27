<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstansiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instansi', function (Blueprint $table) {
            $table->id();
            $table->string('nama_instansi')->unique();
            $table->string('jenis_instansi');
            $table->string('lokasi_instansi');
            $table->string('skala'); // Skala instansi (misal: nasional, internasional, lokal)
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
        Schema::dropIfExists('instansi');
    }
}
