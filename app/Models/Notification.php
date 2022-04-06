<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Notification extends Model
{
        protected $fillable = [
        'user_id', 'title', 'description'
    ];   
    
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->diffForhumans();
    }
}
