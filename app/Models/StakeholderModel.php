<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StakeholderModel extends Model
{
    protected $table = 'data_stakeholder'; // Explicitly set table name
    protected $primaryKey = 'id';
    public $timestamps = true;

    // Fields that can be mass-assigned
    protected $fillable = [
        'nama',
        'instansi',
        'jabatan',
        'email',
        'alumni_id',
        'token',
        'is_used',
        'token_expires_at',
    ];

    // Relasi: Stakeholder milik satu Alumni
    public function alumni()
    {
        return $this->belongsTo(LulusanModel::class, 'alumni_id');
    }
}