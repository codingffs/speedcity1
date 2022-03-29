<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class SubFaq extends Model
{
    protected $table = 'subfaq';
    
        protected $fillable = [
        'faq_id', 'title', 'description'
    ];    
}
