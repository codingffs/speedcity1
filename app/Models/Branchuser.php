<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branchuser extends Model
{
    protected $table = "branch_user";
    
    protected $fillable = [
        'branch_name', 'name', 'mobile', 'image'
    ];    
}
