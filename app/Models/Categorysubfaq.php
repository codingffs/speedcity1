<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorysubfaq extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'faq_id',
        'title',
        'description',
    ];
    
}
