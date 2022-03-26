<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackagePlan extends Model
{
    use HasFactory;
    
    protected $table = "packageplans";
    protected $fillable = [
        'package_id',
        'title'
    ];
}
