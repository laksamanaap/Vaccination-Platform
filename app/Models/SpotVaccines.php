<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpotVaccines extends Model
{

    protected $table = 'spot_vaccines';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public $timestamps = false;

    public function vaccine()
    {
        return $this->belongsTo(Vaccine::class, 'vaccine_id');
    }

    use HasFactory;
}
