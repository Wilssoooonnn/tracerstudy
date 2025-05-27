<?php
// app/Models/Stakeholder.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stakeholder extends Model
{
    protected $table = 'stakeholders';
    protected $fillable = ['name', 'email', 'survey_token', 'survey_completed'];

    protected $casts = [
        'survey_completed' => 'boolean',
    ];

    public function surveyResponses()
    {
        return $this->hasMany(SurveyResponse::class, 'stakeholder_id');
    }
}