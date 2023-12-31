<?php

namespace App\Models;

use App\Models\Spots;
use App\Models\Regional;
use App\Models\Vacination;
use App\Models\SpotVaccines;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Spots extends Model
{

    protected $table = 'spots';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public $timestamps = false;

    public function vaccinations_count()
    {
        return $this->hasMany(Vacination::class, 'spot_id');
    }

    public function regional()
    {
        return $this->hasMany(Regional::class, 'id');

    }

    public function available_vaccine()
    {
        return $this->belongsTo(SpotVaccines::class, 'id');
    }

    use HasFactory;
}
