<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orderstatus extends Model
{

    protected $table = "order_status";
    
    protected $fillable = [
        'id',
        'title'
    ];
    
}
