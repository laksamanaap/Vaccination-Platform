<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{

    protected $table = 'consultations';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public $timestamps = false;

    public function doctor()
    {
        return $this->belongsTo(Medicals::class, 'doctor_id');
    }

    use HasFactory;
}
