<?php

namespace App\Models;

use App\Models\User;
use App\Models\Spots;
use App\Models\Vaccine;
use App\Models\Medicals;
use App\Models\Regional;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vacination extends Model
{

    protected $table = 'vaccinations';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public $timestamps = false;

    // public function regionals()
    // {
    //     return $this->hasOne(Regional::class, 'regional_id', 'id');
    // }

    public function spots()
    {
        return $this->belongsTo(Spots::class, 'spot_id');
    }

    public function medicals()
    {
        return $this->belongsTo(Medicals::class, 'doctor_id');
    }

    public function vaccine()
    {
        return $this->belongsTo(Vaccine::class, 'vaccine_id');
    }

    public function society()
    {
        return $this->hasMany(User::class, 'society_id');
    }


    use HasFactory;
}
