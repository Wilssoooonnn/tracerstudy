<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProgramsModel;

class LulusanModel extends Model
{
    protected $table = 'data_alumni';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = ['NIM', 'nama', 'tanggal_lulus', 'programs_id'];

    // Contoh relasi ke Program Studi (jika ada tabel relasi program)
    public function program()
    {
        return $this->belongsTo(ProgramsModel::class, 'programs_id', 'id');
    }

    public function stakeholder()
    {
        return $this->belongsTo(StakeholderModel::class, 'alumni_id');
    }

    public function formlulusan()
    {
        return $this->belongsTo(FormlulusanModel::class, 'alumni_id');
    }
}