<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SkalaModel extends Model
{
    protected $table = 'skala'; // nama tabel di database
    protected $primaryKey = 'id'; // kolom primary key

    public $timestamps = false; // karena kolom created_at dan updated_at tidak digunakan

    protected $fillable = [
        'skala_kode',
        'skala_nama',
    ];

    // Jika ingin relasi ke lulusan (optional, hanya jika perlu)
    public function lulusan()
    {
        return $this->hasMany(LulusanModel::class, 'skala_id');
    }
}
