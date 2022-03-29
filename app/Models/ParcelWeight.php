<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParcelWeight extends Model
{

    protected $table = "parcel_weight";
    
    protected $fillable = [
        'id',
        'title'
    ];
    
}
