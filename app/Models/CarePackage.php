<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarePackage extends Model
{
    use HasFactory;
    
    protected  $table = "carepackages";

    protected $fillable = [
        'id',
        'title',
        'slugname',
        'amount',
        'validity'
    ];
}
