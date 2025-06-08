<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_respon_table.php
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
        Schema::create('respon', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pertanyaan_id');
            $table->text('respon');
            $table->unsignedBigInteger('stakeholder_id');
            $table->timestamps();

            // Adding foreign key constraints if necessary
            $table->foreign('pertanyaan_id')->references('id')->on('pertanyaan')->onDelete('cascade');
            $table->foreign('stakeholder_id')->references('id')->on('data_stakeholder')->onDelete('cascade');
        });

    }

    public function down()
    {
        Schema::dropIfExists('respon');
    }
};