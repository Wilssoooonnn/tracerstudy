<?php
// app/Models/Respon.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Respon extends Model
{
    use HasFactory;

    // Table name (optional if it follows Laravel's convention)
    protected $table = 'respon';

    // Fillable fields (columns that can be mass-assigned)
    protected $fillable = ['pertanyaan_id', 'respon', 'stakeholder_id'];

    // Define relationships
    public function pertanyaan()
    {
        return $this->belongsTo(PertanyaanModel::class, 'pertanyaan_id');
    }

    public function stakeholder()
    {
        return $this->belongsTo(StakeholderModel::class, 'stakeholder_id');
    }
}
