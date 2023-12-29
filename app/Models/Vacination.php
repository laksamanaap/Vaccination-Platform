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
        return $this->hasMany(Spots::class, 'id');
    }

    public function medicals()
    {
        return $this->hasOne(Medicals::class, 'id');
    }

    public function vaccine()
    {
        return $this->hasOne(Vaccine::class, 'id');
    }

    public function society()
    {
        return $this->hasMany(User::class, 'id');
    }


    use HasFactory;
}
