<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TracerRecordModel extends Model
{
    use HasFactory;

    protected $table = 'tracer_record'; // nama tabel

    protected $fillable = [
        'alumni_id',
        'first_job_date',
        'current_instansi_start_date',
        'instansi_type',
        'instansi_name',
        'instansi_scale',
        'instansi_location',
        'category_profession',
        'profession_id',
        'nama_atasan',
        'jabatan',
        'no_hp',
        'email',
    ];

    public $timestamps = true;

    public function data_alumni()
    {
        return $this->belongsTo(LulusanModel::class, 'alumni_id', 'id');
    }

    public function instansi()
    {
        return $this->belongsTo(InstansiModel::class, 'instansi_type');
    }

    public function skala()
    {
        return $this->belongsTo(SkalaModel::class, 'instansi_scale');
    }

    public function category()
    {
        return $this->belongsTo(KategoriModel::class, 'category_profession');
    }

    public function profesi()
    {
        return $this->belongsTo(ProfesiModel::class, 'profession_id');
    }


}
