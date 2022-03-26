<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Domesticpackages extends Model
{
    protected $fillable = [
        'itemsID', 'source_city', 'destination_city', 'price', 'notes' 
    ];    
}
