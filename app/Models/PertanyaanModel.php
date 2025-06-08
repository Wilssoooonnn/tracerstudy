<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PertanyaanModel extends Model
{
    use HasFactory;

    protected $table = 'pertanyaan';

    protected $primaryKey = 'id';

    protected $fillable = ['pertanyaan', 'question_type']; // Added question_type

    public $timestamps = false;

    
    public function respon()
    {
        return $this->hasMany(ResponsModel::class, 'pertanyaan_id', 'id');
    }

}
