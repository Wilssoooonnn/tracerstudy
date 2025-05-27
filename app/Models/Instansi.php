<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instansi extends Model
{
    use HasFactory;

    // Tabel yang digunakan oleh model
    protected $table = 'instansi';

    // Kolom yang bisa diisi
    protected $fillable = [
        'nama_instansi',
        'jenis_instansi',
        'lokasi_instansi',
        'skala',
    ];

    // Relasi dengan alumni
    public function alumni()
    {
        return $this->hasMany(Alumni::class);
    }
}
