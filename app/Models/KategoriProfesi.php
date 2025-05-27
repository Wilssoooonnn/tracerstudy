<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriProfesi extends Model
{
    use HasFactory;

    // Tabel yang digunakan oleh model
    protected $table = 'kategori_profesi';

    // Kolom yang bisa diisi
    protected $fillable = [
        'kategori_profesi',
    ];

    // Relasi dengan alumni
    public function alumni()
    {
        return $this->hasMany(Alumni::class);
    }
}
