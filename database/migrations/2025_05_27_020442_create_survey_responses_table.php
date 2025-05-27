<?php

// database/migrations/2025_05_27_020442_create_survey_responses_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveyResponsesTable extends Migration
{
    public function up()
    {
        Schema::create('survey_responses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lulusan_id')->nullable();
            $table->unsignedBigInteger('stakeholder_id')->nullable();
            $table->foreignId('question_id')->constrained('questions')->onDelete('cascade');
            $table->text('answer')->nullable();
            $table->timestamps();

            $table->foreign('lulusan_id')->references('id')->on('alumni')->onDelete('cascade');
            $table->foreign('stakeholder_id')->references('id')->on('stakeholders')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('survey_responses');
    }
}