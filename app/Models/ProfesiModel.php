<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfesiModel extends Model
{
    protected $table = 'profesi'; // Nama tabel di database
    protected $primaryKey = 'id';
    public $timestamps = true;

    // Kolom yang bisa diisi secara mass-assignment
    protected $fillable = [
        'category_id',
        'profesi',
    ];

    // Relasi: Profesi milik satu Category
    public function category()
    {
        return $this->belongsTo(KategoriModel::class, 'category_id');
    }

    public function formlulusan()
    {
        return $this->belongsTo(FormlulusanModel::class, 'profession_id');
    }


}
