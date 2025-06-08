
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
<<<<<<< HEAD
        Schema::table('data_alumni', function (Blueprint $table) {
            $table->date('tanggal_pertama_kerja')->nullable()->after('email');
            $table->unsignedBigInteger('instansi_id')->nullable()->after('tanggal_pertama_kerja');
            $table->unsignedBigInteger('skala_id')->nullable()->after('instansi_id');
            $table->unsignedBigInteger('kategori_id')->nullable()->after('skala_id');
            $table->unsignedBigInteger('profesi_id')->nullable()->after('kategori_id');

            $table->foreign('instansi_id')->references('id')->on('instansi')->onDelete('set null');
            $table->foreign('skala_id')->references('id')->on('skala')->onDelete('set null');
            $table->foreign('kategori_id')->references('id')->on('kategori')->onDelete('set null');
            $table->foreign('profesi_id')->references('id')->on('profesi')->onDelete('set null');
=======
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
>>>>>>> main
        });
    }

    public function down()
    {
<<<<<<< HEAD
        Schema::table('data_alumni', function (Blueprint $table) {
            $table->dropForeign(['instansi_id']);
            $table->dropForeign(['skala_id']);
            $table->dropForeign(['kategori_id']);
            $table->dropForeign(['profesi_id']);
            $table->dropColumn(['tanggal_pertama_kerja', 'instansi_id', 'skala_id', 'kategori_id', 'profesi_id']);
        });
=======
        Schema::dropIfExists('data_alumni');
>>>>>>> main
    }
};