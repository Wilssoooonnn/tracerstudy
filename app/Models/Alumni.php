<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumni extends Model
{
    use HasFactory;

    protected $table = 'alumni';

    protected $fillable = [
        'program_studi_id',
        'tahun_lulus',
        'nama',
        'no_hp',
        'email',
        'tanggal_pertama_kerja',
        'tanggal_mulai_kerja_instansi',
        'instansi_id',
        'skala',
        'lokasi_instansi',
        'kategori_profesi_id',
        'profesi',
        'nama_atasan_langsung',
        'jabatan_atasan_langsung',
        'no_hp_atasan_langsung',
        'email_atasan_langsung'
    ];

    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class);
    }

    public function instansi()
    {
        return $this->belongsTo(Instansi::class);
    }

    public function kategoriProfesi()
    {
        return $this->belongsTo(KategoriProfesi::class);
    }
}
