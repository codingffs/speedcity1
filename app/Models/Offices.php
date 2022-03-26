<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offices extends Model
{
    protected $fillable = [
        'branch_name', 'branch_code', 'street', 'city', 'state', 'zip_code', 'contact'
    ];    
}
