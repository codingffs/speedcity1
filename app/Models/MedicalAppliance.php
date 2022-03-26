<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalAppliance extends Model
{
    use HasFactory;
    
    protected $table = "medicalappliances";
    protected $fillable = [
        'title',
        'cat_id',
        'image',
        'description',
        'price',
        'type',
    ];
}
