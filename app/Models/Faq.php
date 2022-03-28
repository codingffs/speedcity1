<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\SubFaq;


class Faq extends Model
{
    protected $fillable = [
        'title', 'subject'
    ];    

    public function sub_faq() {
        return $this->hasMany(SubFaq::class, 'faq_id', 'id');
    }
}
