<?php

// app/Models/Alumni.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alumni extends Model
{
    protected $table = 'alumni';
    protected $fillable = ['name', 'email', 'survey_token', 'survey_completed'];

    protected $casts = [
        'survey_completed' => 'boolean',
    ];

    public function surveyResponses()
    {
        return $this->hasMany(SurveyResponse::class, 'lulusan_id');
    }
}