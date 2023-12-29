<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicals extends Model
{

    protected $table = 'medicals';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public $timestamps = false;

    use HasFactory;
}
