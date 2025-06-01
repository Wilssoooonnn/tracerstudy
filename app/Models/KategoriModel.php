<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriModel extends Model
{
    protected $table = 'category';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = ['category', 'name'];

    public function formlulusan()
    {
        return $this->belongsTo(FormlulusanModel::class, 'category_profession');
    }
    
}