<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResponsModel extends Model
{
    use HasFactory;

    protected $table = 'respon';

    protected $fillable = [
        'pertanyaan_id',
        'stakeholder_id',
        'respon',
    ];

    public function pertanyaan()
    {
        return $this->belongsTo(PertanyaanModel::class, 'pertanyaan_id', 'id');
    }

    public function stakeholder()
    {
        return $this->belongsTo(StakeholderModel::class, 'stakeholder_id', 'id');
    }

    public function instansi()
    {
        return $this->belongsTo(InstansiModel::class, 'id');
    }

    public function data_alumni()
    {
        return $this->belongsTo(LulusanModel::class, 'alumni_id', 'id');
    }

}
