<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourierItems extends Model
{
    protected $fillable = [
        'item_name', 'slug', 'description'
    ];    
}
