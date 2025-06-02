<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormlulusanModel extends Model
{
    use HasFactory;
     protected $table = 'tracer_record'; // Nama tabel di database

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

    // Relasi ke tabel alumni
    public function alumni()
    {
        return $this->belongsTo(LulusanModel::class, 'alumni_id');
    }

    // Relasi ke instansi (jenis)
    public function instansi()
    {
        return $this->belongsTo(InstansiModel::class, 'instansi_type');
    }

    // Relasi ke skala instansi
    public function skala()
    {
        return $this->belongsTo(SkalaModel::class, 'instansi_scale');
    }

    // Relasi ke kategori profesi
    public function kategori()
    {
        return $this->belongsTo(KategoriModel::class, 'category_profession');
    }

    // Relasi ke profesi
    public function profesi()
    {
        return $this->belongsTo(ProfesiModel::class, 'profession_id');
    }
}
