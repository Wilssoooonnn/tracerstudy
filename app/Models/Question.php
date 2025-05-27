<?php
// app/Models/Question.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['content', 'type', 'options', 'is_required', 'survey_type'];

    protected $casts = [
        'options' => 'array',
        'is_required' => 'boolean',
    ];

    public function surveyResponses()
    {
        return $this->hasMany(SurveyResponse::class);
    }
}