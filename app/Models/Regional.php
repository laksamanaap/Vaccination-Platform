<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regional extends Model
{

    protected $table = 'regionals';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function spots()
    {
        return $this->hasMany(Spots::class, 'regional_id', 'id');
    }

    use HasFactory;
}
