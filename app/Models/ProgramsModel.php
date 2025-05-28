<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\LulusanModel;

class ProgramsModel extends Model
{
    protected $table = 'programs'; // nama tabel sesuai database

    protected $fillable = [
        'program_studi',
        'jurusan',
    ];

    public $timestamps = true; // karena kolom created_at dan updated_at bernilai NULL

    // Relasi ke data alumni (jika satu program memiliki banyak alumni)
    public function lulusan()
    {
        return $this->hasMany(LulusanModel::class, 'programs_id');
    }
}
