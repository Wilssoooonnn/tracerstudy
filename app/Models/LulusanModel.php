<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProgramsModel;
use App\Models\StakeholderModel;
use App\Models\FormlulusanModel;
use App\Models\TracerRecordModel;

class LulusanModel extends Model
{
    protected $table = 'data_alumni';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'NIM',
        'nama',
        'tanggal_lulus',
        'programs_id',
        'nohp',
        'email',
        'tanggal_pertama_kerja',
        'instansi_id',
        'skala_id',
        'kategori_id',
        'profesi_id',
        'token',
        'token_expires_at'
    ];

    public function program()
    {
        return $this->belongsTo(ProgramsModel::class, 'programs_id', 'id');
    }

    public function stakeholder()
    {
        return $this->hasOne(StakeholderModel::class, 'alumni_id', 'id');
    }

    public function formlulusan()
    {
        return $this->hasOne(FormlulusanModel::class, 'alumni_id', 'id');
    }

    public function tracerRecord()
    {
        return $this->hasOne(TracerRecordModel::class, 'alumni_id', 'id');
    }
}
