<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orderhistory extends Model
{
    use HasFactory;
    
    protected $table = "order_history";

    // protected $primaryKey = 'country_id';

    protected $fillable = [
        'order_id',
        'location',
        'order_status'
    ];
}
