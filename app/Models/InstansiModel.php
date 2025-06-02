<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstansiModel extends Model
{
    protected $table = 'instansi';   // Nama tabel
    protected $primaryKey = 'id';    // Primary key tabel

    // Jika primary key bukan auto increment atau tipe non-integer,
    // tambahkan properti ini (karena instansi_kode seperti PT bukan auto increment)
    public $incrementing = true;  // kalau id auto increment (default true)
    protected $keyType = 'int';   // tipe primary key (int)

    // Jika kamu ingin assignable field yang boleh diisi (mass assignable)
    protected $fillable = [
        'instansi_kode',
        'instansi_nama',
    ];

    // Jika menggunakan timestamp created_at dan updated_at
    public $timestamps = true;

    public function formlulusan()
    {
        return $this->belongsTo(FormlulusanModel::class, 'instansi_type');
    }
}
