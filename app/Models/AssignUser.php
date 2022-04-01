<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssignUser extends Model
{

    protected $table = "assign_user";
    
    protected $fillable = [
        'id',
        'order_id',
        'user_id',
        'status'
    ];
    
}
