<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categoryfaq;
use App\Models\Categorysubfaq;
use Illuminate\Support\Facades\Auth;

class FaqController extends Controller
{
    public function faqdetail(){
        $faq = Categoryfaq::with(['sub_faq'])->get();
        return $faq;
    }
}
