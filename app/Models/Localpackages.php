<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Localpackages extends Model
{
    protected $fillable = [
        'itemsID', 'source_address', 'destination_address', 'city', 'state', 'zip_code', 'distance', 'price_per_km', 'notes' 
    ];    
}
