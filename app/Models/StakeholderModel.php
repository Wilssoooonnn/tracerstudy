<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StakeholderModel extends Model
{
    use HasFactory;
    protected $table = 'data_stakeholder'; // nama tabel sesuai database

    protected $fillable = [
        'nama',
        'instansi',
        'jabatan',
        'email',
        'alumni_id',
    ];

    public function lulusan()
    {
         return $this->belongsTo(LulusanModel::class, 'alumni_id', 'id');
    }

        public function respon()
    {
        return $this->hasMany(ResponsModel::class, 'stakeholder_id', 'id');
    }
}
