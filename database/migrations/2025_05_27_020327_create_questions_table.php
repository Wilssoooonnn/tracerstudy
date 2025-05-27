<?php
// database/migrations/2025_05_27_000001_create_questions_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->text('content');
            $table->enum('type', ['text', 'radio', 'checkbox'])->default('text');
            $table->json('options')->nullable(); // For radio/checkbox options
            $table->boolean('is_required')->default(true);
            $table->enum('survey_type', ['lulusan', 'penggunalulusan'])->default('lulusan'); // Differentiate survey types
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('questions');
    }
}