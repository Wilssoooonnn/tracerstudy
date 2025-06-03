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
            $table->foreignId('pertanyaan_id')->constrained()->onDelete('cascade');
            $table->foreignId('stakeholder_id')->constrained()->onDelete('cascade');
            $table->string('respon');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('respon');
    }
};