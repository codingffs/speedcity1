<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoryfaq extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
    ];

    public function sub_faq() {
        return $this->hasMany(Categorysubfaq::class, 'faq_id', 'id');
    }
}
