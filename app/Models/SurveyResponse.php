<?php
// app/Models/SurveyResponse.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

class SurveyResponse extends Model
{
    protected $fillable = ['lulusan_id', 'stakeholder_id', 'question_id', 'answer'];

    protected static function booted()
    {
        static::creating(function ($model) {
            if ($model->lulusan_id && $model->stakeholder_id) {
                throw new InvalidArgumentException('SurveyResponse cannot have both lulusan_id and stakeholder_id.');
            }
            if (!$model->lulusan_id && !$model->stakeholder_id) {
                throw new InvalidArgumentException('SurveyResponse must have either lulusan_id or stakeholder_id.');
            }
        });
    }

    public function lulusan()
    {
        return $this->belongsTo(Alumni::class, 'lulusan_id');
    }

    public function stakeholder()
    {
        return $this->belongsTo(Stakeholder::class, 'stakeholder_id');
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}