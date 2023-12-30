<?php

namespace App\Models;

use App\Models\SpotVaccines;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Regional extends Model
{

    protected $table = 'regionals';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function spots()
    {
        return $this->hasMany(Spots::class, 'regional_id', 'id');
    }

   public function spot_vaccine()
    {
        return $this->belongsTo(SpotVaccines::class, 'id');
    }

    use HasFactory;
}
